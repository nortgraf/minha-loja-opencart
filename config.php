<?php
// DIR
define('DIR_APPLICATION', '/home/nort5950/public_html/admin/');
define('DIR_SYSTEM', '/home/nort5950/public_html/system/');
define('DIR_LANGUAGE', DIR_APPLICATION . 'language/');
define('DIR_TEMPLATE', DIR_APPLICATION . 'view/template/');
define('DIR_CONFIG', DIR_SYSTEM . 'config/');
define('DIR_CATALOG', '/home/nort5950/public_html/catalog/');
// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
$serverName = str_replace("www.", "", strtolower($_SERVER['SERVER_NAME']));
if ($serverName=='nortgraf.com.br') {
    // nortgraf.com.br
    // DIR
    define('DIR_IMAGE', '/home/nort5950/public_html/image/');
    define('IMAGESUBDIR_CATALOG', 'catalog');
    define('DIR_STORAGE', '/home/nort5950/storage/');
    define('DIR_CACHE', DIR_STORAGE . 'cache/');
    define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
    define('DIR_LOGS', DIR_STORAGE . 'logs/');
    define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
    define('DIR_SESSION', DIR_STORAGE . 'session/');
    define('DIR_UPLOAD', DIR_STORAGE . 'upload/');
    // HTTP, HTTPS
    define('HTTP_SERVER', 'https://nortgraf.com.br/admin/');
    define('HTTP_CATALOG', 'https://nortgraf.com.br/');
    define('HTTPS_SERVER', 'https://nortgraf.com.br/admin/');
    define('HTTPS_CATALOG', 'https://nortgraf.com.br/');
    // DB
    define('DB_USERNAME', 'nort5950_nortgr1986');
    define('DB_PASSWORD', '7nCs_lSb4g7m4[$iA9');
    define('DB_DATABASE', 'nort5950_nortgr1986');
} else {
    // brasilia.nortgraf.com.br
    // DIR
    define('DIR_IMAGE', '/home/nort5950/public_html/image/');
    define('IMAGESUBDIR_CATALOG', 'cataloges');
    define('DIR_STORAGE', '/home/nort5950/storage2/');
    define('DIR_CACHE', DIR_STORAGE . 'cache/');
    define('DIR_DOWNLOAD', DIR_STORAGE . 'download/');
    define('DIR_LOGS', DIR_STORAGE . 'logs/');
    define('DIR_MODIFICATION', DIR_STORAGE . 'modification/');
    define('DIR_SESSION', DIR_STORAGE . 'session/');
    define('DIR_UPLOAD', DIR_STORAGE . 'upload/');
    // HTTP, HTTPS
    define('HTTP_SERVER', 'https://brasilia.nortgraf.com.br/admin/');
    define('HTTP_CATALOG', 'https://brasilia.nortgraf.com.br/');
    define('HTTPS_SERVER', 'https://brasilia.nortgraf.com.br/admin/');
    define('HTTPS_CATALOG', 'https://brasilia.nortgraf.com.br/');
    // DB
    define('DB_USERNAME', 'nort5950_brasilia');
    define('DB_PASSWORD', 'ewYogx5xW,QM');
    define('DB_DATABASE', 'nort5950_brasilia');
}
