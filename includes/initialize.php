<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : 
	define('SITE_ROOT', DS.'Applications'.DS.'MAMP'.DS.'htdocs'.DS.'alterra');

defined('LIB_PATH') ? null : 
	define('LIB_PATH', SITE_ROOT.DS.'includes');



require_once LIB_PATH.DS.'database.php';
require_once LIB_PATH.DS.'database_object.php';
require_once LIB_PATH.DS.'functions.php';
require_once LIB_PATH.DS.'avatar.php';
require_once LIB_PATH.DS.'config.php';
