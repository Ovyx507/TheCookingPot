<?

class M_useri extends Model{

	public function __construct(){
		parent::__construct('useri');
	}

	public function is_logged()
	{
		if($_SESSION['loggedin'])
		{
			header('Location: '.APP_URL_PRE);
			exit();
		}
		else
		{
			return 1;
		}
	}

	public function is_not_logged()
	{
		if($_SESSION['loggedin'])
		{
			return 1;
		}
		else
		{
			header('Location: '.APP_URL_PRE.'useri/login');
			exit();
		}
	}


}


?>