<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_data extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			// Update configs
			array('config.add', array('imageupload_system_version', '1.0.0')),
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
}
