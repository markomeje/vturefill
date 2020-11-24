<?php

//https://www.nellobytesystems.com/APIDatabundleV1.asp?UserID=CK7813492&APIKey=PX31277CI5QZ7F6K42YO62DMSF5V42YKI6RM2JKH3206279TMA26J5Z732SQSI86&MobileNetwork=01&DataPlan=1000&MobileNumber=08158212666&CallBackURL=https://vturefill.markomeje.com/orders

date_default_timezone_set("Africa/Lagos");
/**
 * ROOT - Thats the root of server filesystem eg "C:/xampp/htdocs/herium".
 * DS - Defining a foward slash with PHP DIRECTORY_SEPARATOR using str_replace.
 * DS - Handling windows back slash compatibility
 */
define("ROOT", str_replace("\\", "/", dirname(__FILE__)));
define("DS", str_replace("\\", "/", DIRECTORY_SEPARATOR));

/**
 * The path to the application, public, framework and views folder.
 */
define("FRAMEWORK_PATH", ROOT . DS . "framework");
define("APPLICATION_PATH", ROOT . DS . "application");
define("PUBLIC_PATH", ROOT . DS . "public");
define("VIEWS_PATH", PUBLIC_PATH . DS . "views"); 
define("BACKEND_PATH", VIEWS_PATH . DS . "backend");
define("FRONTEND_PATH", VIEWS_PATH . DS . "frontend");

/**
 * Standard PHP way of autoloading classes - Using composer.
 */
require ROOT . DS . "vendor" . DS . "autoload.php";
/*
|--------------------------------------------------------------------------
| Storing sensitive data in .env file
|--------------------------------------------------------------------------
|
| All live database credentials and any api keys are registered
| Highly recommended for security purposes
|
*/
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__, ".env");
$dotenv->load();
$dotenv->required(["LIVE_DATABASE_HOST", "LIVE_DATABASE_NAME", "LIVE_DATABASE_USERNAME", "LIVE_DATABASE_PASSWORD", "LIVE_DATABASE_CHARSET"]);

/**
 * Requiring the configuration file.
 *
 */
require APPLICATION_PATH . DS . "config.php";

/**
 * Starting the session at the root
 * To avoid session error.
 */
VTURefill\Library\Session::start();


/*
|--------------------------------------------------------------------------
| Register Error & Exception handlers
|--------------------------------------------------------------------------
|
| Here we will register the methods that will fire whenever there is an error
| or an exception has been thrown.
|
*/
VTURefill\Core\Handler::register();

/**
 * [$request description]
 * @var VTURefill
 */
$request = new VTURefill\Http\Request;
$app = new VTURefill\Core\Parser($request);

/**
 * ---------------------------------------------------------------------
 * [Route the application]
 * ---------------------------------------------------------------------
 * 
 * @var [type] Mixed
 */
$app->router->route();

