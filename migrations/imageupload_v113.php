<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v113 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v112',
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['imageupload_multiupload_enable', 0]],
			['config.update', ['imageupload_system_version', '1.1.3']],
			['permission.add', ['u_image_upload_multi', true]],
			['permission.permission_set', ['ADMINISTRATORS', 'u_image_upload_multi', 'group']],
		];
	}
}
