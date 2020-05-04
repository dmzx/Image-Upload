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
		return [
			'filename'	=> '\dmzx\imageupload\acp\imageupload_module',
			'title'		=> 'ACP_IMAGE_UPLOAD',
			'modes'		=> [
				'configuration'	=> [
					'title' => 'ACP_IMAGE_UPLOAD_CONFIG',
					'auth' 	=> 'ext_dmzx/imageupload && acl_a_board',
					'cat' 	=> ['ACP_IMAGE_UPLOAD']
				],
			],
		];
	}
}
