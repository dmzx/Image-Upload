<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\core;

use phpbb\template\template;
use phpbb\config\config;
use phpbb\extension\manager;
use phpbb\config\db_text;
use phpbb\log\log_interface;
use phpbb\user;

class functions
{
	/** @var template */
	protected $template;

	/** @var config */
	protected $config;

	/** @var manager */
	protected $extension_manager;

	/** @var db_text */
	protected $config_text;

	/** @var log_interface */
	protected $log;

	/** @var user */
	protected $user;

	/**
	* Constructor
	*
	* @param template		 	$template
	* @param config				$config
	* @param manager 			$extension_manager
	* @param db_text			$config_text
	* @param log_interface		$log
	* @param user				$user
	*
	*/
	public function __construct(
		template $template,
		config $config,
		manager $extension_manager,
		db_text $config_text,
		log_interface $log,
		user $user
	)
	{
		$this->template 			= $template;
		$this->config 				= $config;
		$this->extension_manager	= $extension_manager;
		$this->config_text 			= $config_text;
		$this->log 					= $log;
		$this->user 				= $user;
	}

	public function assign_authors()
	{
		$md_manager = $this->extension_manager->create_extension_metadata_manager('dmzx/imageupload', $this->template);
		$meta = $md_manager->get_metadata();
		$author_names = array();
		$author_homepages = array();

		foreach (array_slice($meta['authors'], 0, 2) as $author)
		{
			$author_names[] = $author['name'];
			$author_homepages[] = sprintf('<a href="%1$s" title="%2$s">%2$s</a>', $author['homepage'], $author['name']);
		}
		$this->template->assign_vars(array(
			'IMAGEUPLOAD_DISPLAY_NAME'		=> $meta['extra']['display-name'],
			'IMAGEUPLOAD_AUTHOR_NAMES'		=> implode(' &amp; ', $author_names),
			'IMAGEUPLOAD_AUTHOR_HOMEPAGES'	=> implode(' &amp; ', $author_homepages),
			'IMAGEUPLOAD_VERSION'			=> $this->config['imageupload_system_version'],
		));

		return;
	}

	public function allowed_extensions()
	{
		$allowed_extensions = [];

		$allowed_extensions_list = $this->config_text->get_array([
			'imageupload_allowed_extensions',
		]);

		$allowed_extensions = explode(',', $allowed_extensions_list['imageupload_allowed_extensions']);

		return $allowed_extensions;
	}

	public function log_message($log_message, $title, $user_message)
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $log_message, time(), array($title));
	}
}
