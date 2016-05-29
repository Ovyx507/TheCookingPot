<?

class C_useri extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{		
		header('Location: '.APP_URL_PRE.'useri/login');
		exit();
	}

	public function login()
	{	
		$this->m_useri->is_logged();

		if(is_array($_POST) && !empty($_POST))
		{
			if($id = $this->m_useri->select_one('id', 'email = \''.$_POST['email'].'\' AND password = \''.md5($_POST['password']).'\''))
			{
				$username = $this->m_useri->select_one('username','id='.$id);

				$this->auth->login($id, $username);

				header('Location: '.APP_URL_PRE);
				exit();
			}
			else
			{
				$vars['erori'] = "Combinatia nu este corecta!!";
			}
		}
		
		$this->view->title = 'Login';
		$this->view->render('useri/login', $vars);
	}

	public function logout()
	{
		$this->auth->logout();
		
		header('Location: '.APP_URL_PRE);
		exit();
	}

	public function register()
	{
		$this->m_useri->is_logged();

		if(is_array($_POST) && !empty($_POST))
		{
			if(!$this->m_useri->select_one('id', 'email = \''.$_POST['email'].'\''))
			{
				$_POST['password'] = md5($_POST['password']);
				$_POST['username'] = $_POST['name'].' '.$_POST['prenume'];

				$this->m_useri->add($_POST);

				$vars['succes'] = 'Succesfully registered.';
			}
			else
			{
				$vars['erori'] = 'User already exists.';
			}
		}

		$this->view->title = 'Register';
		$this->view->render('useri/register', $vars);
	}

	public function profile()
	{
		$vars['info'] = null;
		$this->m_useri->is_not_logged();
		$this->view->title = 'Profile';
		$this->view->render('useri/profile', $vars);

	}
	
	public function ladder()
	{
		$vars['useri'] = $this->m_useri->selectCol('id,name,score','1 ORDER BY score DESC');
		$this->view->title = 'Ladder';
		$this->view->render('useri/ladder', $vars);
	}

}


?>