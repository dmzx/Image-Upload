<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use phpbb\config\config;
use phpbb\user;
use phpbb\template\template;
use phpbb\controller\helper;
use phpbb\auth\auth;
use phpbb\files\factory;

class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var user */
	protected $user;

	/** @var template */
	protected $template;

	/** @var helper */
	protected $helper;

	/** @var auth */
	protected $auth;

	/** @var string */
	protected $php_ext;

	/** @var factory */
	protected $files_factory;

	/**
	* Constructor
	*
	* @param config				$config
	* @param user				$user
	* @param template			$template
	* @param helper				$helper
	* @param auth				$auth
	* @param string				$php_ext
	* @param factory			$files_factory
	*
	*/
	public function __construct(
		config $config,
		user $user,
		template $template,
		helper $helper,
		auth $auth,
		$php_ext,
		factory $files_factory = null
	)
	{
		$this->config 				= $config;
		$this->user					= $user;
		$this->template				= $template;
		$this->helper 				= $helper;
		$this->auth 				= $auth;
		$this->php_ext				= $php_ext;
		$this->files_factory 		= $files_factory;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.viewonline_overwrite_location'		=> 'add_page_viewonline',
			'core.user_setup'							=> 'load_language_on_setup',
			'core.page_header'							=> 'page_header',
			'core.permissions'							=> 'permissions',
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
			'PHPBB_IS_32'				=> ($this->files_factory !== null) ? true : false,
		));
	}

	public function permissions($event)
	{
		$event['permissions'] = array_merge($event['permissions'], array(
			'u_image_upload'	=> array(
				'lang'		=> 'ACL_U_IMAGE_UPLOAD',
				'cat'		=> 'Image Upload'
			),
		));
		$event['categories'] = array_merge($event['categories'], array(
			'Image Upload'	=> 'ACL_U_IMAGEUPLOAD',
		));
	}
}
