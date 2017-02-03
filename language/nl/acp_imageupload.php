<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* Nederlandse vertaling @ Solidjeuh <https://www.froddelpower.be>
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
	'ACP_IMAGEUPLOAD_SAVED'					=> 'Upload Afbeelding instellingen opgeslagen',
	'ACP_IMAGEUPLOAD_VERSION'				=> 'Versie',
	'ACP_IMAGE_UPLOAD_CONFIGURATION'		=> 'Afbeelding Uploader configuratie',
	'ACP_IMAGEUPLOAD_ENABLE'				=> 'Schakel Afbeelding Uploader in',
	'ACP_IMAGEUPLOAD_ENABLE_EXPLAIN'		=> 'Globale instellingen voor Afbeelding Uploader in te schakelen.',
	'ACP_IMAGEUPLOAD_NUMBER'				=> 'Grootte van de upload',
	'ACP_IMAGEUPLOAD_NUMBER_EXPLAIN'		=> 'Kies de grootte van de upload, standaard is 2 MB.',
	'ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'		=> 'De maximum grootte dat je php.ini toelaat is <strong>%1$s %2$s</strong>!',
	'ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'	=> 'Afbeelding echt verwijderen?',
	'ACP_IMAGEUPLOAD_TITLE'					=> 'Afbeelding naam',
	'ACP_IMAGEUPLOAD_TITLE_REAL'			=> 'Afbeelding echte naam',
	'ACP_IMAGEUPLOAD_PREVIEW'				=> 'Voorbeeld',
	'ACP_IMAGEUPLOAD_WIDTH_HEIGHT'			=> 'Breedte/Hoogte',
	'ACP_IMAGEUPLOAD_FOLDER_SIZE'			=> 'Totale folder grootte',
	'ACP_IMAGEUPLOAD_USERNAME'				=> 'Geupload door',
	'ACP_IMAGEUPLOAD_SIZE'					=> 'Grootte',
	'ACP_MULTI_IMAGES'		=>	array(
		1 => '%s afbeelding',
		2 => '%s afbeeldingen',
	),
));
));
