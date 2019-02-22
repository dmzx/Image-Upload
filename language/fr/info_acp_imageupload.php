<?php
/**
 *
 * Image Upload. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2018 dmzx <https://www.dmzx-web.net>
 * @license GNU General Public License, version 2 (GPL-2.0-only)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_IMAGE_UPLOAD'			=> 'Transfert d’images',
	'ACP_IMAGE_UPLOAD_CONFIG'	=> 'Paramètres',
	// Log
	'LOG_IMAGEUPLOAD_ADD'		=> '<strong>Fichier image transféré</strong><br>» %1$s',
	'LOG_IMAGEUPLOAD_SETTINGS'	=> '<strong>Paramètres du « Transfert d’images » sauvegardés</strong>',
	'LOG_IMAGEUPLOAD_DELETED'	=> '<strong>Fichier image supprimé</strong><br>» %1$s',
	'LOG_USER_IMAGE_DELETED'	=> '<strong>Fichier image « %s » supprimé du serveur dont le nom réel : « %s »</strong>',
));
