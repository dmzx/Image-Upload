<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2019 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v108 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\imageupload\migrations\imageupload_v107',
		];
	}

	public function update_data()
	{
		return [
			// Update config
			['config.update', ['imageupload_system_version', '1.0.8']],
			// Add config_text
			['config_text.add',	['imageupload_allowed_extensions', $this->allowed_extensions()]],
		];
	}

	private function allowed_extensions()
	{
		$allowed_extensions = [
			'gif','jpg','jpeg','png'
		];

		$allowed_extensions = implode(",", $allowed_extensions);

		return $allowed_extensions;
	}
}
