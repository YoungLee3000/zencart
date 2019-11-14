<?php
$db->Execute("REPLACE INTO " . TABLE_CONFIGURATION . " (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES
            ('Enable Minify', 'MINIFY_STATUS', 'true', 'Minifying will speed up your site\'s loading speed by combining and compressing css/js files (valid CSS and JS are required).', " . $configuration_group_id . ", 10, NOW(), NOW(), NULL, 'zen_cfg_select_option(array(\'true\', \'false\'),'),
            ('Max URL Length', 'MINIFY_MAX_URL_LENGHT', '500', 'On some servers the maximum length of any POST/GET request URL is limited. If this is the case for your server, you can change the setting here', " . $configuration_group_id . ", 20, NOW(), NOW(), NULL, NULL),
            ('Minify Cache Time', 'MINIFY_CACHE_TIME_LENGHT', '31536000', 'Set minify cache time (in second). Default is 1 year (31536000)', " . $configuration_group_id . ", 30, NOW(), NOW(), NULL, NULL),
            ('Latest Cache Time', 'MINIFY_CACHE_TIME_LATEST', '0', 'Normally you don\'t have to set this, but if you have just made changes to your js/css files and want to make sure they are reloaded right away, you can reset this to 0.', " . $configuration_group_id . ", 40, NOW(), NOW(), NULL, NULL)");

$zc150 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5));            
if ($zc150) // continue Zen Cart 1.5.0
{
    // add configuration menu
    if (!zen_page_key_exists('configCSSJSLoader'))
    {
        $configuration          = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'CSS_JS_LOADER_VERSION' LIMIT 1;");
        $configuration_group_id = $configuration->fields['configuration_group_id'];
        if ((int) $configuration_group_id > 0)
        {
            zen_register_admin_page('configCSSJSLoader', 'BOX_CONFIGURATION_CSS_JS_LOADER', 'FILENAME_CONFIGURATION', 'gID=' . $configuration_group_id, 'configuration', 'Y', $configuration_group_id);
            
            $messageStack->add('Added to Configuration menu.', 'success');
        }
    }
}            