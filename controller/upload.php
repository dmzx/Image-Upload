<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\imageupload\controller;

use phpbb\exception\http_exception;
use phpbb\config\config;
use dmzx\imageupload\core\functions;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\request\request_interface;
use phpbb\files\factory;
use phpbb\path_helper;
use phpbb\db\driver\driver_interface as db_interface;

class upload
{
	/** @var config */
	protected $config;

	/** @var functions */
	protected $functions;

	/** @var user */
	protected $user;

	/** @var auth */
	protected $auth;

	/** @var request_interface */
	protected $request;

	/** @var factory */
	protected $files_factory;

	/** @var path_helper */
	protected $path_helper;

	/** @var db_interface */
	protected $db;

	/** @var string */
	protected $php_ext;

	/**
	* The database table
	*
	* @var string
	*/
	protected $image_upload_table;

	/**
	 * Constructor
	 *
	 * @param config			$config
	 * @param functions			$functions
	 * @param user				$user
	 * @param auth				$auth
	 * @param request_interface	$request
	 * @param factory			$files_factory
	 * @param path_helper		$path_helper
	 * @param string 			$image_upload_table
	 */
	public function __construct(
		config $config,
		functions $functions,
		user $user,
		auth $auth,
		request_interface $request,
		path_helper $path_helper,
		db_interface $db,
		$php_ext,
		$image_upload_table,
		factory $files_factory = null
	)
	{
		$this->config 				= $config;
		$this->functions 			= $functions;
		$this->user 				= $user;
		$this->auth 				= $auth;
		$this->request 				= $request;
		$this->files_factory 		= $files_factory;
		$this->path_helper 			= $path_helper;
		$this->db 					= $db;
		$this->php_ext 				= $php_ext;
		$this->image_upload_table 	= $image_upload_table;
	}

	public function handle()
	{
		if ($this->auth->acl_get('u_image_upload_multi') && $this->config['imageupload_multiupload_enable'])
		{
			$max_filesize 	= $this->config['imageupload_number'];
			$unit 			= 'MB';
			$multiplier 	= '';

			if (!empty($max_filesize))
			{
				$unit = strtolower(substr($max_filesize, -1, 1));
				$max_filesize = (int) $max_filesize;
				$unit = ($unit == 'k') ? 'KB' : (($unit == 'g') ? 'GB' : 'MB');
			}

			if ($unit == 'MB')
			{
				$multiplier = 1048576;
			}
			else if ($unit == 'KB')
			{
				$multiplier = 1024;
			}

			$set_max_filesize = ($max_filesize * $multiplier);

			$allowed_extensions = $this->functions->allowed_extensions();

			$upload = $this->files_factory->get('upload')
				->set_allowed_extensions($allowed_extensions)
				->set_max_filesize($set_max_filesize)
				->set_disallowed_content((isset($this->config['mime_triggers']) ? explode('|', $this->config['mime_triggers']) : false));

			$upload_file = $upload->handle_upload('files.types.form', 'imageuploadmulti');

			$upload_file->clean_filename('uploadname');

			if ($upload_file->get('uploadname') != '')
			{
				$upload_subdir = $this->functions->getSubDir(md5($upload_file->get('uploadname')));
				$upload_dir = 'ext/dmzx/imageupload/img-files' . $upload_subdir . "/";
				if (!is_dir($this->path_helper->get_phpbb_root_path() . "/" . $upload_dir))
				{
					try {
						@mkdir($this->path_helper->get_phpbb_root_path() . $upload_dir, 0755, true);
						if (!is_writable($this->path_helper->get_phpbb_root_path() . $upload_dir))
						{
							$response = ['status' => 'error2'];
						}
						file_put_contents($this->path_helper->get_phpbb_root_path() . $upload_dir . 'index.html', '');
					} catch (\Exception $e) {
						throw $e;
					}
				}

				$upload_file->move_file(str_replace($this->path_helper->get_phpbb_root_path(), '', $upload_dir), true, true, 0755);
				@chmod($this->path_helper->get_phpbb_root_path() . $upload_dir . $upload_file->get('uploadname'), 0755);

				if (sizeof($upload_file->error) && $upload_file->get('uploadname'))
				{
					$upload_file->remove();
					$response = ['status' => 'error1', $upload_file->error];
				}
				else
				{
					$response = ['status' => 'success'];
				}

				$sql_ary = [
					'imageupload_filename'	=> ucfirst(str_replace('_', ' ', preg_replace('#^(.*)\..*$#', '\1', $upload_file->get('uploadname')))),
					'imageupload_realname'	=> $upload_subdir . "/" . $upload_file->get('realname'),
					'upload_time'			=> time(),
					'filesize'				=> $upload_file->get('filesize'),
					'user_id'				=> $this->user->data['user_id'],
				];

				$this->db->sql_query('INSERT INTO ' . $this->image_upload_table .' ' . $this->db->sql_build_array('INSERT', $sql_ary));

				$this->functions->log_message('LOG_IMAGEUPLOAD_ADD', $upload_file->get('uploadname'));

			}
			else
			{
				$response = ['status' => 'error3'];
			}
		}
		else
		{
			$response = ['status' => 'error3'];
		}
		return new \Symfony\Component\HttpFoundation\JsonResponse($response);
	}
}
