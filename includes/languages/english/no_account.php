<?php
/**
 * @package languageDefines
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright Joseph Schilz
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: J_Schilz for Integrated COWOA - 14 April 2007
 */

define('NAVBAR_TITLE', 'Billing Information');

define('HEADING_TITLE', 'Step 1 of 5 - Billing Information');

define('TEXT_ORIGIN_LOGIN', '<strong class="note">NOTE:</strong> Si vous avez déjà un compte chez nous, veuillez vous identifier sur la <a href="%s">page de connexion</a>.');
define('TEXT_LEGEND_HEAD', 'Create a New Account');
define('TEXT_MORE', 'For a limited time, new customers receive a coupon good for 10% off any order.  You will receive this coupon immediately after you have created your account, and it may be used on your first order.<br /><br />To begin creating a new account, please enter your account details below.');

// greeting salutation
define('EMAIL_SUBJECT', 'Bienvenue chez ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Cher Mr. %s,' . "\n\n");
define('EMAIL_GREET_MS', 'Chère Mme. %s,' . "\n\n");
define('EMAIL_GREET_NONE', 'Cher %s' . "\n\n");

// First line of the greeting
define('EMAIL_WELCOME', 'Nous sommes heureux de vous accueillir chez <strong>' . STORE_NAME . '</strong>.' . "\n\n");
define('EMAIL_SEPARATOR', '--------------------');
define('EMAIL_COUPON_INCENTIVE_HEADER', 'Congratulations! To make your next visit to our online shop a more rewarding experience, listed below are details for a Discount Coupon created just for you!' . "\n\n");
// your Discount Coupon Description will be inserted before this next define
define('EMAIL_COUPON_REDEEM', 'To use the Discount Coupon, enter the ' . TEXT_GV_REDEEM . ' code during checkout:  <strong>%s</strong>' . "\n\n");

define('EMAIL_GV_INCENTIVE_HEADER', 'Just for stopping by today, we have sent you a ' . TEXT_GV_NAME . ' for %s!' . "\n");
define('EMAIL_GV_REDEEM', 'The ' . TEXT_GV_NAME . ' ' . TEXT_GV_REDEEM . ' is: %s ' . "\n\n" . 'You can enter the ' . TEXT_GV_REDEEM . ' during Checkout, after making your selections in the store. ');
define('EMAIL_GV_LINK', ' Or, you may redeem it now by following this link: ' . "\n");
// GV link will automatically be included before this line

define('EMAIL_GV_LINK_OTHER','Once you have added the ' . TEXT_GV_NAME . ' to your account, you may use the ' . TEXT_GV_NAME . ' for yourself, or send it to a friend!' . "\n\n");

define('EMAIL_TEXT', 'Vous êtes maintenant enregistré(e) sur notre site et avez des privilèges. Avec votre compte, vous avez maintenant accès aux <strong>services divers</strong> que nous vous offrons. Parmi ces nombreux services figurent entre autres :' . "\n\n<ul>" . '<li><strong>Historique de commande</strong> - Visualiser les détails des commandes passées chez nous.' . "\n\n" . '<li><strong>Panier permanent</strong> - Tous les produits ajoutés à votre panier y restent jusqu\'à ce que vous les enleviez, ou que vous passiez à la caisse.' . "\n\n" . '<li><strong>Carnet d\'adresses</strong> - Nous pouvons expédier vos produits à une adresse différente de la vôtre ! C\'est parfait pour envoyer un cadeau d\'anniversaire à la personne elle-même ! ' . "\n\n" . '<li><strong>Des avis de clients</strong> - Partagez votre opinion sur nos produits avec d\'autres clients.' . "\n\n</ul>");
define('EMAIL_CONTACT', 'Pour de plus amples informations concernant nos services, merci de nous contacter par mail : <a href="mailto:' . STORE_OWNER_EMAIL_ADDRESS . '">'. STORE_OWNER_EMAIL_ADDRESS ." </a>\n\n");
define('EMAIL_GV_CLOSURE','Cordialement,' . "\n\n" . STORE_OWNER . "\nLa Direction\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER ."</a>\n\n");

// email disclaimer - this disclaimer is separate from all other email disclaimers
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Cette adresse email nous a été communiquée par vous ou un de nos clients. Si vous n\'avez pas ouvert de compte sur ce site, ou pensez avoir reçu cet e-mail par erreur, veuillez envoyer un mail à : %s ');

define('TABLE_HEADING_CONTACT_DETAILS', 'Contact Details');

define('TITLE_CONTINUE_CHECKOUT_PROCEDURE', 'Continue to Step 2');
define('TEXT_CONTINUE_CHECKOUT_PROCEDURE', '- provide delivery information.');


?>
