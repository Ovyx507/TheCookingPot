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
				$vars['erori'] = "Combinatia nu este corecta!";
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
		$this->_req->self = 'profile';
		$vars['info'] = null;
		$vars['meniu'] = $this->view->render_contents('useri/meniu');

		$vars['row'] = $this->m_useri->select_row('u.*, COUNT(ua.id) as nr_achievements', 'u.id = '.$_SESSION['user_id'],'u LEFT JOIN useri_achievements as ua ON ua.id_user = '.$_SESSION['user_id']);

		$this->m_useri->is_not_logged();
		$this->view->title = 'Profile';
		$this->view->render('useri/profile', $vars);

	}
	
	public function ladder()
	{
		$vars['useri'] = $this->m_useri->selectCol('*','1 ORDER BY score DESC');
		$this->view->title = 'Ladder';
		$this->view->render('useri/ladder', $vars);
	}

	public function coupons()
	{
		$this->_req->self = 'coupons';

		$this->m_useri->is_not_logged();
		$vars['meniu'] = $this->view->render_contents('useri/meniu');
		//$vars['rows'] = $this->m_useri_achievements->select_all('ua.*, a.name as a_name', 'id_user = '.$_SESSION['user_id'],'ua LEFT JOIN achievements a ON a.id = ua.id_achievement');
		$vars['user'] = $this->m_useri->select_row('u.*, COUNT(ua.id) as nr_achievements', 'u.id = '.$_SESSION['user_id'],'u LEFT JOIN useri_achievements as ua ON ua.id_user = '.$_SESSION['user_id']);
		$vars['rows'] = $this->m_cupon->select_all('*');

		$this->view->title = 'Cupoane';
		$this->view->render('useri/coupons', $vars);
	}

	public function concurs_start($id)
	{
		if($id && $_SESSION['user_id'] != $id)
		{
			$id_reteta = $this->m_recipes->select_one('id', '1 ORDER BY RAND()');

			$id_concurs = $this->m_concursuri->add(array('id_user_1' => $_SESSION['user_id'], 'id_user_2' => $id, 'id_recipe' => $id_reteta, 'id_user_won' => 0));

			header('Location: '.APP_URL_PRE.'useri/concurs/'.$id_concurs);
			exit();
		}

		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}

	public function concursurile_mele()
	{
		$vars['rows'] = $this->m_concursuri->select_all('*', 'id_user_1 = '.$_SESSION['user_id'].' OR id_user_2 = '.$_SESSION['user_id']);

		$this->view->title="Concursurile mele";
		$this->view->render('useri/concursurile_mele', $vars);
	}

	public function concursuri()
	{
		$vars['rows'] = $this->m_concursuri->select_all('*', 'id_user_won = 0');

		$this->view->title="Concursuri active";
		$this->view->render('useri/concursuri', $vars);
	}

	public function concurs($id)
	{
		$vars['c'] = $id;
		$vars['recipe'] = $this->m_concursuri->select_row('r.*, c.date_created c_date','c.id = '.$id, 'c LEFT JOIN recipes r ON r.id = c.id_recipe');
		$vars['user_1'] = $this->m_concursuri->select_row('u.*, cd.poza, cd.nr_likes, cd.id cd_id','c.id = '.$id, 'c LEFT JOIN useri u ON u.id = c.id_user_1 LEFT JOIN concursuri_dovezi cd ON cd.id_concurs = c.id AND cd.id_user = u.id');
		$vars['user_2'] = $this->m_concursuri->select_row('u.*, cd.poza, cd.nr_likes, cd.id cd_id','c.id = '.$id, 'c LEFT JOIN useri u ON u.id = c.id_user_2 LEFT JOIN concursuri_dovezi cd ON cd.id_concurs = c.id AND cd.id_user = u.id');

		$this->view->title = 'Concurs';
		$this->view->render('index/concurs', $vars);
	}

	public function concurs_dovezi($id)
	{
		if(is_array($_POST) && !empty($_POST))
		{
			$cd['id_concurs'] = $id;
			$cd['id_user'] = $_SESSION['user_id'];
			$cd['nr_likes'] = 0;

			$this->m_concursuri_dovezi->add($cd);

			header('Location: '.$_SERVER['HTTP_REFERER']);
			exit();
		}
	}

	public function concurs_like($id)
	{
		if($id)
		{
			if($_COOKIE['likes_concurs'])
			{
				if(!in_array($id, unserialize($_COOKIE['likes_concurs'])) && $id)
				{
					$nr = $this->m_concursuri_dovezi->select_one('nr_likes', 'id = '.$id);
					$nr++;
					$this->m_concursuri_dovezi->edit_row(array('nr_likes' => $nr, 'id' => $id));

					$likes = $_COOKIE['likes_concurs'] ? unserialize($_COOKIE['likes_concurs']) : array($id);
					if(!in_array($id, unserialize($_COOKIE['likes'])))
					{
						array_push($likes, $id);
					}
					setcookie('likes_concurs', serialize($likes), time() + 365*24*3600, '/');
				}
			}
			else
			{
					$nr = $this->m_concursuri_dovezi->select_one('nr_likes', 'id = '.$id);
					$nr++;
					$this->m_concursuri_dovezi->edit_row(array('nr_likes' => $nr, 'id' => $id));

					$likes = $_COOKIE['likes_concurs'] ? unserialize($_COOKIE['likes_concurs']) : array($id);
					setcookie('likes_concurs', serialize($likes), time() + 365*24*3600, '/');
			}
		}

		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit();
	}

}


?>