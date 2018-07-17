<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_install extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// Add configs
			array('config.add', array('imageupload_system_version', '1.0.1')),
			array('config.add', array('imageupload_enable', 1)),
			array('config.add', array('imageupload_number', 2)),
			// Add permission
			array('permission.add', array('u_image_upload', true)),
			// Set permission
			array('permission.permission_set', array('ADMINISTRATORS', 'u_image_upload', 'group')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_IMAGE_UPLOAD'
			)),
			array('module.add', array(
				'acp',
				'ACP_IMAGE_UPLOAD',
				array(
					'module_basename'	=> '\dmzx\imageupload\acp\imageupload_module',
					'modes'	=> array(
						'configuration'
					),
				),
			)),
		);
	}

	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'image_upload'	=> array(
					'COLUMNS'	=> array(
						'imageupload_id'		=> array('UINT:8', null, 'auto_increment'),
						'imageupload_filename'	=> array('VCHAR', ''),
						'imageupload_realname'	=> array('VCHAR', ''),
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
