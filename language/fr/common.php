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
	'IMAGEUPLOAD_UPLOAD'						=> 'Transfert d’images',
	'IMAGEUPLOAD_UPLOAD_SECTION'				=> 'Outil de transfert d’images',
	'IMAGEUPLOAD_UPLOAD_MESSAGE'				=> 'Depuis cette page il est possible de transférer un fichier image. Information : ce répertoire sera vidé et toutes les transferts seront enregistrés.',
	'IMAGEUPLOAD_NOT_ENABELD'					=> 'Le transfert d’images n’est pas activé.',
	'IMAGEUPLOAD_NEW_DOWNLOAD_SIZE'				=> 'La limite du poids des fichiers image est définie sur : <strong>%1$s %2$s</strong> ! Cependant, selon la connexion internet utilisée la limite de temps d’exécution de cet outil peut être inférieure au temps nécessaire pour accomplir le transfert !',
	'IMAGEUPLOAD_NO_FILENAME'					=> 'Il est nécessaire de sélectionner un fichier au préalable de cliquer sur le bonton « Envoyer » !',
	'IMAGEUPLOAD_FILE_TOO_BIG'					=> 'Le poids du fichier est supérieur à la limite du poids des fichiers autorisée !',
	'IMAGEUPLOAD_NEW_ADDED'						=> 'Donnée dans la base de données ajoutée avec succès !',
	'IMAGEUPLOAD_CURRENT_VERSION'				=> 'Version',
	'IMAGEUPLOAD_NEW_FILENAME'					=> 'Nom du fichier image',
	'IMAGEUPLOAD_SUCCEEDED'						=> 'Transfert accompli avec succès !',
	'IMAGEUPLOAD_DIRECT_LINK'					=> 'Lien de téléchargement direct',
	'IMAGEUPLOAD_URL_LINK'						=> 'Code usant du BBCode URL',
	'IMAGEUPLOAD_IMG_LINK'						=> 'Code usant du BBCode IMG',
	'IMAGEUPLOAD_HSIMG_LINK'					=> 'Code usant du BBCode Highslide IMG',
	'IMAGEUPLOAD_BY'							=> 'Image transférée par',
	'IMAGEUPLOAD_COPY'							=> 'Copier',
	'IMAGEUPLOAD_UPLOADED_IMAGES'				=> 'Fichiers image transférés',
	'IMAGEUPLOAD_POSTINGPAGE'					=> 'Depuis cet onglet il est possible de voir l’ensemble des fichiers image transférés. En cliquant sur une miniature il est possible d’afficher un aperçu de l’image. Aussi, il est possible d’insérer le lien de l’image pour la publier en effectuant les actions de glisser/déposer la miniature dans la zone de saisie du texte de l’éditeur complet.',
	'IMAGEUPLOAD_INDEXPAGE'						=> '<br /> Depuis ce bloc il est possible de voir l’ensemble des fichiers image transférés.<br /> En cliquant sur une miniature il est possible d’afficher un aperçu de l’image.<br /> Aussi, il est possible d’insérer le lien de l’image en effectuant les actions de glisser/déposer la miniature dans n’importe quelle zone de saisie du texte.',
	'IMAGEUPLOAD_INDEXPAGE_CHAT'				=> '<br /> Depuis ce bloc il est possible de voir l’ensemble des fichiers image transférés.<br /> En cliquant sur une miniature il est possible d’afficher un aperçu de l’image.<br /> Aussi, il est possible de :<ul style="font-size: 1.1em;"><li> - publier le lien de l’image dans le tchat « mChat » en effectuant les actions de glisser/déposer la miniature dans la zone de saisie du texte du tchat ;</li><li> - publier directement l’image dans le tchat « mChat » en cliquant sur le bouton correspondant au nom de l’image.</li>',
	'IMAGEUPLOAD_UPC_INDEX'						=> 'Afficher les fichier image trasnférés sur la page de l’index du forum',
	'IMAGEUPLOAD_COLLAPSIBLE_CATEGORIES_TITLE'	=> 'Afficher / Masquer le bloc des fichiers image transférés',
));
