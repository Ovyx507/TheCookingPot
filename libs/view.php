<?
class View{
		
	public $vars;
	private $_req;
	public $title;

	function __construct(){

		$this->_req = Registry::get_instance();
		$this->title = '';
	
	}

	public function render($name, $vars = array(), $includePath = "", $include = true)
	{
		if ($include == false)
		{
			require 'views/'.$name.'.php';
			return file_get_contents('views/'.$name.'.php');
		}
		else
		{
			if ($includePath)
			{
				require 'public/standard/head.php';
				require 'views/'.$includePath.'/header.php';
				require 'views/'.$name.'.php';
				require 'views/'.$includePath.'/footer.php';
				require 'public/standard/end.php';

			}
			else
			{
				if (strstr($name,"admin"))
				{
					require 'public/admin/head.php';
					require 'views/admin/header.php';
					require 'views/'.$name.'.php';
					require 'views/admin/footer.php';
					require 'public/admin/end.php';
				}
				else
				{
					require 'public/standard/head.php';
					require 'views/header.php';
					require 'views/'.$name.'.php';
					require 'views/footer.php';
					require 'public/standard/end.php';
				}
			}
		}

	}

	public function render_contents($name = "", $vars = array())
	{
		ob_start();

		require 'views/'.$name.'.php'; 
		$output = ob_get_contents();

		ob_end_clean();

		return $output;

	}

}





?>