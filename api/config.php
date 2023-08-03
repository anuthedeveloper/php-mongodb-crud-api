<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type:application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Credentials: true');
// 
ini_set("display_errors", 1);

require __DIR__ . "/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

// Set the new timezone
date_default_timezone_set('Africa/Lagos');

define('MONGO_URI', getenv('MONGO_URI'));

/** Sets up webpdo db vars */
global $db;

if ( isset($db) ) return;

$db = (new MongoDB\Client)->mdb;

// $result = $db->createCollection('testCollection');

spl_autoload_register(function($class){
    $filepath = str_replace(
        '\\', // Replace all namespace separators...
        '/',  // ...with their file system equivalents
        __DIR__ . "/classes/{$class}.php"
    );

    if (is_file(strtolower($filepath)))
        require_once strtolower($filepath);
});

