<?php
/**PZENTEMPLATE_BRAND**/

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
} 

$autoLoadConfig[200][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_pzen_template_setup.php'
 );  
