<?
class C_error extends Controller{

	protected $model;

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		header('Location: '.APP_URL_PRE);
		exit;
	}

	public function error()
	{

	}


}
?>