<?php
/**
*
* @version $Id: common.php 88 2017-04-24 20:00:25Z Scanialady $
* @package phpBB Extension - Image Upload (deutsch)
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
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
// ‚ ‘ ’ « » „ “ ” …
//

$lang = array_merge($lang, array(
	'IMAGEUPLOAD_UPLOAD'						=> 'Bilder-Upload',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Bilder-Upload Bereich',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Lade dein Bild hier hoch. (Beachte, dass dieser Ordner wieder geleert wird, und alle Uploads werden protokolliert)',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Bilder-Upload ist nicht aktiviert',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> 'Die maximale Größe der Datei beträgt <strong>%1$s %2$s</strong>! Abhängig von der benötigten Zeit, die zum hochladen benötigt wird, kann der Wert auch niedriger sein!',
	'IMAGEUPLOAD_NO_FILENAME'					=> 'Du musst eine Datei angeben, welche hochgeladen werden soll!',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> 'Die Datei ist größer, als dein Webanbieter erlaubt!',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Dein Eintrag wurde erfolgreich	zur Datenbank hinzugefügt.',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Version',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'Dateiname',
	'IMAGEUPLOAD_SUCCEEDED'						=> 'Erfolgreich hochgeladen!',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Direktlink',
	'IMAGEUPLOAD_URL_LINK'						=> 'URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'HSIMG',
	'IMAGEUPLOAD_BY'							=> 'Bild hochgeladen von ',
	'IMAGEUPLOAD_COPY'							=> 'kopieren',
	'IMAGEUPLOAD_UPLOADED_IMAGES'				=> 'Deine hochgeladenen Bilder',
	'IMAGEUPLOAD_POSTINGPAGE'					=> 'Hier findest du deine hochgeladenen Bilder. Klicke auf das Bild für eine Vorschau, lediglich ziehen und in den Textbereich fallen lassen für den Beitrag.',
	'IMAGEUPLOAD_INDEXPAGE'						=> 'Hier findest du deine hochgeladenen Bilder. Klicke auf das Bild für eine Vorschau, lediglich ziehen und fallen lassen.',
	'IMAGEUPLOAD_INDEXPAGE_CHAT'				=> 'Hier findest du deine hochgeladenen Bilder. Klicke auf das Bild für eine Vorschau, lediglich ziehen und fallen lassen, oder klicke auf den Titel-Button, um es direkt in mChat zu posten.',
	'IMAGEUPLOAD_UPC_INDEX'						=> 'Deine hochgeladenen Bilder auf der Forenseite sehen',
	'IMAGEUPLOAD_COLLAPSIBLE_CATEGORIES_TITLE'	=> 'Sichtbarkeit der hochgeladenen Bilder umschalten',
));
