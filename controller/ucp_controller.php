<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\pagination;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\controller\helper;
use phpbb\auth\auth;
use Symfony\Component\DependencyInjection\Container;
use phpbb\files\factory;
use phpbb\collapsiblecategories\operator\operator as operator;

class ucp_controller
{
	/** @var config */
	protected $config;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

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

	/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/** @var helper */
	protected $helper;

	/** @var auth */
	protected $auth;

	/** @var Container */
	protected $phpbb_container;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $root_path;

	/** @var factory */
	protected $files_factory;

	/** @var operator */
	protected $operator;

	/**
	* Constructor
	*
	* @param config				$config
	* @param template			$template
	* @param log_interface		$log
	* @param user				$user
	* @param request_interface	$request
	* @param db_interface		$db
	* @param pagination			$pagination
	* @param manager			$ext_manager
	* @param path_helper		$path_helper
	* @param string 			$image_upload_table
	* @param helper				$helper
	* @param auth				$auth
	* @param Container 			$phpbb_container
	* @param string				$php_ext
	* @param string 			$root_path
	* @param factory			$files_factory
	* @param operator			$operator
	*
	*/
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request,
		db_interface $db,
		pagination $pagination,
		manager $ext_manager,
		path_helper $path_helper,
		$image_upload_table,
		helper $helper,
		auth $auth,
		Container $phpbb_container,
		$php_ext,
		$root_path,
		factory $files_factory = null,
		operator $operator = null
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->db 					= $db;
		$this->pagination 			= $pagination;
		$this->ext_manager	 		= $ext_manager;
		$this->path_helper	 		= $path_helper;
		$this->image_upload_table 	= $image_upload_table;
		$this->ext_path 			= $this->ext_manager->get_extension_path('dmzx/imageupload', true);
		$this->ext_path_web 		= $this->path_helper->update_web_root_path($this->ext_path);
		$this->helper 				= $helper;
		$this->auth 				= $auth;
		$this->phpbb_container 		= $phpbb_container;
		$this->php_ext				= $php_ext;
		$this->root_path 			= $root_path;
		$this->files_factory 		= $files_factory;
		$this->operator 			= $operator;
	}

	public function main()
	{
		add_form_key('imageupload_ucp');

		$mode = $this->request->variable('mode', '');

		if ($this->auth->acl_get('u_image_delete'))
		{
			$this->template->assign_var('S_IMAGEUPLOAD_DELETE_IMAGE', true);
		}

		switch ($mode)
		{
			case 'delete':

				if (!$this->auth->acl_get('u_image_delete'))
				{
					throw new http_exception(403, 'NOT_AUTHORISED');
				}

				$delete_id = $this->request->variable('imageupload_id', 0);

				$s_hidden_fields = build_hidden_fields(array(
					'imageupload_id'	=> $delete_id,
					'mode'				=> 'delete'
				));

				if (confirm_box(true))
				{
					$sql = 'SELECT imageupload_realname, imageupload_filename
						FROM ' . $this->image_upload_table . '
						WHERE imageupload_id = ' . (int) $delete_id;
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);
					$file_name = $row['imageupload_realname'];
					$image_name = $row['imageupload_filename'];
					$this->db->sql_freeresult($result);

					$delete_file = $this->ext_path_web . 'files/' . $file_name;

					@unlink($delete_file);

					$sql = 'DELETE FROM ' . $this->image_upload_table . '
						WHERE imageupload_id = ' . (int) $delete_id;
					$this->db->sql_query($sql);

					// Add action to the user log
					$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_IMAGE_DELETED', time(), array($image_name, $file_name, 'reportee_id' => $this->user->data['user_id'], $this->user->data['username']));

				 	$meta_info = append_sid("{$this->root_path}ucp.{$this->php_ext}");
					$message = $this->user->lang['IMAGEUPLOAD_UCP_DELETED_IMAGES'];
					meta_refresh(1, $meta_info);
					$message .= '<br /><br />' . $this->user->lang('IMAGEUPLOAD_PAGE_RETURN', '<a href="' . $meta_info . '">', '</a>');
					trigger_error($message);
				}
				else
				{
					if ($this->request->is_set_post('cancel'))
					{
						redirect(append_sid("{$this->root_path}ucp.{$this->php_ext}"));
					}
					else
					{
						confirm_box(false, $this->user->lang['IMAGEUPLOAD_UCP_DELETE_IMAGES'], build_hidden_fields(array(
								'imageupload_id'		=> $delete_id,
								'action'				=> 'delete',
							))
						);
					}
				}
			break;
			default:
				// List all images
				$sql = 'SELECT im.*, u.user_id, u.username, u.user_colour
					FROM ' . $this->image_upload_table . ' im, ' . USERS_TABLE . ' u
					WHERE u.user_id = im.user_id
						AND im.user_id = ' . (int) $this->user->data['user_id'] . '
					ORDER BY upload_time DESC';
				$result = $this->db->sql_query($sql);

				while ($row = $this->db->sql_fetchrow($result))
				{
					$file_name = $row['imageupload_realname'];

					if (function_exists('getimagesize'))
					{
						$getimagesize = getimagesize($this->ext_path_web . 'files/' . $file_name);
					}
					else
					{
						$getimagesize = array(0, 0);
					}

					$filesize = @filesize($this->ext_path_web . 'files/' . $file_name);

					$board_url = generate_board_url();

					$this->template->assign_block_vars('images', array(
						'FILENAME'					=> $row['imageupload_filename'],
						'FILENAME_REAL'				=> $file_name,
						'IMAGEPATH'					=> $this->ext_path_web . 'files/' . $file_name,
						'IMAGE_POSTING_BUTTON'		=> $board_url . '/ext/dmzx/imageupload/files/' . $file_name,
						'WIDTH'						=> $getimagesize[0],
						'HEIGHT'					=> $getimagesize[1],
						'SIZE'						=> get_formatted_filesize($filesize),
						'IMAGE_USERNAME'			=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
						'ID'						=> $row['imageupload_id'],
						'U_DELETES'					=> $this->helper->route('dmzx_imageupload_controller_ucp_controller', array('mode' => 'delete', 'imageupload_id' => $row['imageupload_id'])),
					));
				}
				$this->db->sql_freeresult($result);

			break;
		}
	}
}
