<?php
 
/**
 * @Package: Micul-Programator.ro firewall
 * @Author: Marian
 * @$Date: 06/08/2014
 * @Contact: contact@micul-programato.ro
 * @$Rev: 1
 */
 
class Firewall {
 
 
private $_protection = array(
'_ENTITIES' => FALSE,
'_XSS' => FALSE,
'_RFI' => FALSE,
'_SQLI' => FALSE,
);
 
private $_detection = array(
'XSS' => FALSE,
'RFI' => FALSE,
'SQLI' => FALSE
);
 
private $_logs = 'security/logs.txt';
 
/**
  * Constructorul clasei seteaza protectia si detectia vulnerabilitatilor
  * @param array $protection -> lista de vulnerabilitati pentru care clasa ofera protectie
  * @param array $detection -> lista de vulnerabilitati pentru care clasa ofera detectie
  * @return void
  */
public function __construct($protection = array() ,$detection = array()) {
 
	if (count($protection)) {
	 
		foreach ($protection as $key => $val) {
		 
			if (array_key_exists($key , $this->_protection) && is_bool($val)) {
			 
				$this->_protection[$key] = $val;
			}
	 
		}
	}
 
	if (count($detection)) {
	 
		foreach ($detection as $key => $val) {
		 
			if (array_key_exists($key , $this->_detection) && is_bool($val)) {
			 
			$this->_detection[$key] = $val;
			}
		 
		}
	}
	 
 
 
}
 
/**
* Scrierea logorilor in cazul detectari atacurilor
* @param string -> tipul de atac xss, sqli, rfi
* @return void
*/
function write_logs($attack = "XSS", $item = "--unknown--") {
 
$mesaj = "======================================================================\n";
$mesaj .= "Tip atac: ".$attack." \n";
$mesaj .= " Data : ". date("Y-m-d H:i:s"). "\n";
$mesaj .= " IP : ".$_SERVER['REMOTE_ADDR']. "\n";
$mesaj .= " Request: ".$_SERVER['REQUEST_URI']."\n";
$mesaj .= " Attack input: ".$item."\n";
$mesaj .= "=======================================================================\n";
 
file_put_contents($this->_logs, $mesaj, FILE_APPEND);
}
 
/**
* Functia pune in "functiune" mecanismul de protectie impotriva vulnerabilitatilor
* @param null
* @return void
*/
public function enableProtection() {
 
	foreach ($this->_protection as $key => $val) 
	{
	 
		if ($val === TRUE) 
		{
		 
			if (method_exists($this,$key)) 
			{
				call_user_func(get_class($this)."::".$key);
			}
		}
	 
	}
 
}
 
/**
* Functia pune in "functiune" mecanismul de detectie a vulnerabilitatilor
* @param null
* @return void
*/
public function enableDetection() {
 
	foreach ($this->_detection as $key => $val) {
	 
		if ($val === TRUE) {
		 
			if (method_exists($this,$key)) {
				call_user_func(get_class($this)."::".$key);
			}
		}
	 
	}
 
}
 
/**
* Transforma recursiv valorile variabilelor get,post,cookie in entitati html, bineinteles doar ce poate fi transalatat
* @param null
* @return void
*/
private function _ENTITIES() {
 
array_walk_recursive($_GET,get_class($this)."::_callHTMLENTITIES");
array_walk_recursive($_POST,get_class($this)."::_callHTMLENTITIES");
array_walk_recursive($_COOKIE,get_class($this)."::_callHTMLENTITIES");
 
}
 
private function _callHTMLENTITIES(&$item, $key) {
 
$item = htmlentities($item, ENT_QUOTES,'utf-8');
 
}
 
/*************************** XSS detection/protection ***************/
 
/**
  * Filtreaza recursiv valorile din get,post,cookie pentru a oferi protectie xss
  * @param null
  * @return void
  */
private function _XSS() {
 
array_walk_recursive($_GET,get_class($this)."::_callXSS");
array_walk_recursive($_POST,get_class($this)."::_callXSS");
array_walk_recursive($_COOKIE,get_class($this)."::_callXSS");
 
}
 
/**
* Detecteaza recursiv un atac xss, in caz de atac scrie log si opreste executarea sciptului
* @param null
* @return void
*/
 
private function XSS() {
 
array_walk_recursive($_GET,get_class($this)."::_detectXSS");
array_walk_recursive($_POST,get_class($this)."::_detectXSS");
array_walk_recursive($_COOKIE,get_class($this)."::_detectXSS");
 
}
 
private function _callXSS(&$item, $key) {
 
$item = filter_var($item, FILTER_SANITIZE_STRING);
 
}
 
private function _detectXSS($item, $key) {
 
if ($item != strip_tags($item)) {
$this->write_logs("XSS");
die();
}
 
}
 
/****************************END XSS******************************/
 
/****************SQL INJECTION detection/protection**************/
 
/**
  * Protectie recurisva pe toti parametri get,post si cookie.
  * @param null
  * @return void
  */
	private function _SQLI() {
	 
		array_walk_recursive($_GET,get_class($this)."::_callSQLI");
		array_walk_recursive($_POST,get_class($this)."::_callSQLI");
		array_walk_recursive($_COOKIE,get_class($this)."::_callSQLI");
	 
	}
/**
  * Detectie sqli recurisva pe toti parametri get,post si cookie.
  * @param null
  * @return void
  */
	private function SQLI() {
	 
		array_walk_recursive($_GET,get_class($this)."::_detectSQLI");
		array_walk_recursive($_POST,get_class($this)."::_detectSQLI");
		array_walk_recursive($_COOKIE,get_class($this)."::_detectSQLI");
	 
	}
 
