<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: shopping_cart.php 3183 2006-03-14 07:58:59Z birdbrain $
 */

define('NAVBAR_TITLE', 'Panier');
define('HEADING_TITLE', 'Contenu de votre panier');
define('HEADING_TITLE_EMPTY', 'Votre panier');
define('TEXT_INFORMATION', 'Vous pouvez ajouter des instructions sur l\'utilisation du panier ici.<br \>(Défini dans includes/languages/french/shopping_cart.php)');
define('TABLE_HEADING_REMOVE', 'Supprimer');
define('TABLE_HEADING_QUANTITY', 'Qté');
define('TABLE_HEADING_MODEL', 'Modèle');
define('TABLE_HEADING_PRICE','Unitaire');
define('TEXT_CART_EMPTY', 'Votre panier est vide.');
define('SUB_TITLE_SUB_TOTAL', 'Sous-Total :');
define('SUB_TITLE_TOTAL', 'Total:');

define('OUT_OF_STOCK_CANT_CHECKOUT', 'Les produits marqués avec ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' sont hors stock ou il n\'y en a pas assez en stock pour honorer votre commande.<br />Veuillez modifier la quantité des produits marqué (' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '). Merci');
define('OUT_OF_STOCK_CAN_CHECKOUT', 'Les produits marqués avec ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' sont hors stock.<br />Les objets non disponibles seront placés en attente.');

define('TEXT_TOTAL_ITEMS', 'Nombre Total d\'Article(s) : ');
define('TEXT_TOTAL_WEIGHT', '&nbsp;&nbsp;Poids : ');
define('TEXT_TOTAL_AMOUNT', '&nbsp;&nbsp;Montant : ');

define('TEXT_VISITORS_CART', '<a href="javascript:session_win();">[Aide (?)]</a>');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');

define('TEXT_YOUR_ADDRESS','Votre adresse d\'expédition');

define('TITLE_NO_ACCOUNT','Non - Paiement Par Compte');
define('TITLE_SPECIAL_NOTE','Note Spéciale ou Note de Commande');
define('TITLE_PAYMENT','Mode de Paiement');
define('TITLE_TRANSPORT','Procédé de Transport:');
define('TITLE_DETAIL_CONTACT','Détails de Contact');
define('TITLE_NUMBER_TOTAL','Votre Nombre Total');


define('TIPS_NO_ACCOUNT_OPTION','Pour une expérience pratique, nous offrons l\'option de vérifier sans créer un compte.');
define('TIPS_CLICK','Si vous avez notre compte, vous pouvez Clic ');
define('TIPS_PAGE_CONNECTION','Page de connexion');
define('TIPS_OR',', Ou  ');
define('TIPS_CREATE_ACCOUNT','Créer un compte');
define('TIPS_FORGOT_PASSWORD','Vous avez perdu votre mot de passe?');
define('TIPS_NO_ACCEPT','Désolé, nous n\'acceptons pas les paiements de votre région en ce moment.');
define('TIPS_CONTACT_FOR','S\'il vous plaît contactez-nous pour d\'autres arrangements.');
?>