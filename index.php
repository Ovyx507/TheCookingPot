<?

error_reporting(E_ALL & ~E_NOTICE);

require 'config/paths.php';
require 'config/database.php';

require 'utility/auth.php';
require 'utility/utility.php';
require 'utility/H_html.php';
require 'utility/h_form_bs.php';
require 'utility/functions.misc.php';

//security against SQLI,XSS,RFI..
//require 'security/firewall.php';
 
$protection = array(
	'_ENTITIES' => TRUE,
	'_XSS' => TRUE,
	'_RFI' => TRUE,
	'_SQLI' => FALSE,
);
$detection = array(
	'XSS' => TRUE,
	'RFI' => TRUE,
	'SQLI' => TRUE
);
 
//$obj = new Firewall($protection,$detection);
//$obj->enableDetection();
//$obj->enableProtection();

//----end of security-----


//use an autoloader
	
function __autoload($class)
{
	$class = strtolower($class);
	$file = APP_LIBS.$class.'.php';
	if(is_file($file) === false)
	{
		return false;
	}

	require_once($file);
}


$app = new Bootstrap();

include 'config/router.php';
$app->call_controller();

?>