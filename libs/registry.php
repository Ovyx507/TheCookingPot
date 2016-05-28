<?

class Registry {

	private $_vars = array();
	private static $_singleton;

	public function set($index, $value)
	{
		$this->_vars[$index] = $value;
	}
	
	public function __set($index, $value)
	{
		$this->set($index, $value);
	}

	public function get($index)
	{
		if(isset($this->_vars[$index]) === false)
		{
			if(strlen($index) > 2 && substr($index,0,2) === 'm_')
			{
				$class = ucfirst($index);

				if(class_exists($class))
				{
					$this->set($index, new $class);
				}
				else
				{
					if(file_exists('model/'.strtolower($class).'.php'))
					{
						require_once('model/'.strtolower($class).'.php');
						$this->set($index, new $class);
					}
					else
					{
						$this->set($index, new Model(strtolower(substr($class,2))));
					}
				}
			}
		}

		return $this->_vars[$index];
	}
	
	public function __get($index)
	{
		return $this->get($index);
	}

	public static function get_instance()
	{
		if(is_null(self::$_singleton))
		{
			self::$_singleton = new Registry();
		}
		return self::$_singleton;
	}

}

?>