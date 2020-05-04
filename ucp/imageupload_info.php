<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\ucp;

class imageupload_info
{
	function module()
	{
		global $config;

		return [
			'filename'		=> 'dmzx\imageupload\ucp\imageupload_module',
			'title'			=> 'UCP_IMAGEUPLOAD_TITLE',
			'version'		=> $config['imageupload_system_version'],
			'modes'			=> [
				'main'	=> [
					'title'	=> 'UCP_IMAGEUPLOAD_TITLE',
					'auth'	=> 'ext_dmzx/imageupload && acl_u_image_upload_ucp',
					'cat'	=> ['UCP_MAIN']
				],
			],
		];
	}
}
