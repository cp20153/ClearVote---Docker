<?php
/************************************************
File Name - Config.php
Purpose - To define constants and settings
*************************************************/
define('DB_HOST', 'db'); // Docker service name for the database
define('DB_USER', 'admin'); // Database user from docker-compose.yml
define('DB_PASS', '12345'); // Database password from docker-compose.yml
define('DB_NAME', 'clear_vote'); // Database name from docker-compose.yml

define('DB_DRIVER', 'MySql');
define('KEY', md5('youcantseeme'));
define('SITE_URL', 'http://192.168.0.78/clearvote_information');
define('SITE_NAME', 'ClearVote');
define('EMAIL_FROM', 'ClearVote');
define('EMAIL_FROM_NAME', 'ClearVote');
define('EMAIL_REPLY_TO', 'admin@clearvote_information.com');
define('EMAIL_REPLY_TO_NAME', 'ClearVote');
ini_set('display_errors', '1');
error_reporting(E_ALL);
date_default_timezone_set("America/New_York");

$con = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
?>
