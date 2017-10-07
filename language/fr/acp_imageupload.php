<?php
/**
 *
 * Image Upload. An extension for the phpBB Forum Software package.
 * French translation by Galixte (http://www.galixte.com)
 *
 * @copyright (c) 2017 dmzx <http://www.dmzx-web.net>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'ACP_IMAGEUPLOAD_SAVED'					=> 'Les paramètres du « Transfert d’images » ont été sauvegardés avec succès !',
	'ACP_IMAGEUPLOAD_VERSION'				=> 'Version',
	'ACP_IMAGE_UPLOAD_CONFIGURATION'		=> 'Paramètres',
	'ACP_IMAGEUPLOAD_ENABLE'				=> 'Activer le transfert d’images',
	'ACP_IMAGEUPLOAD_ENABLE_EXPLAIN'		=> 'Permet d’activer l’outil « Transfert d’images » sur le forum.',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE'			=> 'Activer l’affichage des images transférées sur l’index du forum',
	'ACP_IMAGEUPLOAD_INDEX_ENABLE_EXPLAIN'	=> 'Permet d’afficher les images transférées par les membres sur la page de l’index du forum.<br />Chaque membre ne peut voir que les images qu’il a transférées et peut désactiver leur affichage depuis le « Panneau de l’utilisateur ».',
	'ACP_IMAGEUPLOAD_NUMBER'				=> 'Limite du poids des images',
	'ACP_IMAGEUPLOAD_NUMBER_EXPLAIN'		=> 'Permet de saisir la limite en Mo du poids des fichiers image qu’il sera possible de transférer. Par défaut définie sur 2 Mo.',
	'ACP_IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'		=> 'La limite du poids des fichiers définie dans le fichier de configuration du langage PHP (php.ini) pour le transfert est actuellement de : <strong>%1$s %2$s</strong> !',
	'ACP_IMAGEUPLOAD_REALLY_DELETE_IMAGE'	=> 'Confirmer la suppression du fichier image.',
	'ACP_IMAGEUPLOAD_TITLE'					=> 'Nom original du fichier',
	'ACP_IMAGEUPLOAD_TITLE_REAL'			=> 'Nom réel du fichier sur l’espace d’hébergement',
	'ACP_IMAGEUPLOAD_PREVIEW'				=> 'Aperçu',
	'ACP_IMAGEUPLOAD_WIDTH_HEIGHT'			=> 'Largeur & hauteur',
	'ACP_IMAGEUPLOAD_FOLDER_SIZE'			=> 'Taille totale du répertoire des fichiers image transférées',
	'ACP_IMAGEUPLOAD_USERNAME'				=> 'transféré par',
	'ACP_IMAGEUPLOAD_SIZE'					=> 'Taille',
	'ACP_MULTI_IMAGES'		=>	array(
		1 => '%s image',
		2 => '%s images',
	),
	'ACP_IMAGEUPLOAD_SORT_USERNAME'			=> 'Nom d’utilisateur',
	'ACP_IMAGEUPLOAD_SORT_DATE'				=> 'Date',
	'ACP_IMAGEUPLOAD_NOT_SELECTED'			=> 'Aucun fichier image sélectionné',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE'			=> 'Activer la publication d’images dans « mChat »',
	'ACP_IMAGEUPLOAD_CHAT_ENABLE_EXPLAIN'	=> 'Permet de publier des fichiers image d’un simple clic dans le tchat « mChat » depuis la page index du forum.',
));
