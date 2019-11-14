<?php
/**PZENTEMPLATE_BRAND**/
define('TABLE_PZENTEMPLATE', DB_PREFIX . 'pzen_template');
define('TABLE_PZEN_SLIDER', DB_PREFIX.'pzen_slider');
define('TABLE_PZEN_TOPBANNER', DB_PREFIX.'pzen_topbanner');
define('TABLE_PZEN_BOTTOMBANNER', DB_PREFIX.'pzen_bottombanner');
define('TABLE_PZEN_SIDEBARBANNER', DB_PREFIX.'pzen_sidebarbanner');
define('PZEN_TEMPLATE_SQL',  DIR_WS_INCLUDES.'pzen_template/sql/pzen_template_sql.sql');
define('PZEN_TEMPLATE_SQL_FORCE',  DIR_WS_INCLUDES.'pzen_template/sql/force_sql.sql');
define('PZEN_TEMPLATE_CREATETABLE_SQL',  DIR_WS_INCLUDES.'pzen_template/sql/pzen_template_createtable_sql.sql');
define('PZEN_TEMPLATE_TABLES', TABLE_PZENTEMPLATE.",".TABLE_PZEN_SLIDER.",".TABLE_PZEN_TOPBANNER.",".TABLE_PZEN_BOTTOMBANNER);
 
 
 ?>