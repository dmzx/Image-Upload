<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\migrations;

class imageupload_v105 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\dmzx\imageupload\migrations\imageupload_v104',
		);
	}

	public function update_data()
	{
		return array(
			// Update config
			array('config.update', array('imageupload_system_version', '1.0.5')),
			// Add permission
			array('permission.add', array('u_image_delete', true)),
			// Set permission
			array('permission.permission_set', array('ADMINISTRATORS', 'u_image_delete', 'group')),
			//UCP module
			array('module.add', array(
				'ucp',
				0,
				'UCP_IMAGEUPLOAD_TITLE'
			)),
			array('module.add', array(
				'ucp',
				'UCP_IMAGEUPLOAD_TITLE',
				array(
					'module_basename'	=> '\dmzx\imageupload\ucp\imageupload_module',
					'auth'				=> 'ext_dmzx/imageupload',
					'modes'				=> array('main'),
				),
			)),
		);
	}
}
