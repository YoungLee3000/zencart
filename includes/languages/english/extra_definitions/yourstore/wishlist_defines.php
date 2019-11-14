<?php
// control multiple wishlist functionality
if(UN_DB_MODULE_WISHLISTS_ENABLED == 'true'){
	define('UN_MODULE_WISHLISTS_ENABLED', true);
} else {
	define('UN_MODULE_WISHLISTS_ENABLED', false);}
if(UN_DB_ALLOW_MULTIPLE_WISHLISTS == 'true'){
	define('UN_ALLOW_MULTIPLE_WISHLISTS', true);
} else {
	define('UN_ALLOW_MULTIPLE_WISHLISTS', false);}
if(UN_DB_DISPLAY_CATEGORY_FILTER == 'true'){
	define('UN_DISPLAY_CATEGORY_FILTER', true);
} else {
	define('UN_DISPLAY_CATEGORY_FILTER', false);}
if(UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT == 'true'){
	define('UN_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT', true);
} else {
	define('UN_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT', false);}
		
// template header
define('UN_HEADER_TITLE_WISHLIST', 'Liste de souhaits');

// wishlist sidebox
define('UN_BOX_HEADING_WISHLIST', 'Liste de souhaits');
define('UN_BUTTON_IMAGE_WISHLIST_ADD', 'wishlist_add.gif');
define('UN_BUTTON_WISHLIST_ADD_ALT', 'Ajouter à Liste de souhaits');
define('UN_BOX_WISHLIST_ADD_TEXT', 'Cliquer pour ajouter ce produit à votre Liste de souhaits.');
define('UN_BOX_WISHLIST_LOGIN_TEXT', '<p><a href="' . zen_href_link(FILENAME_LOGIN, '', 'NONSSL') . '">Log In</a> pour pouvoir ajouter ce produit à votre liste d\'envies.</p>');

// control form
define('UN_TEXT_SORT', 'Trier');
define('UN_TEXT_SHOW', 'Montrer');
define('UN_TEXT_VIEW', 'Vue');
define('UN_TEXT_ALL_CATEGORIES', 'Toutes catégories');

// more
define('UN_TEXT_ADD_WISHLIST', 'Ajouter à la liste de souhaits');
define('UN_TEXT_REMOVE_WISHLIST', 'Retirer de la liste');
define('UN_BUTTON_IMAGE_SAVE', BUTTON_IMAGE_UPDATE);
define('UN_BUTTON_SAVE_ALT', BUTTON_UPDATE_ALT);
define('UN_TEXT_EMAIL_WISHLIST', 'Dire à un ami');
define('UN_TEXT_FIND_WISHLIST', 'Trouver Liste d\'un ami');
define('UN_TEXT_NEW_WISHLIST', 'Créer une nouvelle liste de souhaits');
define('UN_TEXT_MANAGE_WISHLISTS', 'Gérer mes listes de souhaits');
define('UN_TEXT_WISHLIST_MOVE', 'Déplacer les éléments entre Wish Lists');
define('SUCCESS_ADDED_TO_WISHLIST_PRODUCT', 'Vous avez joint l\'article dans la liste de souhaits');

define('UN_TEXT_PRIORITY', 'Priorité');
define('UN_TEXT_DATE_ADDED', 'Date ajoutée');
define('UN_TEXT_QUANTITY', 'Quantité');
define('UN_TEXT_COMMENT', 'Commentaire');

define('UN_TEXT_PRIORITY_0', '0 - Ne pas acheter ce pour moi');
define('UN_TEXT_PRIORITY_1', '1 - j\'y pense');
define('UN_TEXT_PRIORITY_2', '2 - Aime avoir');
define('UN_TEXT_PRIORITY_3', '3 - Amour d\'avoir');
define('UN_TEXT_PRIORITY_4', '4 - Doit avoir');

// product lists
define('UN_TEXT_NO_PRODUCTS', 'Aucun produit actuellement dans la liste.');
define('UN_TEXT_COMPACT', 'Compact');
define('UN_TEXT_EXTENDED', 'Prolongé');

// general
define('UN_LABEL_DELIMITER', ': ');
define('UN_TEXT_REMOVE', 'Retirer');
define('UN_EMAIL_SEPARATOR', "-------------------------------------------------------------------------------\n");
define('UN_TEXT_DATE_AVAILABLE', 'Date de disponibilité: %s');
define('UN_TEXT_FORM_FIELD_REQUIRED', '*');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');

// tables
define('UN_TABLE_HEADING_PRODUCTS', 'Prénom');
define('UN_TABLE_HEADING_PRICE', 'Prix');
define('UN_TABLE_HEADING_BUY_NOW', 'Chariot');
define('UN_TABLE_HEADING_QUANTITY', 'Quantité');
define('UN_TABLE_HEADING_WISHLIST', 'Liste de souhaits');
define('UN_TABLE_HEADING_SELECT', 'Sélectionner');

//errors
define('UN_ERROR_GET_ID', 'Erreur d\'obtenir la liste de souhaits par défaut id.');
define('UN_ERROR_GET_CUSTDATA', 'Erreur d\'obtention des données de client.');
define('UN_ERROR_GET_PERMISSION', 'Vous n\'êtes pas autorisé.');
define('UN_ERROR_GET_WISHLIST', 'Erreur d\'obtention wishlist.');
define('UN_ERROR_GET_WISHLIST_ID', 'Erreur d\'obtenir la liste de souhaits: id pas réglé.');
define('UN_ERROR_FIND_WISHLIST', 'listes d\'erreur trouver.');
define('UN_ERROR_IS_PRIVATE', 'Erreur déterminer si la liste de souhaits est privé.');
define('UN_ERROR_MAKE_DEFAULT', 'Erreur de paramétrage par défaut.');
define('UN_ERROR_MAKE_DEFAULT_ZERO', 'Erreur zéro défaut.');
define('UN_ERROR_MAKE_PUBLIC', 'Erreur faisant la liste de souhaits du public.');
define('UN_ERROR_MAKE_PRIVATE', 'Erreur faisant la liste de souhaits privée.');
define('UN_ERROR_CREATE_DEFAULT', 'Erreur de création liste par défaut.');
define('UN_ERROR_IN_WISHLIST', 'Erreur de déterminer si le produit dans la liste de souhaits.');
define('UN_ERROR_CREATE_WISHLIST', 'Erreur de création liste.');
define('UN_ERROR_ADD_WISHLIST', 'Erreur d\'ajout de la liste de souhaits article.');
define('UN_ERROR_EDIT_WISHLIST', 'Edition d\'erreur de l\'article wishlist.');
define('UN_ERROR_ADD_PRODUCT_WISHLIST', 'Erreur en ajoutant le produit à la liste.');
define('UN_ERROR_DELETE_DEFAULT_WISHLIST', 'Erreur liste suppression par défaut.');
define('UN_ERROR_DELETE_WISHLIST', 'Erreur de suppression liste.');
define('UN_ERROR_DELETE_PRODUCT_WISHLIST', 'Erreur de suppression produit de la liste de souhaits.');