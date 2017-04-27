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
	'ACP_IMAGEUPLOAD_SAVED'					=> 'Configurações do Image Upload salvas',
	'ACP_IMAGEUPLOAD_VERSION'				=> 'Versão',
	'ACP_IMAGE_UPLOAD_CONFIGURATION'		=> 'Configuração do Image Upload',
	'ACP_IMAGEUPLOAD_ENABLE'				=> 'Habilita Image Upload',
	'ACP_IMAGEUPLOAD_ENABLE_EXPLAIN'		=> 'Configuração global para habilitar o Image Upload.',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE'			=> 'Habilita imagens no índice',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE_EXPLAIN'	=> 'Habilita/desabilita globalmente as imagens no índice para todos os membros.<br />Membros pode definir no UCP se querem ver imagens enviadas no índice.',
	'ACP_IMAGEUPLOAD_NUMBER'				=> 'Tamanho do upload',
	'ACP_IMAGEUPLOAD_NUMBER_EXPLAIN'		=> 'Define o tamanho do upload em MB. Padrão é 2 MB.',
	'ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'		=> 'O tamanho máximo que seu php.ini permite é	<strong>%1$s %2$s</strong>!',
	'ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'	=> 'Deseja excluir a imagem?',
	'ACP_IMAGEUPLOAD_TITLE'					=> 'Nome da imagem',
	'ACP_IMAGEUPLOAD_TITLE_REAL'			=> 'Nome real da imagem',
	'ACP_IMAGEUPLOAD_PREVIEW'				=> 'Prévia',
	'ACP_IMAGEUPLOAD_WIDTH_HEIGHT'			=> 'Largura/Altura',
	'ACP_IMAGEUPLOAD_FOLDER_SIZE'			=> 'Tamanho total da pasta',
	'ACP_IMAGEUPLOAD_USERNAME'				=> 'Enviado por',
	'ACP_IMAGEUPLOAD_SIZE'					=> 'Tamanho',
	'ACP_MULTI_IMAGES'		=>	array(
		1 => '%s imagem',
		2 => '%s imagens',
	),
	'ACP_IMAGEUPLOAD_SORT_USERNAME'			=> 'Usuário',
	'ACP_IMAGEUPLOAD_SORT_DATE'				=> 'Data',
	'ACP_IMAGEUPLOAD_NOT_SELECTED'			=> 'Nenhuma imagem selecionada',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE'			=> 'Habilita postar imagens no mChat',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE_EXPLAIN'	=> 'Marque Sim para permitir postar imagens no mChat.',
));
