<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
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

$lang = array_merge($lang, [
	'ACP_IMAGEUPLOAD_SAVED'									=> 'Image Upload settings saved',
	'ACP_IMAGEUPLOAD_VERSION'								=> 'Version',
	'ACP_IMAGE_UPLOAD_CONFIGURATION'						=> 'Image Upload Configuration',
	'ACP_IMAGEUPLOAD_ENABLE'								=> 'Enable Image Upload',
	'ACP_IMAGEUPLOAD_ENABLE_EXPLAIN'						=> 'Global setting to enable Image Upload.',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE'							=> 'Enable Images on index',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE_EXPLAIN'					=> 'Global on/off of images on index for all members.<br />Members can set in UCP if they want to see uploaded images on index.',
	'ACP_IMAGEUPLOAD_NUMBER'								=> 'Size of upload',
	'ACP_IMAGEUPLOAD_NUMBER_EXPLAIN'						=> 'Set size of upload in MB default is 2 MB.',
	'ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'						=> 'The maximum size your php.ini allows is <strong>%1$s %2$s</strong>!',
	'ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'					=> 'Really delete image?',
	'ACP_IMAGEUPLOAD_TITLE'									=> 'Image name',
	'ACP_IMAGEUPLOAD_TITLE_REAL'							=> 'Image real name',
	'ACP_IMAGEUPLOAD_PREVIEW'								=> 'Preview',
	'ACP_IMAGEUPLOAD_WIDTH_HEIGHT'							=> 'Width/Height',
	'ACP_IMAGEUPLOAD_FOLDER_SIZE'							=> 'Total folder size',
	'ACP_IMAGEUPLOAD_USERNAME'								=> 'Uploaded by',
	'ACP_IMAGEUPLOAD_SIZE'									=> 'Size',
	'ACP_MULTI_IMAGES'		=>	[
		1 => '%s image',
		2 => '%s images',
	],
	'ACP_IMAGEUPLOAD_SORT_USERNAME'							=> 'Username',
	'ACP_IMAGEUPLOAD_SORT_DATE'								=> 'Date',
	'ACP_IMAGEUPLOAD_NOT_SELECTED'							=> 'Not selected any images',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE'							=> 'Enable mChat image posting',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE_EXPLAIN'					=> 'Set to yes to insert uploaded images on index with onclick insert.',
	'ACP_IMAGEUPLOAD_POST_ENABLE'							=> 'Enable image upload button on posting pages',
	'ACP_IMAGEUPLOAD_POST_ENABLE_EXPLAIN'					=> 'Set to yes to show upload button on posting pages.',
	'ACP_IMAGEUPLOAD_POSTTAB_ENABLE'						=> 'Enable users images on posting pages',
	'ACP_IMAGEUPLOAD_POSTTAB_ENABLE_EXPLAIN'				=> 'Global on/off for images on posting pages.',
	'ACP_IMAGEUPLOAD_EXT'									=> 'Allowed extensions',
	'ACP_IMAGEUPLOAD_EXT_EXPLAIN'							=> 'Allowed extensions to include, separated by a comma (Example: gif,jpeg,jpg,png)',
	'ACP_IMAGE_UPLOAD_LINK_SETTINGS'						=> 'Image Upload Link Settings',
	'ACP_IMAGEUPLOAD_ENABLE_DIRECT_LINK'					=> 'Enable Direct Link URL',
	'ACP_IMAGEUPLOAD_ENABLE_DIRECT_LINK_EXPLAIN'			=> 'Direct url to image.',
	'ACP_IMAGEUPLOAD_ENABLE_URL_LINK'						=> 'Enable URL tags',
	'ACP_IMAGEUPLOAD_ENABLE_URL_LINK_EXPLAIN'				=> '[url=FILENAME]SITENAME[/url]',
	'ACP_IMAGEUPLOAD_ENABLE_IMG_LINK'						=> 'Enable IMG tags',
	'ACP_IMAGEUPLOAD_ENABLE_IMG_LINK_EXPLAIN'				=> '[img]FILENAME[/img]',
	'ACP_IMAGEUPLOAD_ENABLE_URL_IMG_LINK'					=> 'Enable URL-IMG tags',
	'ACP_IMAGEUPLOAD_ENABLE_URL_IMG_LINK_EXPLAIN'			=> '[url=FILENAME][img]FILENAME[/img][/url]',
	'ACP_IMAGEUPLOAD_MULTI_ENABLE'							=> 'Enable multiple upload',
	'ACP_IMAGEUPLOAD_MULTI_ENABLE_EXPLAIN'					=> 'Global on/off for multiple upload images.',
		'ACP_IMAGEUPLOAD_CENTER_ENABLE'										 => 'Enable popup center',
		'ACP_IMAGEUPLOAD_CENTER_ENABLE_EXPLAIN'								 => 'Enables a pop up	on the same page',
		'ACP_IMAGEUPLOAD_NAV_ENABLE'											=> 'Enables the navbar icon',
		'ACP_IMAGEUPLOAD_NAV_ENABLE_EXPLAIN'									=> 'Turns on/off the navbar link',
		'ACP_IMAGEUPLOAD_MCHAT_ENABLE'											=> 'Enable image upload button in mchat',
		'ACP_IMAGEUPLOAD_MCHAT_ENABLE_EXPLAIN'									=> 'Enables machats image upload button',
]);
