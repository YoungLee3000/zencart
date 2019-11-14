<?php
/**
 * Testimonials Manager
 *
 * @package Template System
 * @copyright 2007 Clyde Jones
  * @copyright Portions Copyright 2003-2007 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Testimonials_Manager.php v1.5.4
 */

define('NAVBAR_TITLE', 'Ajouter Mon Témoignage');
define('HEADING_ADD_TITLE', 'Ajouter Mon Témoignage');

define('TESTIMONIAL_SUCCESS', 'Votre témoignage a été soumis avec succès et sera ajoutée à nos autres témoignages dès que nous l\'approuvons.');

define('TESTIMONIAL_SUBMIT', 'Proposez votre témoignage en utilisant le formulaire ci-dessous.');


//////////////
define('EMAIL_SUBJECT', 'Votre Témoignage Présentation A ' . STORE_NAME . '.');
define('EMAIL_GREET_NONE', 'Dear %s' . "\n\n");
define('EMAIL_WELCOME', 'Merci pour votre soumission témoignage au <strong>' . STORE_NAME . '</strong>.' . "\n\n");
define('EMAIL_TEXT', 'Votre témoignage a été soumis avec succès à ' . STORE_NAME . '. It will be added to our other testimonials as soon as we approve it. You will receive an email about the status of your submittal. If you have not received it within the next 48 hours, please contact us before submitting your testimonial again.' . "\n\n");
define('EMAIL_CONTACT', 'Pour de l\'aide avec votre soumission témoignage, s\'il vous plaît nous contacter: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> Cette adresse email nous a été donnée au cours d\'une présentation témoignage. Si vous avez un problème, s\'il vous plaît envoyez un courriel à ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('EMAIL_OWNER_SUBJECT', 'Témoignage soumission à ' . STORE_NAME);
define('SEND_EXTRA_TESTIMONIALS_ADD_SUBJECT', '[TESTIMONIAL SUBMISSION]');
define('EMAIL_OWNER_TEXT', 'Un nouveau témoignage a été soumis à ' . STORE_NAME . '. Il n\'a pas encore été approuvé. S\'il vous plaît vérifier ce témoignage et activer.' . "\n\n");
define('EMAIL_GV_CLOSURE','Cordialement,' . "\n\n" . STORE_OWNER . "\nStore Owner\n\n". '<a href="' . HTTP_SERVER . DIR_WS_CATALOG . '">'.HTTP_SERVER . DIR_WS_CATALOG ."</a>\n\n");
define('EMAIL_DISCLAIMER_NEW_CUSTOMER', 'Ce témoignage nous a été soumis par vous ou par un de nos utilisateurs. Si vous ne soumettez pas un témoignage, ou le sentiment que vous avez reçu ce message par erreur, s\'il vous plaît envoyez un courriel à %s ');


////////////////
define('TABLE_HEADING_TESTIMONIALS', 'Témoignages de clients');
define('TESTIMONIAL_CONTACT', 'Coordonnées');

define('TEXT_TESTIMONIALS_TITLE', 'Témoignage Titre:&nbsp;');
define('TEXT_TESTIMONIALS_NAME', 'votre nom:&nbsp;');
define('TEXT_TESTIMONIALS_MAIL', 'Votre Email:&nbsp;');
define('TEXT_TESTIMONIALS_COMPANY', 'Nom de la compagnie:&nbsp;');
define('TEXT_TESTIMONIALS_CITY', 'Ville:&nbsp;');
define('TEXT_TESTIMONIALS_COUNTRY', 'État ou Pays:&nbsp;');
define('TEXT_TESTIMONIALS_HTML_TEXT', 'Témoignage');
define('TEXT_TESTIMONIALS_DESCRIPTION', 'texte Témoignage:&nbsp;');
define('TEXT_TESTIMONIALS_DESCRIPTION_INFO', 'Texte Témoignage doit être comprise entre ' . ENTRY_TESTIMONIALS_TEXT_MIN_LENGTH . ' &amp; ' . ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH . ' personnages!');
define('TEXT_CAPTCHA_INFO', '<div class="testimonialsSmallText">Code de vérification est insensible à la casse</div>');

define('RETURN_REQUIRED_INFORMATION', ' = Information requise<br />');
define('RETURN_OPTIONAL_INFORMATION', ' = Information optionnelle');
define('RETURN_OPTIONAL_IMAGE','optional.png');
define('RETURN_OPTIONAL_IMAGE_ALT', 'information optionnelle');
define('RETURN_OPTIONAL_IMAGE_HEIGHT', '12');
define('RETURN_OPTIONAL_IMAGE_WIDTH', '12');
define('RETURN_REQUIRED_IMAGE', 'required.png');
define('RETURN_REQUIRED_IMAGE_ALT', 'requise information');
define('RETURN_REQUIRED_IMAGE_HEIGHT', '12');
define('RETURN_REQUIRED_IMAGE_WIDTH', '12');
define('RETURN_WARNING_IMAGE', 'exclamation.gif');
define('RETURN_WARNING_IMAGE_ALT', 'warning');
define('RETURN_WARNING_IMAGE_HEIGHT', '16');
define('RETURN_WARNING_IMAGE_WIDTH', '16');

define('TEXT_TESTIMONIAL_LOGIN_PROMPT','Vous devez vous identifier ou créer un compte afin de soumettre un témoignage');
define('ERROR_TESTIMONIALS_NAME_REQUIRED', '<div class="testimonialsError">Votre nom est requis!</div>');
define('ERROR_TESTIMONIALS_EMAIL_REQUIRED', '<div class="testimonialsError">Vous devez inclure votre adresse e-mail!</div>');
define('ERROR_TESTIMONIALS_TITLE_REQUIRED', '<div class="testimonialsError">Un Témoignage Titre est obligatoire!</div>');
define('ERROR_TESTIMONIALS_DESCRIPTION_REQUIRED', '<div class="testimonialsError">Témoignage est requis!</div>');
define('ERROR_TESTIMONIALS_TEXT_MAX_LENGTH', '<div class="testimonialsError">Moins que ' . ENTRY_TESTIMONIALS_TEXT_MAX_LENGTH . ' personnages!</div>');
define('ERROR_TESTIMONIALS', 'Des erreurs se sont glissées dans votre soumission! S\'il vous plaît corriger et soumettre à nouveau!');
//EOF