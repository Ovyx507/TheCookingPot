<?

class C_ingredients extends Controller{

	public function __construct(){
		parent::__construct();
	}

	public function index() {

		
		wr($this->m_ingredients->show_columns());
	}


}


?>