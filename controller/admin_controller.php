<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\pagination;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\filesystem\filesystem;
use Symfony\Component\DependencyInjection\Container;
use phpbb\config\db_text;
use dmzx\imageupload\core\functions;

class admin_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var request_interface */
	protected $request;

	/** @var db_interface */
	protected $db;

	/** @var pagination */
	protected $pagination;

	/** @var manager */
	protected $ext_manager;

	/** @var path_helper */
	protected $path_helper;

	/** @var filesystem */
	protected $filesystem;

	/** @var Container */
	protected $phpbb_container;

	/** @var db_text */
	protected $config_text;

	/** @var functions */
	protected $functions;

	/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param template				$template
	 * @param user					$user
	 * @param request_interface		$request
	 * @param db_interface			$db
	 * @param pagination			$pagination
	 * @param manager				$ext_manager
	 * @param path_helper			$path_helper
	 * @param filesystem			$filesystem
	 * @param Container	 			$phpbb_container
	 * @param db_text				$config_text
	 * @param functions				$functions
	 * @param string 				$image_upload_table
	 */
	public function __construct(
		config $config,
		template $template,
		user $user,
		request_interface $request,
		db_interface $db,
		pagination $pagination,
		manager $ext_manager,
		path_helper $path_helper,
		filesystem $filesystem,
		Container $phpbb_container,
		db_text $config_text,
		functions $functions,
		$image_upload_table
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->db 					= $db;
		$this->pagination 			= $pagination;
		$this->ext_manager	 		= $ext_manager;
		$this->path_helper	 		= $path_helper;
		$this->filesystem			= $filesystem;
		$this->phpbb_container 		= $phpbb_container;
		$this->config_text 			= $config_text;
		$this->functions 			= $functions;
		$this->image_upload_table 	= $image_upload_table;
		$this->ext_path 			= $this->ext_manager->get_extension_path('dmzx/imageupload', true);
		$this->ext_path_web 		= $this->path_helper->update_web_root_path($this->ext_path);

		$this->user->add_lang_ext('dmzx/imageupload', 'acp_imageupload');
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options($id, $mode)
	{
		$start		= $this->request->variable('start', 0);
		$sort_days	= $this->request->variable('st', 0);
		$sort_key	= $this->request->variable('sk', 'upload_time');
		$sort_dir	= $this->request->variable('sd', 'd');
		$action 	= $this->request->variable('action', '');
		$number		= $this->config['topics_per_page'];

		add_form_key('acp_imageupload');

		$allowed_extensions_list = $this->config_text->get_array([
			'imageupload_allowed_extensions',
		]);

		$allowed_extensions_array = explode(',', trim($allowed_extensions_list['imageupload_allowed_extensions']));

		sort($allowed_extensions_array);

		$imageupload_allowed_extensions = implode(',', $allowed_extensions_array);

		// Is the form being submitted to us?
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('acp_imageupload'))
			{
				trigger_error('FORM_INVALID');
			}

			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->functions->log_message('LOG_IMAGEUPLOAD_SETTINGS', '');

			trigger_error($this->user->lang['ACP_IMAGEUPLOAD_SAVED'] . adm_back_link($this->u_action));
		}

		$max_filesize = @ini_get('upload_max_filesize');
		$unit = 'MB';

		if (!empty($max_filesize))
		{
			$unit = strtolower(substr($max_filesize, -1, 1));
			$max_filesize = (int) $max_filesize;
			$unit = ($unit == 'k') ? 'KB' : (($unit == 'g') ? 'GB' : 'MB');
		}

		// Total number of images
		$sql = 'SELECT COUNT(imageupload_id) AS total_imageupload, SUM(filesize) AS total_filesize
			FROM ' . $this->image_upload_table;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$total_imageupload = $row['total_imageupload'];
		$total_filesize = $row['total_filesize'];
		$this->db->sql_freeresult($result);

		$limit_days = [
			0 	=> $this->user->lang['ALL_ENTRIES'],
			1 	=> $this->user->lang['1_DAY'],
			7 	=> $this->user->lang['7_DAYS'],
			14 	=> $this->user->lang['2_WEEKS'],
			30 	=> $this->user->lang['1_MONTH'],
			90 	=> $this->user->lang['3_MONTHS'],
			180 => $this->user->lang['6_MONTHS'],
			365 => $this->user->lang['1_YEAR']
		];
		$sort_by_text = [
			'd' => $this->user->lang['ACP_IMAGEUPLOAD_SORT_DATE'],
			't' => $this->user->lang['ACP_IMAGEUPLOAD_TITLE'],
			'c' => $this->user->lang['ACP_IMAGEUPLOAD_SORT_USERNAME'],
			's' => $this->user->lang['ACP_IMAGEUPLOAD_SIZE']
		];
		$sort_by_sql = [
			'd' => 'upload_time',
			't' => 'imageupload_filename',
			'c' => 'username',
			's' => 'filesize'
		];
		$s_limit_days = $s_sort_key = $s_sort_dir = $u_sort_param = '';
		gen_sort_selects($limit_days, $sort_by_text, $sort_days, $sort_key, $sort_dir, $s_limit_days, $s_sort_key, $s_sort_dir, $u_sort_param);
		$sql_sort_order = $sort_by_sql[$sort_key] . ' ' . (($sort_dir == 'd') ? 'DESC' : 'ASC');

		// List all images
		$sql = 'SELECT im.*, u.user_id, u.username, u.user_colour
			FROM ' . $this->image_upload_table . ' im, ' . USERS_TABLE . ' u
			WHERE u.user_id = im.user_id
			ORDER BY ' . $sql_sort_order;
		$result = $this->db->sql_query_limit($sql, $number, $start);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$file_name = $row['imageupload_realname'];
			$image_name = $row['imageupload_filename'];
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

			$this->template->assign_block_vars('images', [
				'FILENAME'			=> $row['imageupload_filename'],
				'FILENAME_REAL'		=> $file_name,
				'IMAGEPATH'			=> $file_path,
				'WIDTH'				=> $getimagesize[0],
				'HEIGHT'			=> $getimagesize[1],
				'SIZE'				=> get_formatted_filesize($filesize),
				'IMAGE_USERNAME'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'U_DELETE'			=> $this->u_action . '&amp;action=delete&amp;id=' . $row['imageupload_id']
			]);
		}
		$this->db->sql_freeresult($result);

		$base_url = $this->u_action;
		//Start pagination
		$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $total_imageupload, $number, $start);

		$this->template->assign_vars([
			'ACP_IMAGEUPLOAD_VERSION'				=> $this->config['imageupload_system_version'],
			'ACP_IMAGEUPLOAD_ENABLE'				=> $this->config['imageupload_enable'],
			'ACP_IMAGEUPLOAD_EXT'					=> $imageupload_allowed_extensions,
			'ACP_IMAGEUPLOAD_NAV_ENABLE'			=> $this->config['imageupload_nav_enable'],
			'ACP_IMAGEUPLOAD_INDEX_ENABLE'			=> $this->config['imageupload_index_enable'],
			'ACP_IMAGEUPLOAD_CENTER_ENABLE'			=> $this->config['imageupload_center_enable'],
			'ACP_IMAGEUPLOAD_NUMBER'				=> $this->config['imageupload_number'],
			'ACP_IMAGEUPLOAD_MAX_NUMBER'			=> $max_filesize,
			'ACP_IMAGEUPLOAD_ALLOWED_SIZE'			=> $this->user->lang('ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE', $max_filesize, $unit),
			'ACP_TOTAL_IMAGES'						=> $this->user->lang('ACP_MULTI_IMAGES', (int) $total_imageupload),
			'ACP_IMAGEUPLOAD_MCHAT_ENABLE'			=> $this->config['imageupload_mchat_enable'],
			'ACP_IMAGEUPLOAD_CHAT_ENABLE'			=> $this->config['imageupload_chat_enable'],
			'ACP_IMAGEUPLOAD_POST_ENABLE'			=> $this->config['imageupload_post_enable'],
			'ACP_IMAGEUPLOAD_POSTTAB_ENABLE'		=> $this->config['imageupload_posttab_enable'],
			'ACP_IMAGEUPLOAD_MULTI_ENABLE'			=> $this->config['imageupload_multiupload_enable'],
			'ACP_IMAGEUPLOAD_ENABLE_DIRECT_LINK'	=> $this->config['imageupload_enable_direct_link'],
			'ACP_IMAGEUPLOAD_ENABLE_URL_LINK'		=> $this->config['imageupload_enable_url_link'],
			'ACP_IMAGEUPLOAD_ENABLE_IMG_LINK'		=> $this->config['imageupload_enable_img_link'],
			'ACP_IMAGEUPLOAD_ENABLE_URL_IMG_LINK'	=> $this->config['imageupload_enable_url_img_link'],
			'TOTAL_FILE_SIZE'						=> get_formatted_filesize($total_filesize),
			'S_SELECT_SORT_DIR'						=> $s_sort_dir,
			'S_SELECT_SORT_KEY'						=> $s_sort_key,
			'U_ACTION'								=> $this->u_action,

		]);

		if ($this->phpbb_container->has('dmzx.mchat.settings'))
		{
			$this->template->assign_var('IMAGEUPLOAD_CHAT_VIEW', true);
		}

		switch ($action)
		{
			case 'delete':
				$image_id = $this->request->variable('id', 0);

				if (!$image_id)
				{
					trigger_error($this->user->lang('ACP_IMAGEUPLOAD_NOT_SELECTED') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if (confirm_box(true))
				{
					$sql = 'SELECT imageupload_realname, imageupload_filename
						FROM ' . $this->image_upload_table . '
						WHERE imageupload_id = ' . (int) $image_id;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$file_name = $row['imageupload_realname'];
					$image_name = $row['imageupload_filename'];
					$this->db->sql_freeresult($result);

					$delete_file = $this->ext_path_web . 'img-files' . $file_name;

					# Delete the image
					if ($this->filesystem->exists($delete_file))
					{
						$dir = dirname(dirname($file_name));
						$this->filesystem->remove($delete_file);
						$this->functions->remove_dir($this->ext_path_web . 'img-files' . $dir);
					}

					$sql = 'DELETE FROM ' . $this->image_upload_table . '
						WHERE imageupload_id = ' . (int) $image_id;
					$this->db->sql_query($sql);

					// Log message
					$this->functions->log_message('LOG_IMAGEUPLOAD_DELETED', $image_name);
				}
				else
				{
					confirm_box(false, $this->user->lang['ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'], build_hidden_fields([
							'i'		 => $id,
							'mode'	 => $mode,
							'id'	 => $image_id,
							'action' => 'delete',
						])
					);
				}
				redirect($this->u_action);
			break;
		}
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$imageupload_allowed_extensions = $this->request->variable('imageupload_allowed_extensions', '', true);

		$this->config->set('imageupload_enable', $this->request->variable('imageupload_enable', 1));
		$this->config->set('imageupload_number', $this->request->variable('imageupload_number', 2));
		$this->config->set('imageupload_nav_enable', $this->request->variable('imageupload_nav_enable', 1));
		$this->config->set('imageupload_index_enable', $this->request->variable('imageupload_index_enable', 0));
		$this->config->set('imageupload_center_enable', $this->request->variable('imageupload_center_enable', 0));
		$this->config->set('imageupload_mchat_enable', $this->request->variable('imageupload_mchat_enable', 0));
		$this->config->set('imageupload_chat_enable', $this->request->variable('imageupload_chat_enable', 0));
		$this->config->set('imageupload_post_enable', $this->request->variable('imageupload_post_enable', 0));
		$this->config->set('imageupload_posttab_enable', $this->request->variable('imageupload_posttab_enable', 0));
		$this->config->set('imageupload_multiupload_enable', $this->request->variable('imageupload_multiupload_enable', 0));
		$this->config->set('imageupload_enable_direct_link', $this->request->variable('imageupload_enable_direct_link', 0));
		$this->config->set('imageupload_enable_url_link', $this->request->variable('imageupload_enable_url_link', 0));
		$this->config->set('imageupload_enable_img_link', $this->request->variable('imageupload_enable_img_link', 0));
		$this->config->set('imageupload_enable_url_img_link', $this->request->variable('imageupload_enable_url_img_link', 0));

		$this->config_text->set_array([
			'imageupload_allowed_extensions' => $imageupload_allowed_extensions,
		]);
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
