<?php
/**
 *
 * @package plugins
 * @copyright Copyright 2003-2012 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
/**
 * Designed for v1.5.1
 */
if (!defined('IS_ADMIN_FLAG')) {
 die('Illegal Access');
}
$autoLoadConfig[190][] = array('autoType'=>'class',
                              'loadFile'=>'observers/class.google_recaptcha.php');
$autoLoadConfig[190][] = array('autoType'=>'classInstantiate',
                              'className'=>'google_recaptcha',
                              'objectName'=>'google_recaptcha');
