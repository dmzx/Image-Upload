<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\acp;

class imageupload_info
{
	function module()
	{
		return array(
			'filename'	=> '\dmzx\imageupload\acp\imageupload_module',
			'title'		=> 'ACP_IMAGE_UPLOAD',
			'modes'		=> array(
				'configuration'	=> array(
					'title' => 'ACP_IMAGE_UPLOAD_CONFIG',
					'auth' 	=> 'ext_dmzx/imageupload && acl_a_board',
					'cat' 	=> array('ACP_IMAGE_UPLOAD')
				),
			),
		);
	}
}
