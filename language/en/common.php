<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'IMAGEUPLOAD_UPLOAD'						=> 'Img-Upload',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Image Upload section',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Upload your image here. (Note this folder will get emptied and all uploads are logged)',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Image Upload is not enabled',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> 'The maximum size of the file is <strong>%1$s %2$s</strong>! Due to the upload time you might need, this value can be lower!',
	'IMAGEUPLOAD_NO_FILENAME'					=> 'You have to enter a file, which belongs to your upload!',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> 'The file is bigger, than your host allows!',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Your entry was successfully added to the database',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Version',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'File name',
	'IMAGEUPLOAD_SUCCEEDED'						=> 'Upload Succeeded!',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Direct link',
	'IMAGEUPLOAD_URL_LINK'						=> 'URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'HSIMG',
	'IMAGEUPLOAD_BY'							=> 'Image Upload by',
	'IMAGEUPLOAD_COPY'							=> 'copy',
	'IMAGEUPLOAD_UPLOADED_IMAGES'				=> 'Your uploaded images',
	'IMAGEUPLOAD_POSTINGPAGE'					=> 'Here your find your uploaded images click image to preview.',
	'IMAGEUPLOAD_INDEXPAGE'						=> 'Here your find your uploaded images click image to preview, just drag and drop.',
	'IMAGEUPLOAD_INDEXPAGE_CHAT'				=> 'Here your find your uploaded images click image to preview, just drag and drop or click title button to post direct in mChat.',
	'IMAGEUPLOAD_UPC_INDEX'						=> 'See your uploaded images on index page',
	'IMAGEUPLOAD_COLLAPSIBLE_CATEGORIES_TITLE'			=> [
		0 => 'Hide image upload',
		1 => 'Show image upload',
	],
	'IMAGEUPLOAD_UCP_DELETE_IMAGES'				=> 'Delete image',
	'IMAGEUPLOAD_UCP_DELETED_IMAGES'			=> 'Deleted image',
	'IMAGEUPLOAD_PAGE_RETURN'					=> 'Returning to uploaded images',
));
