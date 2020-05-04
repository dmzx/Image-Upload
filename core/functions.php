<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\core;

use phpbb\template\template;
use phpbb\config\config;
use phpbb\pagination;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\config\db_text;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface as db_interface;

class functions
{
	/** @var template */
	protected $template;

	/** @var config */
	protected $config;

	/** @var pagination */
	protected $pagination;

	/** @var manager */
	protected $ext_manager;

	/** @var path_helper */
	protected $path_helper;

	/** @var db_text */
	protected $config_text;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var db_interface */
	protected $db;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/**
	* Constructor
	*
	* @param template		 	$template
	* @param config				$config
	* @param pagination			$pagination
	* @param manager 			$ext_manager
	* @param path_helper		$path_helper
	* @param db_text			$config_text
	* @param log_interface		$log
	* @param user				$user
	* @param request_interface	$request
	* @param db_interface		$db
	* @param string 			$root_path
	* @param string				$php_ext
	* @param string 			$image_upload_table
	*
	*/
	public function __construct(
		template $template,
		config $config,
		pagination $pagination,
		manager $ext_manager,
		path_helper $path_helper,
		db_text $config_text,
		log_interface $log,
		user $user,
		request_interface $request,
		db_interface $db,
		$root_path,
		$php_ext,
		$image_upload_table
	)
	{
		$this->template 			= $template;
		$this->config 				= $config;
		$this->pagination 			= $pagination;
		$this->ext_manager			= $ext_manager;
		$this->path_helper	 		= $path_helper;
		$this->ext_path 			= $this->ext_manager->get_extension_path('dmzx/imageupload', true);
		$this->ext_path_web 		= $this->path_helper->update_web_root_path($this->ext_path);
		$this->config_text 			= $config_text;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->db 					= $db;
		$this->root_path 			= $root_path;
		$this->php_ext				= $php_ext;
		$this->image_upload_table 	= $image_upload_table;
	}

	public function assign_authors()
	{
		$md_manager = $this->ext_manager->create_extension_metadata_manager('dmzx/imageupload', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = [];
		$author_homepages = [];

		foreach (array_slice($meta['authors'], 0, 2) as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}
		$this->template->assign_vars([
			'IMAGEUPLOAD_DISPLAY_NAME'		=> $meta['extra']['display-name'],
			'IMAGEUPLOAD_AUTHOR_NAMES'		=> implode(' &amp; ', $author_names),
			'IMAGEUPLOAD_AUTHOR_HOMEPAGES'	=> implode(' &amp; ', $author_homepages),
			'IMAGEUPLOAD_VERSION'			=> $this->config['imageupload_system_version'],
		]);

		return;
	}

	public function allowed_extensions()
	{
		$allowed_extensions = [];

		$allowed_extensions_list = $this->config_text->get_array([
			'imageupload_allowed_extensions',
		]);

		$allowed_extensions = explode(',', $allowed_extensions_list['imageupload_allowed_extensions']);

		return $allowed_extensions;
	}

	public function log_message($log_message, $title)
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_message, time(), array($title));
	}

	public function remove_dir($selected_dir)
	{
		$files = glob($selected_dir. '/*');

		foreach ($files as $file)
		{
			is_dir($file) ? $this->remove_dir($file) : unlink($file);
		}
		@rmdir($selected_dir);

		return;
	}

	public function count_image_user_id($user_id)
	{
		$sql = 'SELECT COUNT(*) as image_count
			FROM ' . $this->image_upload_table . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$image['image_count'] = $this->db->sql_fetchfield('image_count');
		$this->db->sql_freeresult($result);

		return $image['image_count'];
	}

	public function get_uploaded_images($user_id, $tpl_loopname = 'imageupload')
	{
		$sql_start 	= $this->request->variable($tpl_loopname . '_start', 0);
		$sql_limit 	= $this->config['posts_per_page'];

		$sql = 'SELECT im.*, u.user_id, u.username, u.user_colour
			FROM ' . $this->image_upload_table . ' im, ' . USERS_TABLE . ' u
			WHERE u.user_id = im.user_id
				AND im.user_id = ' . (int) $user_id . '
			ORDER BY upload_time DESC';
		$result = $this->db->sql_query_limit($sql, $sql_limit, $sql_start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$file_name = $row['imageupload_realname'];
			$file_path = $this->ext_path_web . 'img-files/' . $file_name;

			if (function_exists('getimagesize') && is_file($file_path))
			{
				$getimagesize = getimagesize($file_path);
			}
			else
			{
				$getimagesize = [0, 0];
			}

			$filesize = @filesize($file_path);

			$board_url = generate_board_url();

			$this->template->assign_block_vars('images', [
				'FILENAME'					=> $row['imageupload_filename'],
				'FILENAME_REAL'				=> $file_name,
				'IMAGEPATH'					=> $file_path,
				'IMAGE_POSTING_BUTTON'		=> $board_url . '/ext/dmzx/imageupload/img-files/' . $file_name,
				'WIDTH'						=> $getimagesize[0],
				'HEIGHT'					=> $getimagesize[1],
				'SIZE'						=> get_formatted_filesize($filesize),
				'IMAGE_USERNAME'			=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'ID'						=> $row['imageupload_id'],
			]);
		}
		$this->db->sql_freeresult($result);

		$url_params = explode('&', $this->user->page['query_string']);
		$append_params = [];
		foreach ($url_params as $param)
		{
			if (!$param)
			{
				continue;
			}

			if (strpos($param, '=') === false)
			{
				$append_params[$param] = '1';
				continue;
			}

			list($name, $value) = explode('=', $param);

			if ($name != $tpl_loopname . '_start')
			{
				$append_params[$name] = $value;
			}
		}

		$pagination_url = append_sid($this->root_path . $this->user->page['page_name'], $append_params);

		$this->pagination->generate_template_pagination($pagination_url, 'pagination', $tpl_loopname . '_start', $this->count_image_user_id($this->user->data['user_id']), $sql_limit, $sql_start);

		$this->template->assign_vars([
			'IMAGEUPLOAD_PAG_IMAGES'	=> $this->user->lang('IMAGEUPLOAD_IMAGES_PAGINATION', (int) $this->count_image_user_id($this->user->data['user_id'])),
		]);
	}
}
