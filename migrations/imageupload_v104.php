<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v104 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\imageupload\migrations\imageupload_v103',
		);
	}

	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('imageupload_index_enable', 0)),
			array('config.add', array('imageupload_chat_enable', 0)),
			// Update config
			array('config.update', array('imageupload_system_version', '1.0.4')),
		);
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'users' => array(
					'user_imageupload_index_enable'	=> array('BOOL', 1),
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_columns' => array(
				$this->table_prefix . 'users'	=> array(
					'user_imageupload_index_enable',
				),
			),
		);
	}
}
