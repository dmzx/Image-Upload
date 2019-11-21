<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use phpbb\exception\http_exception;
use phpbb\config\config;
use dmzx\imageupload\core\functions;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\controller\helper;
use phpbb\request\request_interface;
use phpbb\extension\manager;
use phpbb\path_helper;
use phpbb\config\db_text;
use phpbb\files\factory;

class imageupload
{
	/** @var config */
	protected $config;

	/** @var functions */
	protected $functions;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var db_interface */
	protected $db;

	/** @var helper */
	protected $helper;

	/** @var request_interface */
	protected $request;

	/** @var manager */
	protected $ext_manager;

	/** @var path_helper */
	protected $path_helper;

	/** @var db_text */
	protected $config_text;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $root_path;

	/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/** @var factory */
	protected $files_factory;

	protected $directoryLevel = 2;

	/**
	* Constructor
	*
	* @param config				$config
	* @param functions			$functions
	* @param template		 	$template
	* @param user				$user
	* @param auth				$auth
	* @param db_interface		$db
	* @param helper		 		$helper
	* @param request_interface	$request
	* @param manager			$ext_manager
	* @param path_helper		$path_helper
	* @param db_text			$config_text
	* @param string 			$php_ext
	* @param string 			$root_path
	* @param string 			$image_upload_table
	* @param factory			$files_factory
	*
	*/
	public function __construct(
		config $config,
		functions $functions,
		template $template,
		user $user,
		auth $auth,
		db_interface $db,
		helper $helper,
		request_interface $request,
		manager $ext_manager,
		path_helper $path_helper,
		db_text $config_text,
		$php_ext,
		$root_path,
		$image_upload_table,
		factory $files_factory = null
	)
	{
		$this->config 				= $config;
		$this->functions 			= $functions;
		$this->template 			= $template;
		$this->user 				= $user;
		$this->auth 				= $auth;
		$this->db 					= $db;
		$this->helper 				= $helper;
		$this->request 				= $request;
		$this->ext_manager	 		= $ext_manager;
		$this->path_helper	 		= $path_helper;
		$this->config_text 			= $config_text;
		$this->php_ext 				= $php_ext;
		$this->root_path 			= $root_path;
		$this->image_upload_table 	= $image_upload_table;
		$this->files_factory 		= $files_factory;
		$this->ext_path 			= $this->ext_manager->get_extension_path('dmzx/imageupload', true);
		$this->ext_path_web 		= $this->path_helper->update_web_root_path($this->ext_path);
	}

