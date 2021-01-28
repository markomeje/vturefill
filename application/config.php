<?php

define('ENVIROMENT', 'development');
define('DEFAULT_CONTROLLER', 'login');
define('DEFAULT_METHOD', 'index');

define('SERVER_HTTPS', (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) === 'on') ? true : false);
define('DOMAIN',  SERVER_HTTPS === true ? $_ENV['LIVE_WEBSITE_DOMAIN'] : 'http://vturefill.build');

define('REFERER', isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');

define('PUBLIC_URL', DOMAIN.'/public');
define('SOFWARE_NAME', 'VTU Refill');

define('LOCAL_DATABASE_HOST', '127.0.0.1');
define('LOCAL_DATABASE_NAME', 'vturefill');
define('LOCAL_DATABASE_USERNAME', 'root');
define('LOCAL_DATABASE_PASSWORD', '');
define('LOCAL_DATABASE_CHARSET', 'UTF8');

/**
 * Live database details from .env file
 */
define('LIVE_DATABASE_HOST', $_ENV['LIVE_DATABASE_HOST']); 
define('LIVE_DATABASE_NAME', $_ENV['LIVE_DATABASE_NAME']); 
define('LIVE_DATABASE_USERNAME', $_ENV['LIVE_DATABASE_USERNAME']); 
define('LIVE_DATABASE_PASSWORD', $_ENV['LIVE_DATABASE_PASSWORD']); 
define('LIVE_DATABASE_CHARSET', $_ENV['LIVE_DATABASE_CHARSET']);

define('PAYSTACK_TEST_SECRET_KEY', 'sk_test_260a2fa0cbc5cf57e814c76e1cd2690342675de2');
define('PAYSTACK_TEST_PUBLIC_KEY', 'pk_test_1526345662bbf69407a146ce5a981c7a34609590');
define('PAYSTACK_LIVE_SECRET_KEY', $_ENV['PAYSTACK_LIVE_SECRET_KEY']);
define('PAYSTACK_LIVE_PUBLIC_KEY', $_ENV['PAYSTACK_LIVE_PUBLIC_KEY']);

define('MOBILE_AIRTIME_NG_API_KEY', $_ENV['MOBILE_AIRTIME_NG_API_KEY']);
define('MOBILE_AIRTIME_NG_USER_ID', $_ENV['MOBILE_AIRTIME_NG_USER_ID']);
define('MOBILE_AIRTIME_NG_API_BASE_URL', 'https://mobileairtimeng.com/httpapi');

define('COOKIE_PATH', '/'); 
define('COOKIE_DOMAIN', DOMAIN);
define('COOKIE_SECURE', false);
define('COOKIE_HTTP', false);
define('COOKIE_EXPIRY', 3600 * 24 * 15); /** 15 days **/

define('SESSION_COOKIE_NAME', 'hjkrueihi548ysgnk3kdnbmprgahit7483uj');
define('SESSION_COOKIE_EXPIRY', 3600 * 24 * 60); /** 60 Days **/
define('ENCRYPTION_KEY', 'H43ag5js60z4D86tgEsh6w4e385Y');
define('ACCESS_DENIED_EXPIRY', 3600 * 24); /** 60 Days **/

define('REMEMBER_ME_COOKIE_NAME', 'h89hIteIHB7nb5yh3ufer7fad2q9yv98');
define('REMEMBER_ME_COOKIE_EXPIRY', 3600 * 24 * 30); /** One Year **/

define('ACCESS_DENIED_KEY', '672kbauh892ytqBGKA89jnb');
define('LOGIN_FAILED_KEY', 'hjky456778434176HJuT67438');
define('LOGIN_FAILED_EXPIRY', 3600 * 3);

define('PAGINATION_DEFAULT_LIMIT', 30);
