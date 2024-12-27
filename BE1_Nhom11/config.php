<?php
// Kiểm tra nếu hằng số chưa được định nghĩa mới tiến hành định nghĩa
if (!defined('DB_NAME')) {
    define('DB_NAME', 'db_be1');
}

if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}

if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}

if (!defined('PORT')) {
    define('PORT', '3306');
}

if (!defined('DB_CHARSET')) {
    define('DB_CHARSET', 'utf8');
}

?>
