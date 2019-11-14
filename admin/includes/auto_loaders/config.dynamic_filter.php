<?php
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
} 

$autoLoadConfig[200][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_dynamic_filter.php'
 );  
