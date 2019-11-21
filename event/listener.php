<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\event;

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
use phpbb\collapsiblecategories\operator\operator as operator;

class listener implements EventSubscriberInterface
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
		$this->operator 			= $operator;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewonline_overwrite_location'		=> 'add_page_viewonline',
			'core.user_setup'							=> 'load_language_on_setup',
			'core.page_header'							=> 'page_header',
			'core.permissions'							=> 'permissions',
			'core.posting_modify_template_vars'			=> 'posting_display_template',
			'core.index_modify_page_title'				=> 'index_modify_page_title',
			'core.ucp_prefs_personal_data'				=> 'ucp_prefs_get_data',
			'core.ucp_prefs_personal_update_data'		=> 'ucp_prefs_set_data',
		);
	}

	public function add_page_viewonline($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/imageupload') === 0)
		{
			$event['location'] = $this->user->lang('IMAGEUPLOAD_UPLOAD_SECTION');
			$event['location_url'] = $this->helper->route('dmzx_imageupload_controller_upload', array('name' => 'index'));
		}
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'dmzx/imageupload',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		$this->template->assign_vars(array(
			'U_IMAGEUPLOAD_UPLOAD'		=> $this->helper->route('dmzx_imageupload_controller_upload'),
			'IMAGEUPLOAD_USE_UPLOAD'	=> ($this->auth->acl_get('u_image_upload') && $this->config['imageupload_enable']) ? true : false,
			'IMAGEUPLOAD_INDEX_ENABLE'	=> $this->config['imageupload_index_enable'],
			'UCP_IMAGEUPLOAD_INDEX'		=> $this->user->data['user_imageupload_index_enable'],
		));
	}

	public function permissions($event)
	{
		$event['permissions'] = array_merge($event['permissions'], array(
			'u_image_upload'	=> array(
				'lang'		=> 'ACL_U_IMAGE_UPLOAD',
				'cat'		=> 'Image Upload'
			),'u_image_delete'	=> array(
				'lang'		=> 'ACL_U_IMAGE_DELETE',
				'cat'		=> 'Image Upload'
			),
		));
		$event['categories'] = array_merge($event['categories'], array(
			'Image Upload'	=> 'ACL_U_IMAGEUPLOAD',
		));
	}

	public function posting_display_template($event)
	{
		$this->get_uploaded_images();
	}

	public function index_modify_page_title($event)
	{
		$this->get_uploaded_images();

		if ($this->operator !== null)
		{
			$fid = 'imageupload'; // can be any unique string to identify your extension's collapsible element
			$this->template->assign_vars(array(
				'IMAGEUPLOAD_IS_COLLAPSIBLE'	=> true,
				'S_IMAGEUPLOAD_HIDDEN' 			=> $this->operator->is_collapsed($fid),
				'U_IMAGEUPLOAD_COLLAPSE_URL' 	=> $this->operator->get_collapsible_link($fid),
			));
		}

		if ($this->phpbb_container->has('dmzx.mchat.settings') && $this->config['imageupload_chat_enable'])
		{
			$this->template->assign_var('S_IMAGEUPLOAD_CHAT_INSERT', true);
		}
	}

	public function ucp_prefs_get_data($event)
	{
		$event['data'] = array_merge($event['data'], array(
			'imageupload_ucp_index_enable'	=> $this->request->variable('imageupload_ucp_index_enable', (int) $this->user->data['user_imageupload_index_enable']),
		));

		if (!$event['submit'])
		{
			$this->template->assign_vars(array(
				'S_UCP_IMAGEUPLOAD_INDEX'	=> $event['data']['imageupload_ucp_index_enable'],
			));
		}
	}

	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], array(
			'user_imageupload_index_enable' => $event['data']['imageupload_ucp_index_enable'],
		));
	}

	private function get_uploaded_images()
	{
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
			$file_path = $this->ext_path_web . 'img-files/' . $file_name;

			if (function_exists('getimagesize') && is_file($file_path))
			{
				$getimagesize = getimagesize($file_path);
			}
			else
			{
				$getimagesize = array(0, 0);
			}

			$filesize = @filesize($file_path);

			$board_url = generate_board_url();

			$this->template->assign_block_vars('images', array(
				'FILENAME'					=> $row['imageupload_filename'],
				'FILENAME_REAL'				=> $file_name,
				'IMAGEPATH'					=> $file_path,
				'IMAGE_POSTING_BUTTON'		=> $board_url . '/ext/dmzx/imageupload/img-files/' . $file_name,
				'WIDTH'						=> $getimagesize[0],
				'HEIGHT'					=> $getimagesize[1],
				'SIZE'						=> get_formatted_filesize($filesize),
				'IMAGE_USERNAME'			=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'ID'						=> $row['imageupload_id'],
			));
		}
		$this->db->sql_freeresult($result);
	}
}
