<?

class C_index extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index()
	{	
		$vars['rows'] = $this->m_recipes->select_all('r.*,CONCAT(u.name," ",u.surname) as name_u','1','r left join useri u on r.id_user=u.id');
		$this->view->title = 'TheCookingPot';
		$this->view->render('index/index', $vars);
	}

}


?>