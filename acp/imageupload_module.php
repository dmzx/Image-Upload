<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\acp;

class imageupload_module
{
	public $u_action;

	function main($id, $mode)
	{
		global $phpbb_container, $request, $user;

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('dmzx.imageupload.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		switch ($mode)
		{
			case 'configuration':
				// Load a template from adm/style for our ACP page
				$this->tpl_name = 'acp_imageupload';
				// Set the page title for our ACP page
				$this->page_title = $user->lang['ACP_IMAGE_UPLOAD_CONFIG'];
				// Load the display options handle in the admin controller
				$admin_controller->display_options();
			break;
		}
	}
}
