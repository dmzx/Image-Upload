<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v106 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\imageupload\migrations\imageupload_v105',
		);
	}

	public function update_data()
	{
		return array(
			// Update config
			array('config.update', array('imageupload_system_version', '1.0.6')),
		);
	}
}
