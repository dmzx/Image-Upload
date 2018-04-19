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
	'IMAGEUPLOAD_UPLOAD'						=> 'Img-Upload',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Seção Image Upload',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Envie suas imagens aqui. (Note que esta pasta será esvaziada e todos os envios serão registrados)',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Image Upload não está habilitado',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> 'O tamanho máximo do arquivo é <strong>%1$s %2$s</strong>! No momento do envio, este valor pode ser ainda menor!',
	'IMAGEUPLOAD_NO_FILENAME'					=> 'Você tem que entrar um arquivo, o qual pertence ao seu envio!',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> 'O arquivo é maior que o permitido pelo host!',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Seu envio foi adicionado ao banco de dados com sucesso',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Versão',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'Nome do arquivo',
	'IMAGEUPLOAD_SUCCEEDED'						=> 'Envio com sucesso!',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Link direto',
	'IMAGEUPLOAD_URL_LINK'						=> 'URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'HSIMG',
	'IMAGEUPLOAD_BY'							=> 'Enviado por',
	'IMAGEUPLOAD_COPY'							=> 'copiar',
	'IMAGEUPLOAD_UPLOADED_IMAGES'				=> 'Suas imagens enviadas',
	'IMAGEUPLOAD_POSTINGPAGE'					=> 'Aqui você encontra suas imagens enviadas, clique para preview. Apenas arraste e solte na área de mensagem.',
	'IMAGEUPLOAD_INDEXPAGE'						=> 'Aqui você encontra suas imagens enviadas, clique para preview. Apenas arraste e solte.',
	'IMAGEUPLOAD_INDEXPAGE_CHAT'				=> 'Aqui você encontra suas imagens enviadas, clique para preview. Apenas arraste e solte ou clique no botão título para postar diretamente no mChat.',
	'IMAGEUPLOAD_UPC_INDEX'						=> 'Ver suas imagens enviadas para a página índice',
	'IMAGEUPLOAD_COLLAPSIBLE_CATEGORIES_TITLE'	=> 'Alterna visibilidade das imagens enviadas',
	'IMAGEUPLOAD_UCP_DELETE_IMAGES'				=> 'Excluir imagem',
	'IMAGEUPLOAD_UCP_DELETED_IMAGES'			=> 'Imagem excluída',
	'IMAGEUPLOAD_PAGE_RETURN'					=> 'Voltar ao UCP'
));