	public function handle_imageupload()
	{
		if (!$this->auth->acl_get('u_image_upload'))
		{
			if (!$this->user->data['is_registered'])
			{
				login_box();
			}
			throw new http_exception(403, 'NOT_AUTHORISED');
		}

		if (!$this->config['imageupload_enable'])
		{
			if (!$this->user->data['is_registered'])
			{
				login_box();
			}
			throw new http_exception(403, 'IMAGEUPLOAD_NOT_ENABELD');
		}

		$title			= $this->request->variable('title', '', true);
		$filename		= $this->request->variable('filename', '', true);
		$max_filesize 	= $this->config['imageupload_number'];
		$unit = 'MB';

		if (!empty($max_filesize))
		{
			$unit = strtolower(substr($max_filesize, -1, 1));
			$max_filesize = (int) $max_filesize;
			$unit = ($unit == 'k') ? 'KB' : (($unit == 'g') ? 'GB' : 'MB');
		}

		add_form_key('add_imageupload');

		$this->user->add_lang('posting');

		// Add allowed extensions
		$allowed_extensions = $this->functions->allowed_extensions();

		if ($this->request->is_set_post('submit'))
		{
			$filecheck = $multiplier = '';

			if ($this->files_factory !== null)
			{
				$fileupload = $this->files_factory->get('upload')
					->set_allowed_extensions($allowed_extensions);
			}
			else
			{
				if (!class_exists('\fileupload'))
				{
					include($this->root_path . 'includes/functions_upload.' . $this->php_ext);
				}
				$fileupload = new \fileupload();
				$fileupload->fileupload('', $allowed_extensions);
			}

			$upload_file = (isset($this->files_factory)) ? $fileupload->handle_upload('files.types.form', 'filename') : $fileupload->form_upload('filename');

			if (!$upload_file->get('uploadname'))
			{
				meta_refresh(3, $this->helper->route('dmzx_imageupload_controller_upload'));
				throw new http_exception(400, 'IMAGEUPLOAD_NO_FILENAME');
			}

			$upload_file->clean_filename('uploadname');

			//prepare the upload dir
			$upload_subdir = $this->getSubDir(md5($upload_file->get('uploadname')));
			$upload_dir = 'ext/dmzx/imageupload/img-files' . $upload_subdir . "/";
			if (!is_dir($this->root_path . "/" . $upload_dir)) {
				try {
					@mkdir($this->root_path . $upload_dir, 0755, true);
					if (!is_writable($this->root_path . $upload_dir)) {
						throw new \Exception(sprintf("[imageupload] error: directory <strong>%s</strong> is not writable!", $this->root_path . $upload_dir));
					}
					file_put_contents($this->root_path . $upload_dir . 'index.html', '');
				} catch (\Exception $e) {
					throw $e;
				}
			}

			$upload_file->move_file(str_replace($this->root_path, '', $upload_dir), true, true, 0755);
			@chmod($this->root_path . $upload_dir . $upload_file->get('uploadname'), 0755);

			if (sizeof($upload_file->error) && $upload_file->get('uploadname'))
			{
				$upload_file->remove();
				meta_refresh(3, $this->helper->route('dmzx_imageupload_controller_upload'));

				trigger_error(implode('<br />', $upload_file->error));
			}

			if (function_exists('getimagesize'))
			{
				$getimagesize = getimagesize($this->root_path . $upload_dir . '/' . $upload_file->get('realname'));
			}
			else
			{
				$getimagesize = array(0, 0);
			}

			// End the upload
			$sql_ary = array(
				'imageupload_filename'	=> ucfirst(str_replace('_', ' ', preg_replace('#^(.*)\..*$#', '\1', $upload_file->get('uploadname')))),
				'imageupload_realname'	=> $upload_subdir . "/" . $upload_file->get('realname'),
				'upload_time'			=> time(),
				'filesize'				=> $upload_file->get('filesize'),
				'user_id'				=> $this->user->data['user_id'],
			);

			if ($unit == 'MB')
			{
				$multiplier = 1048576;
			}
			else if ($unit == 'KB')
			{
				$multiplier = 1024;
			}

			if ($upload_file->get('filesize') > ($max_filesize * $multiplier))
			{
				@unlink($this->root_path . $upload_dir . '/' . $upload_file->get('realname'));
				meta_refresh(3, $this->helper->route('dmzx_imageupload_controller_upload'));

				throw new http_exception(400, 'IMAGEUPLOAD_FILE_TOO_BIG');
			}

			$filesize = @filesize($this->root_path . $upload_dir . '/' . $upload_file->get('realname'));

			$this->template->assign_vars(array(
				'FILENAME'	=> generate_board_url() . '/' . $upload_dir . $upload_file->get('realname'),
				'WIDTH'		=> $getimagesize[0],
				'HEIGHT'	=> $getimagesize[1],
				'SIZE'		=> get_formatted_filesize($filesize),
			));

			$this->db->sql_query('INSERT INTO ' . $this->image_upload_table .' ' . $this->db->sql_build_array('INSERT', $sql_ary));
			// Log message
			$this->functions->log_message('LOG_IMAGEUPLOAD_ADD', $upload_file->get('uploadname'), 'IMAGEUPLOAD_NEW_ADDED');
		}

		$allowed_extensions_list = $this->config_text->get_array([
			'imageupload_allowed_extensions',
		]);

		$allowed_extensions_array = explode(',', trim($allowed_extensions_list['imageupload_allowed_extensions']));

		sort($allowed_extensions_array);

		$imageupload_allowed_extensions = implode(' ,', $allowed_extensions_array);

		$form_enctype = (@ini_get('file_uploads') == '0' || strtolower(@ini_get('file_uploads')) == 'off') ? '' : ' enctype="multipart/form-data"';

		$this->template->assign_vars(array(
			'IMAGEUPLOAD_ALLOWED_SIZE'		=> sprintf($this->user->lang['IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'], $max_filesize, $unit),
			'IMAGEUPLOAD_ALLOWED_EXT'		=> $imageupload_allowed_extensions,
			'S_FORM_ENCTYPE'				=> $form_enctype,
		));

		// Build navigation link
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->user->lang('IMAGEUPLOAD_UPLOAD_SECTION'),
			'U_VIEW_FORUM'	=> $this->helper->route('dmzx_imageupload_controller_upload'),
		));

		$this->functions->assign_authors();
		$this->template->assign_var('IMAGEUPLOAD_FOOTER_VIEW', true);

		// Send all data to the template file
		return $this->helper->render('imageupload_body.html', $this->user->lang('IMAGEUPLOAD_UPLOAD_SECTION'));
	}

	/**
	 * @param $key
	 * @return string
	 * borrow from https://github.com/yiisoft/yii2/blob/4f41d1118c531e009ba1b468949c694e86d2a5f0/framework/caching/FileCache.php#L204
	 */
	protected function getSubDir($key)
	{
		$hex = '/'. $this->user->data['user_id'];
		if ($this->directoryLevel > 0) {
			for ($i = 0; $i < $this->directoryLevel; ++$i) {
				if (($prefix = substr($key, $i + $i, 2)) !== false) {
					$hex .= '/' . $prefix;
				}
			}
			return $hex;
		}
		return $hex;
	}
}
