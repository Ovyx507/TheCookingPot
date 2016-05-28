<?
abstract class Controller{

	public $vars;
	protected $_req;
	public $model_name;
	protected $db;

	function __construct()
	{
		$this->view = new View();
		$this->auth = new Auth();
		$this->_req = Registry::get_instance();
	}

	public function loadModel($name)
	{
		$path =	'model/m_'.$name.'.php';
		
		if (file_exists($path))
		{
			require 'model/m_'.$name.'.php';

			$modelName = 'M_'.$name;
			$this->db = new $modelName();
			$this->model_name = "m_".$name;
		}
		else
		{
			$name = 'model';
			require $name.'.php';

			$modelName = $name;
			$this->db = new $modelName();
			$this->model_name = $name;
		}

	}

	public function __get($var) {
		return $this->_req->get($var);
	}

}
?>