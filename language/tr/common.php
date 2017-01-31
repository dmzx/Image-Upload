<?php
/**
*
* @package phpBB Extension - Image Upload
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
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'IMAGEUPLOAD_UPLOAD'						=> 'Resim Yükleme',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Resim Yükleme bölümü',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Fotoğrafınızı buraya yükleyin. (Not: Bu klasör boşaltılır ve tüm yüklemeler günlüğe kaydedilir)',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Resim Yükleme etkin değil',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> 'Maksimum dosya boyutu <strong>%1$s %2$s</strong>! İhtiyaç duyabileceğiniz yükleme süresine göre bu değer düşebilir!',
	'IMAGEUPLOAD_NO_FILENAME'					=> 'Yüklemenize ait bir dosyayı girmeniz gerekiyor!',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> 'Dosya sonucunuzda izin verilen değerden daha büyük!',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Girişiniz veritabanına başarıyla eklendi',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Versiyon',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'Dosya adı',
	'IMAGEUPLOAD_SUCCEEDED'						=> 'Yükleme başarılı!',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Doğrudan bağlantı linki',
	'IMAGEUPLOAD_URL_LINK'						=> 'URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'HSIMG',
	'IMAGEUPLOAD_BY'							=> 'Resmi yükleyen',
));
