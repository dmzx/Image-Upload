<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2023 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v200 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v119',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['imageupload_system_version', '2.0.0']],
		];
	}
}
