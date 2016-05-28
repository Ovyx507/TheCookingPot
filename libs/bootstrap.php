<?

class Bootstrap{

	private $url;

	public $routes = array();

	function __construct(){
	}

	private function _parse_routes($uri)
	{
		if(count($this->routes) === 0)
		{
			return $uri;
		}

		if(isset($this->routes[$uri]))
		{
			return $this->routes[$uri];
		}
				
		foreach($this->routes as $key => $val)
		{						
			// Convert wild-cards -> RegEx
			$key = str_replace(':any', '.+', str_replace(':num', '[0-9]+', $key));
			
			// RegEx match?
			if(preg_match('#^'.$key.'$#', $uri))
			{			
				// Back-reference?
				if (strpos($val, '$') !== FALSE AND strpos($key, '(') !== FALSE)
				{
					$val = preg_replace('#^'.$key.'$#', $val, $uri);
				}
				return $val;
			}
		}
		return $uri;
	}

	public function call_controller()
	{
		date_default_timezone_set('Europe/Bucharest');
		
		$this->url = $_GET['url'];
		$this->url = rtrim($this->url,'/');

		$this->url = $this->_parse_routes($this->url);

		$this->url = explode('/',$this->url);

		if (empty($this->url[0]))
		{
			$file = CONTROLLER.'c_index.php';

			if(file_exists($file))
			{
				require CONTROLLER.'c_index.php';
				$controller = new C_Index;
				$controller->loadModel('');
				$controller->index();
				exit();
			}
			else
			{
				echo "<p><span style='color:red;'>Error</span>: No c_index.php controller available.</p>";
				exit;
			}
		}
		else
		{
			$file = CONTROLLER.'c_'.$this->url[0].'.php';

			if (file_exists($file))
			{
				require($file);
			}
			else
			{
				$file = CONTROLLER.'c_error.php';

				if(file_exists($file))
				{
					require CONTROLLER.'c_error.php';
					$error = new C_Error("model");

					$error->error();

					return false;
				}
				else
				{
					echo "<p><span style='color:red;'>Error</span>: No c_error.php controller available.</p>";
					exit;
				}
			}

			//calling methods

			if (isset($this->url[0]))
			{
				$load = "C_".$this->url[0];
				$controller = new $load;//loading controller
				$controller->loadModel($this->url[0]);//loading model


				if (isset($this->url[1]))
				{
					if (method_exists($controller, $this->url[1]))
					{
						if (isset($this->url[2]))
						{
							if (isset($this->url[3]))
							{
								$controller->{$this->url[1]}($this->url[2],$this->url[3]);
							}
							else
							{
								$controller->{$this->url[1]}($this->url[2]);
							}
						}
						else
						{
							$controller->{$this->url[1]}();
						}
					}
					else
					{
						require CONTROLLER.'c_error.php';
						$error = new C_error();
						
						$error->index();
						return false;
					}
				}
				else
				{
					$controller->index();
				}
			}
			else
			{
				require CONTROLLER.'c_index.php';
			}
		}
	}



	public function getUrl()
	{
		return $this->url;
	}


}


?>