<?

class C_recipes extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function add()
	{	
		$this->m_useri->is_not_logged();

		if(is_array($_POST) && !empty($_POST))
		{
			$_POST['id_user'] = $_SESSION['user_id'];
			$_POST['description'] = $_POST['description'].'<br/>'.$_POST['ingredients'];
			$id = $this->m_recipes->add($_POST);
			if($id)
			{
				header('Location: '.APP_URL_PRE.'index');
				exit();
			}
		}

		$this->view->title = 'Add Recipe - TheCookingPot';
		$this->view->render('recipes/add', $vars);
	}

	public function index()
	{
		$is_set = isset($_GET['id']);
		if(!$is_set)
			$this->view->render('recipes/index');
		else
		{
			$id = $_GET['id'];
			$row = $this->m_recipes->select_row('r.*, u.name as username','r.id = ' . $id,'r left join useri u on r.id_user = u.id');
			if($row)
			{
				$vars['row'] = $row;
				$vars['row']['nr_likes'] = $vars['row']['nr_likes'] ? $vars['row']['nr_likes'] : 0;

				$vars['comments'] = $this->m_recipes_comments->select_all('*', 'id_recipe = '.$row['id']);
				$this->view->title = $row['name'] . ' - TheCookingPot';
				$this->view->render('recipes/details',$vars);
			}
			else
				$this->view->render('recipes/index');
		}
	}

	public function like($id)
	{
		if($_COOKIE['likes'])
		{
			if(!in_array($id, unserialize($_COOKIE['likes'])) && $id)
			{
				$nr = $this->m_recipes->select_one('nr_likes', 'id = '.$id);
				$nr++;
				$this->m_recipes->edit_row(array('nr_likes' => $nr, 'id' => $id));

				$id_user = $this->m_recipes->select_one('id_user', 'id = '.$id);
				$score = $this->m_useri->select_one('score', 'id = '.$id_user);
				$score++;
				$this->m_useri->edit_row(array('score' => $score, 'id' => $id_user));

				$likes = $_COOKIE['likes'] ? unserialize($_COOKIE['likes']) : array($id);
				if(!in_array($id, unserialize($_COOKIE['likes'])))
				{
					array_push($likes, $id);
				}
				setcookie('likes', serialize($likes), time() + 365*24*3600, '/');

				$this->m_useri->update_title($id_user, $score);
			}
		}
		else
		{
				$nr = $this->m_recipes->select_one('nr_likes', 'id = '.$id);
				$nr++;
				$this->m_recipes->edit_row(array('nr_likes' => $nr, 'id' => $id));

				$id_user = $this->m_recipes->select_one('id_user', 'id = '.$id);
				$score = $this->m_useri->select_one('score', 'id = '.$id_user);
				$score++;
				$this->m_useri->edit_row(array('score' => $score, 'id' => $id_user));

				$likes = $_COOKIE['likes'] ? unserialize($_COOKIE['likes']) : array($id);
				setcookie('likes', serialize($likes), time() + 365*24*3600, '/');

				$this->m_useri->update_title($id_user, $score);
		}
		
		
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

	public function recipe_comment()
	{
		if($_POST)
		{
			if(strlen($_POST['comment']))
			{
				$comm['name'] = $_POST['name'] ? $_POST['name'] : 'User';
				$comm['comment'] = $_POST['comment'];
				$comm['id_recipe'] = $_POST['id_recipe'];

				$this->m_recipes_comments->add($comm);
			}
		}

		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}

}


?>