<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2021 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v118 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v117',
		];
	}

	public function update_data()
	{
		return [
			['config.add', ['imageupload_mchat_enable', 0]],
			['config.add', ['imageupload_nav_enable', 1]],
			['config.add', ['imageupload_center_enable', 0]],
			['config.update', ['imageupload_system_version', '1.1.8']],
		];
	}
}
