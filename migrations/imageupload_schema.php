<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_schema extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'image_upload'	=> array(
					'COLUMNS'	=> array(
						'imageupload_id'		=> array('UINT:8', null, 'auto_increment'),
						'imageupload_filename'	=> array('VCHAR', ''),
						'upload_time'			=> array('UINT:8', 0),
						'filesize'				=> array('INT:11', 0),
						'user_id'				=> array('INT:8', 0),
					),
					'PRIMARY_KEY'	=> 'imageupload_id',
				),
			),
		);
	}

	public function revert_schema()
	{
		return 	array(
			'drop_tables' => array(
				$this->table_prefix . 'image_upload',
			),
		);
	}
}
