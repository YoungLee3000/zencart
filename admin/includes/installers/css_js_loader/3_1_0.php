<?php
if (file_exists(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'auto_loaders/config.css_jscript_auto_loaders.php')) {
  unlink(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'auto_loaders/config.css_jscript_auto_loaders.php');
}
if (file_exists(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'init_includes/init_css_jscript_auto_loaders.php')) {
  unlink(DIR_FS_CATALOG . DIR_WS_INCLUDES . 'init_includes/init_css_jscript_auto_loaders.php');
}
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '3.1.0' WHERE configuration_key = 'CSS_JS_LOADER_VERSION' LIMIT 1;");