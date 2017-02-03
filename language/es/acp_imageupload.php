<?php
/**
*
* @package phpBB Extension - Image Upload
* @copyright (c) 2017 dmzx - http://www.dmzx-web.net
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
	'ACP_IMAGEUPLOAD_SAVED'					=> 'Ajustes guardados de Subida de Imágenes',
	'ACP_IMAGEUPLOAD_VERSION'				=> 'Versión',
	'ACP_IMAGE_UPLOAD_CONFIGURATION'		=> 'Configuración de Subida de Imágenes',
	'ACP_IMAGEUPLOAD_ENABLE'				=> 'Habilitar Subida de Imágenes',
	'ACP_IMAGEUPLOAD_ENABLE_EXPLAIN'		=> 'Configuración global para habilitar la Subida de Imágenes.',
	'ACP_IMAGEUPLOAD_NUMBER'				=> 'Tamaño de la subida',
	'ACP_IMAGEUPLOAD_NUMBER_EXPLAIN'		=> 'Establecer el tamaño de la subida en MB por defecto es 2 MB.',
	'ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'		=> '¡El tamaño máximo que su php.ini permite es <strong>%1$s %2$s</strong>!',
	'ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'	=> '¿Quiere eliminar la imagen?',
	'ACP_IMAGEUPLOAD_TITLE'					=> 'Nombre de la imagen',
	'ACP_IMAGEUPLOAD_TITLE_REAL'			=> 'Image real name',
	'ACP_IMAGEUPLOAD_PREVIEW'				=> 'Vista previa',
	'ACP_IMAGEUPLOAD_WIDTH_HEIGHT'			=> 'Anchura/Altura',
	'ACP_IMAGEUPLOAD_FOLDER_SIZE'			=> 'Tamaño total de la carpeta',
	'ACP_IMAGEUPLOAD_USERNAME'				=> 'Subido por',
	'ACP_IMAGEUPLOAD_SIZE'					=> 'Tamaño',
	'ACP_MULTI_IMAGES'		=>	array(
		1 => '%s imagen',
		2 => '%s imágenes',
	),
));
