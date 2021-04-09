<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use phpbb\exception\http_exception;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\filesystem\filesystem;
use phpbb\auth\auth;
use phpbb\pagination;
use phpbb\config\config;
use dmzx\imageupload\core\functions;

class ucp_controller
{
	protected $subfolders;
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

	/** @var manager */
	protected $ext_manager;

	/** @var path_helper */
	protected $path_helper;

	/** @var filesystem */
	protected $filesystem;

/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/** @var auth */
	protected $auth;

	/** @var pagination */
	protected $pagination;

	/** @var config */
	protected $config;

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	* Constructor
	*
	* @param template			$template
	* @param log_interface		$log
	* @param user				$user
	* @param request_interface	$request
	* @param db_interface		$db
	* @param manager			$ext_manager
	* @param path_helper		$path_helper
	* @param filesystem			$filesystem
	* @param string 			$image_upload_table
	* @param auth				$auth
	* @param pagination			$pagination
	* @param config				$config
	* @param functions			$functions
	* @param string 			$root_path
	* @param string				$php_ext
	*
	*/
	public function __construct(
		template $template,
		log_interface $log,
		user $user,
		request_interface $request,
		db_interface $db,
		manager $ext_manager,
		path_helper $path_helper,
		filesystem $filesystem,
		$image_upload_table,
		auth $auth,
		pagination $pagination,
		config $config,
		functions $functions,
		$root_path,
		$php_ext
	)
	{
		$this->template 			= $template;
		$this->log 					= $log;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->db 					= $db;
		$this->ext_manager	 		= $ext_manager;
		$this->path_helper	 		= $path_helper;
		$this->filesystem			= $filesystem;
		$this->image_upload_table 	= $image_upload_table;
		$this->ext_path 			= $this->ext_manager->get_extension_path('dmzx/imageupload', true);
		$this->ext_path_web 		= $this->path_helper->update_web_root_path($this->ext_path);
		$this->auth 				= $auth;
		$this->pagination 			= $pagination;
		$this->config 				= $config;
		$this->functions 			= $functions;
		$this->root_path 			= $root_path;
		$this->php_ext				= $php_ext;
	}

	public function main()
	{
		add_form_key('imageupload_ucp');

		$mode = $this->request->variable('mode', '', true);

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

				$sql = 'SELECT imageupload_realname, imageupload_filename
					FROM ' . $this->image_upload_table . '
					WHERE imageupload_id = ' . (int) $delete_id;
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$file_name = $row['imageupload_realname'];
				$image_name = $row['imageupload_filename'];
				$this->db->sql_freeresult($result);

				$delete_file = $this->root_path . 'ext/dmzx/imageupload/img-files' . $file_name;

				if (file_exists($delete_file) && $file_name != '')
				{
					if (confirm_box(true))
					{
						# Delete the image
						if ($this->filesystem->exists($delete_file))
						{
							$dir = dirname(dirname($file_name));
							$this->filesystem->remove($delete_file);
							$this->functions->remove_dir($this->root_path . 'ext/dmzx/imageupload/img-files' . $dir);
						}

						$sql = 'DELETE FROM ' . $this->image_upload_table . '
							WHERE imageupload_id = ' . (int) $delete_id;
						$this->db->sql_query($sql);

						// Add action to the user log
						$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_USER_IMAGE_DELETED', time(), [$image_name, $file_name, 'reportee_id' => $this->user->data['user_id'], $this->user->data['username']]);

						$meta_info = append_sid("{$this->root_path}ucp.php?i=-dmzx-imageupload-ucp-imageupload_module&mode=main");
						$message = $this->user->lang['IMAGEUPLOAD_UCP_DELETED_IMAGES'];
						meta_refresh(1, $meta_info);
						$message .= '<br /><br />' . $this->user->lang('IMAGEUPLOAD_PAGE_RETURN', '<a href="' . $meta_info . '">', '</a>');
						trigger_error($message);
					}
					else
					{
						if ($this->request->is_set_post('cancel'))
						{
							redirect(append_sid("{$this->root_path}ucp.php?i=-dmzx-imageupload-ucp-imageupload_module&mode=main"));
						}
						else
						{
							confirm_box(false, $this->user->lang['IMAGEUPLOAD_UCP_DELETE_IMAGES'], build_hidden_fields([
									'imageupload_id'		=> $delete_id,
									'action'				=> 'delete',
								])
							);
						}
					}
				}
				else
				{
					redirect(append_sid("{$this->root_path}ucp.php?i=-dmzx-imageupload-ucp-imageupload_module&mode=main"));
				}
			break;
			default:

				$this->functions->get_uploaded_images($this->user->data['user_id']);

			break;
		}
	}
}
