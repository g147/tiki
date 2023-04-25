<?php

/**
 * GIT VERSION: 10813
 *
 * Some of the following constants are automatically filled in when
 * the build process is run. If you change them in site/index.php
 * and rerun the build process your changes will be lost
 *
 * APP_PATH   absolute path to the php files of the app
 * DEBUG_MODE flag to enable easier debugging and development
 * CACHE_ID   unique string to bust js/css browser caching for a new build
 * SITE_ID    random site id used for page keys
 */
define('APP_PATH', '/home/roberto/tikipack/24.1/tiki-24.1/vendor_bundled/vendor/jason-munro/cypht/');
define('VENDOR_PATH', APP_PATH.'vendor/');
define('WEB_ROOT', '');
define('DEBUG_MODE', false);
define('CACHE_ID', 'K6zdCdXkAAr34hAyvE0A%2FDXix42cRmiy9HwY7%2BgEZfs%3D');
define('SITE_ID', 'tDc9Hax%2B3Hws9yJNx06AsT4KAc1RqMGc53QmjEllpPRRQ6TIcqpdmNogbC%2Big6G71dUQBUu0wb3GkwaQ6u%2B5IQ%3D%3D');
define('JS_HASH', 'sha512-nkRR+keBqtWZPokrhivvFussRuQOHt1ZD5md8vgxMkwx4+IcdGuX/8KQAyy8J+ad4gyQzEag6DiG2vjSc9lDfQ==');
define('CSS_HASH', 'sha512-c6zFDIYBrfYW8cvNm6ZsqWvSM3A13UMMz0NMCBEx2hmXBG8XJY/D5AsMDepzjggQbEY8KRulFs7k2+LZaw+aNg==');

/* show all warnings in debug mode */
if (DEBUG_MODE) {
    error_reporting(E_ALL | E_STRICT);
}

/* config file location */
define('CONFIG_FILE', APP_PATH.'hm3.rc');

/* don't let anything output content until we are ready */
ob_start();

/* set default TZ */
date_default_timezone_set( 'UTC' );

/* get includes */
require APP_PATH.'lib/framework.php';

/* get configuration */
$config = new Hm_Site_Config_File(CONFIG_FILE);

/* setup ini settings */
if (!$config->get('disable_ini_settings')) {
    require APP_PATH.'lib/ini_set.php';
}

/* process the request */
new Hm_Dispatch($config);

/* log some debug stats about the page */
if (DEBUG_MODE) {
    Hm_Debug::load_page_stats();
    Hm_Debug::show();
}
