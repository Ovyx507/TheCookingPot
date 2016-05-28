<?

class C_admin extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function add_ingredient()
	{	
		$insert_vals = $_POST;
		$insert = TRUE;
		if(!empty($insert_vals))
		{
			foreach($insert_vals as $val)
			{
				if(empty($val))
					$insert = FALSE;
			}
		}
		else
		{
			$insert = FALSE;
		}

		if($insert)
		{
			$id = $this->m_ingredients->add($insert_vals);
			if($id) {
				$vars['success'] = 1;
			} else {
				$vars['success'] = 0;
			}
		}
		else
		{
			//do ceva;
		}
		$this->view->title = 'Add Ingredient - TheCookingPot';
		$this->view->render('ingredients/add', $vars); 
	}

	public function show_edit_ingredient() 
	{
		$ingredient_id = $_GET['id'];
		$ingredient = $this->m_ingredients->select_row('*', 'id = \''.$ingredient_id.'\'');
		$vars['ingredient'] = $ingredient;
		$this->view->title = 'Edit Ingredient - The CookingPot';
		$this->view->render('ingredients/edit', $vars);
	}

	public function edit_ingredient()
	{
		$edit_vals = $_POST;
		$edit = TRUE;
		if(!empty($edit_vals))
		{
			foreach($edit_vals as $val)
			{
				if(empty($val))
					$edit = FALSE;
			}
		}
		else
		{
			$edit = FALSE;
		}

		if($edit)
		{
			$id = $this->m_ingredients->add($insert_vals);
			if($id) {
				$vars['success'] = 1;
			} else {
				$vars['success'] = 0;
			}
		}
		else
		{
			//do ceva;
		}
		
		$this->view->title = 'Edit Ingredient - TheCookingPot';
		$this->view->render('ingredients/edit', $vars);
	}

	public function list_ingredients()
	{
		$is_set = isset($_GET['id']);
		if($is_set) {
			$vars['ingredient_id'] = $is_set;
			$this->view->render('ingredients/list',$vars);
		}
		else
		{
			$rows = $this->m_ingredients->select_all('*','1');
			if($rows)
			{
				$vars['rows'] = $rows;
				$this->view->render('ingredients/list',$vars);
			}
		}
	}



	public function index() {

		wr($this->m_ingredients->show_columns());
	}


}


?>