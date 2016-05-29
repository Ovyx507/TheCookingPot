<?
class Auth
{
	function __construct()
	{
		session_start();

		$stringTok = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$token=$stringTok[rand(1,52)].$stringTok[rand(1,52)].$stringTok[rand(1,52)].$stringTok[rand(1,52)].rand(100000,10000000).$stringTok[rand(1,52)].$stringTok[rand(1,52)].$stringTok[rand(1,52)].$stringTok[rand(1,52)];
		
		if (count($_SESSION['tokenCSRF']) < 1)
			$_SESSION['tokenCSRF'] = $token;
		

		if (!$_SESSION['loggedin'])
			$_SESSION['loggedin'] = 0;	
	}

	public function login($user_id = "", $email = "")
	{
		if($user_id && $email)
		{
			$_SESSION['loggedin'] = true;
			$_SESSION['user_id'] = $user_id;
			$_SESSION['username'] = $email;
		}

		header("Location: ".APP_URL_PRE);
		exit;
	}

	public function logout()
	{
		$_SESSION['loggedin'] = false;
		unset($_SESSION['user_id']);
		unset($_SESSION['email']);

		header("Location: ".APP_URL_PRE);
		exit;
	}

	public function is_logged()
	{
		return $_SESSION['loggedin'] ? 1 : 0;
	}



}





?>