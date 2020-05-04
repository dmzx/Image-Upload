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
use phpbb\user;
use phpbb\request\request_interface;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\controller\helper;
use phpbb\auth\auth;
use Symfony\Component\DependencyInjection\Container;
use dmzx\imageupload\core\functions;
use phpbb\collapsiblecategories\operator\operator as operator;

class listener implements EventSubscriberInterface
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

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $php_ext;

	/** @var operator */
	protected $operator;

	/**
	* Constructor
	*
	* @param config				$config
	* @param template			$template
	* @param user				$user
	* @param request_interface	$request
	* @param db_interface		$db
	* @param string 			$image_upload_table
	* @param helper				$helper
	* @param auth				$auth
	* @param Container 			$phpbb_container
	* @param functions			$functions
	* @param string				$php_ext
	* @param operator			$operator
	*
	*/
	public function __construct(
		config $config,
		template $template,
		user $user,
		request_interface $request,
		db_interface $db,
		$image_upload_table,
		helper $helper,
		auth $auth,
		Container $phpbb_container,
		functions $functions,
		$php_ext,
		operator $operator = null
	)
	{
		$this->config 				= $config;
		$this->template 			= $template;
		$this->user 				= $user;
		$this->request 				= $request;
		$this->db 					= $db;
		$this->image_upload_table 	= $image_upload_table;
		$this->helper 				= $helper;
		$this->auth 				= $auth;
		$this->phpbb_container 		= $phpbb_container;
		$this->functions 			= $functions;
		$this->php_ext				= $php_ext;
		$this->operator 			= $operator;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.viewonline_overwrite_location'		=> 'add_page_viewonline',
			'core.user_setup'							=> 'load_language_on_setup',
			'core.page_header'							=> 'page_header',
			'core.permissions'							=> 'permissions',
			'core.posting_modify_template_vars'			=> 'posting_display_template',
			'core.index_modify_page_title'				=> 'index_modify_page_title',
			'core.ucp_prefs_personal_data'				=> 'ucp_prefs_get_data',
			'core.ucp_prefs_personal_update_data'		=> 'ucp_prefs_set_data',
		];
	}

	public function add_page_viewonline($event)
	{
		if (strrpos($event['row']['session_page'], 'app.' . $this->php_ext . '/imageupload') === 0)
		{
			$event['location'] = $this->user->lang('IMAGEUPLOAD_UPLOAD_SECTION');
			$event['location_url'] = $this->helper->route('dmzx_imageupload_controller_upload', ['name' => 'index']);
		}
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'dmzx/imageupload',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_header($event)
	{
		$this->template->assign_vars([
			'U_IMAGEUPLOAD_UPLOAD'			=> $this->helper->route('dmzx_imageupload_controller_upload'),
			'IMAGEUPLOAD_USE_UPLOAD'		=> ($this->auth->acl_get('u_image_upload') && $this->config['imageupload_enable']) ? true : false,
			'IMAGEUPLOAD_INDEX_ENABLE'		=> $this->config['imageupload_index_enable'],
			'IMAGEUPLOAD_POST_ENABLE'		=> $this->config['imageupload_post_enable'],
			'IMAGEUPLOAD_POSTTAB_ENABLE'	=> $this->config['imageupload_posttab_enable'],
			'UCP_IMAGEUPLOAD_INDEX'			=> $this->user->data['user_imageupload_index_enable'],
		]);
	}

	public function permissions($event)
	{
		$event['permissions'] = array_merge($event['permissions'], [
			'u_image_upload'	=> [
				'lang'		=> 'ACL_U_IMAGE_UPLOAD',
				'cat'		=> 'Image Upload'
			],'u_image_delete'	=> [
				'lang'		=> 'ACL_U_IMAGE_DELETE',
				'cat'		=> 'Image Upload'
			],'u_image_upload_ucp'	=> [
				'lang'		=> 'ACL_U_IMAGE_UPLOAD_UCP',
				'cat'		=> 'Image Upload'
			],
		]);
		$event['categories'] = array_merge($event['categories'], [
			'Image Upload'	=> 'ACL_U_IMAGEUPLOAD',
		]);
	}

	public function posting_display_template($event)
	{
		if (isset($this->config['imageupload_posttab_enable']) && $this->config['imageupload_posttab_enable'])
		{
			$this->functions->get_uploaded_images($this->user->data['user_id']);
		}
	}

	public function index_modify_page_title($event)
	{
		if (isset($this->config['imageupload_index_enable']) && $this->config['imageupload_index_enable'])
		{
			$this->functions->get_uploaded_images($this->user->data['user_id']);

			if ($this->operator !== null)
			{
				$fid = 'imageupload';
				$this->template->assign_vars([
					'IMAGEUPLOAD_IS_COLLAPSIBLE'	=> true,
					'S_IMAGEUPLOAD_HIDDEN' 			=> $this->operator->is_collapsed($fid),
					'U_IMAGEUPLOAD_COLLAPSE_URL' 	=> $this->operator->get_collapsible_link($fid),
				]);
			}

			if ($this->phpbb_container->has('dmzx.mchat.settings') && $this->config['imageupload_chat_enable'])
			{
				$this->template->assign_var('S_IMAGEUPLOAD_CHAT_INSERT', true);
			}
		}
	}

	public function ucp_prefs_get_data($event)
	{
		$event['data'] = array_merge($event['data'], [
			'imageupload_ucp_index_enable'	=> $this->request->variable('imageupload_ucp_index_enable', (int) $this->user->data['user_imageupload_index_enable']),
		]);

		if (!$event['submit'])
		{
			$this->template->assign_vars([
				'S_UCP_IMAGEUPLOAD_INDEX'	=> $event['data']['imageupload_ucp_index_enable'],
			]);
		}
	}

	public function ucp_prefs_set_data($event)
	{
		$event['sql_ary'] = array_merge($event['sql_ary'], [
			'user_imageupload_index_enable' => $event['data']['imageupload_ucp_index_enable'],
		]);
	}
}
