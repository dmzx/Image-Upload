<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use phpbb\config\config;
use phpbb\template\template;
use phpbb\log\log_interface;
use phpbb\user;
use phpbb\request\request_interface;

class admin_controller
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

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor
	 *
	 * @param config				$config
	 * @param template				$template
	 * @param log_interface			$log
	 * @param user					$user
	 * @param request_interface		$request
	 */
	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request
	)
	{
		$this->config 		= $config;
		$this->template 	= $template;
		$this->log 			= $log;
		$this->user 		= $user;
		$this->request 		= $request;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		$this->user->add_lang_ext('dmzx/imageupload', 'acp_imageupload');

		add_form_key('acp_imageupload');

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
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_IMAGEUPLOAD_SETTINGS');

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

		$this->template->assign_vars(array(
			'ACP_IMAGEUPLOAD_VERSION'			=> $this->config['imageupload_system_version'],
			'ACP_IMAGEUPLOAD_ENABLE'			=> $this->config['imageupload_enable'],
			'ACP_IMAGEUPLOAD_NUMBER'			=> $this->config['imageupload_number'],
			'ACP_IMAGEUPLOAD_ALLOWED_SIZE'		=> sprintf($this->user->lang['ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'], $max_filesize, $unit),

			'U_ACTION'							=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('imageupload_enable', $this->request->variable('imageupload_enable', 1));
		$this->config->set('imageupload_number', $this->request->variable('imageupload_number', 2));
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