	private function _callSQLI(&$item, $key) {
		$item = mysql_real_escape_string($item);
	}
 
	private function _detectSQLI($item, $key) {
	 
		$sqli = array(
		"'",
		"\"",
		'*/from/*',
		'*all*',
		'+all+',
		' all ',
		'*/insert/*',
		'+insert+',
		'+into+',
		'%20into%20',
		'*/into/*',
		' into ',
		'*/limit/*',
		'+select ',
		' select+',
		'*/select/*',
		'+select+',
		'%20select%20',
		' select ',
		'+union+',
		'%20union%20',
		'*/union/*',
		' union ',
		' union+',
		'+union ',
		'*/update/*',
		'*/where/*',
		'select @@version',
		'select user()',
		'select database()',
		'select @@datadir;',
		'select benchmark',
		'+load_file+',
		' load_file ',
		'*/load_file/*',
		"' or 1=1--",
		'" or 1=1--',
		"' or 0=0 --",
		" --",
		"%20--",
		"'OR''='",
		);

		//print_r($sqli);
		 
		$sqli = str_replace($sqli, '[sqli]', strtolower($item)); 
			if ($sqli != strtolower($item) && !strstr($item,"http://")) {
				//echo $item;
				$this->write_logs("SQL INJECTION",$item);

				header("Location: ".APP_PATH);
				die();
			}
	}
 
/*********************** END SQLI *********************************/
 
/*************************RFI detection/protection ****************/
 
/**
  * Protectie recurisva impotriva rfi pe toti parametri get,post si cookie.
  * @param null
  * @return void
  */
 
private function _RFI() {
 
array_walk_recursive($_GET,get_class($this)."::_callRFI");
array_walk_recursive($_POST,get_class($this)."::_callRFI");
array_walk_recursive($_COOKIE,get_class($this)."::_callRFI");
 
}
/**
  * Detectie recurisva rfi pe toti parametri get,post si cookie.
  * @param null
  * @return void
  */
private function RFI() {

	//print_r($_GET);
 
	array_walk_recursive($_GET,get_class($this)."::_detectRFI");
	array_walk_recursive($_POST,get_class($this)."::_detectRFI");
	array_walk_recursive($_COOKIE,get_class($this)."::_detectRFI");
	 
}
 
private function _callRFI(&$item, $key) {
 
	if (filter_var($item, FILTER_VALIDATE_URL)) {
		$item = "";
	}
 
}
 
private function _detectRFI(&$item, $key) {

	$array = array('php','txt','js','asp','erb','gsp','jsp','py','pyc','pyo','pyd','html','pyx','pyw');

	if (filter_var($item, FILTER_VALIDATE_URL)) 
	{
		$url = explode(".", $item);

		if(in_array(end($url), $array))
		{
			$this->write_logs("RFI");
			die();
		}
	}
	 
}
 
 
/************************* END RFI ********************************/
 
 
 
 
 
}
 
?>
