<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\ucp;

class imageupload_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $user;

		// Add the lang file
		$user->add_lang_ext('dmzx/imageupload', 'imageupload_upc');

		// Set template
		$this->tpl_name = 'ucp_imageupload';
		$this->page_title = 'IMAGEUPLOAD_UCP';

		// Get an instance of the UCP controller and display the options
		$controller = $phpbb_container->get('dmzx.imageupload.ucp.controller');
		$controller->$mode($this->u_action);
	}
}
