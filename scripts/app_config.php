<?php

// Set up debug mode
define("DEBUG_MODE", true);

//Site root
define("SITE_ROOT", "/popm/");

// Location of web files on host
define("HOST_WWW_ROOT", "/Applications/MAMP/htdocs/");

// Database connection constants
define("DATABASE_HOST", "popm-dev.chpawkmskbul.us-west-2.rds.amazonaws.com");
define("DATABASE_USERNAME", "processoriented");
define("DATABASE_PASSWORD", "6jQcdHehp4hyMNhn");
define("DATABASE_NAME", "processo_Dev");

function debug_print($message) {
    if (DEBUG_MODE) {
        echo $message;
    }
}

function handle_error($user_error_message, $system_error_message) {
	session_start();
	$_SESSION['error_message'] = $user_error_message;
	$_SESSION['system_error_message'] = $system_error_message;
    header("Location: ". SITE_ROOT . "show_error.php");
    exit();
}

function get_web_path($file_system_path) {
    return str_replace($_SERVER['DOCUMENT_ROOT'], '', $file_system_path);
}

?>