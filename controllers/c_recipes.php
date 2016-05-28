<?

class C_recipes extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function add()
	{	
		$this->m_useri->is_not_logged();
		
		if(!empty($_POST['ingredients']))
		{
			preg_match_all("/([\d\.\/]+) (\w+) ([^\d\n]+)/", $_POST['ingredients'], $regex_result);

			for ($i = 0, $size = count($regex_result[0]); $i < $size; ++$i) {
				$ingredients[] = array(
					'quantity' => $regex_result[1][$i], 
					'measure' => $regex_result[2][$i],
					'name' => $regex_result[3][$i]);
			}

			$query = $this->m_ingredients->select_all("name, calories, fats, carbohydrates, protein");
			

			foreach ($ingredients as $index => $ingredient) {
				
				foreach($query as $index => $query_ingredient)
					$distanced_ingredients[] = 
						array('distance' => levenshtein($ingredient['name'], $query_ingredient['name']),
							  'ingredient' => $query_ingredient);

				usort($distanced_ingredients, function ($lhs, $rhs) {
					return $lhs['distance'] < $rhs['distance'] ? -1 : 1;
				});
				
				if ($distanced_ingredients[0]['distance'] < 4)
					$matched_ingredient_list[] = array(
						'success' => true,
						'info' => $distanced_ingredients[0]['ingredient']); 
				else
					$matched_ingredient_list[] = array(
						'success' => false, 
						'info' => "No match for ".$ingredient['name']); 
				
				unset($distanced_ingredients);
			}
			wr($matched_ingredient_list);
			$vars['matched_ingredient_list'] = $matched_ingredient_list;
		}
		unset($_POST['ingredients']);

		if(is_array($_POST) && !empty($_POST))
		{
			$_POST['id_user'] = $_SESSION['user_id'];
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
			array_push($likes, array($id));
			setcookie('likes', serialize($likes), time() + 365*24*3600, '/');
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