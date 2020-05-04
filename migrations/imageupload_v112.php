<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v112 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v111',
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['imageupload_post_enable', 0]],
			['config.add', ['imageupload_posttab_enable', 0]],
			['config.update', ['imageupload_system_version', '1.1.2']],
			['permission.add', ['u_image_upload_ucp', true]],
			['permission.permission_set', ['REGISTERED', 'u_image_upload_ucp', 'group']],
			['permission.permission_set', ['ADMINISTRATORS', 'u_image_upload_ucp', 'group']],
		];
	}
}
