<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @Spanish translation - ThE KuKa (Raul Arroyo) - http://www.phpbb-es.com
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
	'IMAGEUPLOAD_UPLOAD'						=> 'Subida de Imágenes',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Sección de Subida de Imágenes',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Suba su archivo aquí. (Tenga en cuenta que esta carpeta se vacía, y todas las subidas se registran).',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Subida de Imágenes no está habilitado',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> '¡El tamaño máximo del archivo es <strong>%1$s %2$s</strong>! ¡Debido al tiempo de carga que puede necesitar, este valor puede ser menor!',
	'IMAGEUPLOAD_NO_FILENAME'					=> '¡Tiene que ingresar un archivo, para su subida!',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> '¡El archivo es más grande, de lo que su hosting permite!',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Tu entrada se añadió correctamente a la base de datos.',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Versión',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'Nombre del archivo',
	'IMAGEUPLOAD_SUCCEEDED'						=> '¡Subida correcta!',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Enlace directo',
	'IMAGEUPLOAD_URL_LINK'						=> 'URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'HSIMG',
	'IMAGEUPLOAD_BY'							=> 'Imagen subida por',
));
