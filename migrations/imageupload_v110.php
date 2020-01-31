<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v110 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v109',
		];
	}

	public function update_data()
	{
		return [
			// Update config
			['config.update', ['imageupload_system_version', '1.1.0']],
			// Add config
			['config.add', ['imageupload_enable_direct_link', 1]],
			['config.add', ['imageupload_enable_url_link', 1]],
			['config.add', ['imageupload_enable_img_link', 1]],
			['config.add', ['imageupload_enable_url_img_link', 1]],
		];
	}
}
