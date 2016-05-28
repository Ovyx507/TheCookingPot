<?

define('APP_PATH', 'http://'.$_SERVER['HTTP_HOST'].'/');
define('APP_PATH_ROOT', $_SERVER[DOCUMENT_ROOT]);
define('APP_URL_PRE', substr($_SERVER['SCRIPT_NAME'],0,strrpos($_SERVER['SCRIPT_NAME'],'/')+1));
define('APP_ROOT', APP_PATH.substr(APP_URL_PRE,1,strlen(APP_URL_PRE)));
define('APP_LIBS', 'libs/');
define('CONTROLLER', 'controllers/');
define('UPLOAD_DIR', 'uploads/');
define('PUBLIC_DIR', 'public/');


?>
