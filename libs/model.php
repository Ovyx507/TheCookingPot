<?
	
class Model{

	public $db;
	private $_req;
	private $q;

	private $dbg;

	protected $_model_name;
	protected $_primary_key = 'id';

	public $file_fields = array();
	public $image_fields = array();

	function __construct($model_name = ''){
		$this->db = new Database();
		$this->_req = Registry::get_instance();

		if(strlen($model_name))
		{
			$this->_model_name = $model_name;
		}
	}

	protected function _edit_row_basic($row)
	{
		$row['date_modified'] = time();
		if(isset($row[$this->_primary_key]))
		{	
			$id = $row['id'];
			$this->editSql($row);
		}

		return true;
	}

	protected function _add_row_images($insert_id, $existing_row = array())
	{
		if($insert_id && count($this->image_fields))
		{
			require_once('utility/l_files.php');
			$l_files = new L_files();

			$row = array();
			foreach($this->image_fields as $field => $thumbs)
			{
				$l_files->photo_thumbs = $thumbs;
				$path = APP_PATH_ROOT.APP_URL_PRE.'uploads/'.$this->_model_name.'/'.$field.'/';

				$file_field = $field;
				if($existing_row[$field])
				{
					$file_field = $existing_row[$field];
				}

				$filename = $l_files->upload_photo($file_field, $path, $insert_id);

				if($filename)
				{
					$row[$field] = $filename;
				}
			}
			if(count($row))
			{
				$row['id'] = $insert_id;
				$this->_edit_row_basic($row);
			}
		}
	}

	public function debug($st)
	{
		$this->dbg = $st;
	}

	private function dbg()
	{
		echo $this->q.'<br/>';
	}

	public function sanitize($input = "1")
	{
		$input = mysqli_real_escape_string($this->db->dbLink,$input);

		return $input;
	}

	private function _show_columns($sql)
	{
		$var = mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

		$newArray = array();

		$k = 0;

		while ($vars = mysqli_fetch_array($var))
		{
			$k++;
			if (is_array($vars))
			{
				foreach($vars as $key => $value)
				{
					if(is_numeric($key))
					{
						unset($vars[$key]);
					}
				}
			}
			$newArray[$k] = $vars;
		}

		if (is_array($newArray) && !empty($newArray))
			return $newArray;
		else
			return 0;
	}

	private function GetOne($sql)
	{
		$var = mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

		if (mysqli_num_rows($var))
			return array_values(mysqli_fetch_array($var))[0];
		else
			return 0;
	}

	private function GetRow($sql)
	{
		$var = mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

		$vars = mysqli_fetch_array($var);
		if (is_array($vars))
			{
				foreach($vars as $key => $value)
				{
					if(is_numeric($key))
					{
						unset($vars[$key]);
					}
				}
			}
		$newArray = $vars;

		if (is_array($newArray) && !empty($newArray))
			return $newArray;
		else
			return false;

	}

	private function GetSql($sql)
	{
		$var = mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));
		$newArray = array();

		$k = 0;

		while ($vars = mysqli_fetch_array($var))
		{
			$k++;
			if (is_array($vars))
			{
				foreach($vars as $key => $value)
				{
					if(is_numeric($key))
					{
						unset($vars[$key]);
					}
				}
			}
			$newArray[$k] = $vars;
		}

		if (is_array($newArray) && !empty($newArray))
			return $newArray;
		else
			return 0;
	}

	private function insertSql($rows = array())
	{

		$where = "";
		$what = "";

		foreach($rows as $key => $row)
		{
			$where = "`".$key."`,".$where;
			if (!is_numeric($row))
				$what =  '"'.mysqli_real_escape_string($this->db->dbLink,$row).'",'.$what;
			else
				$what = "'".$row."',".$what;
		}
		$where = "(".substr($where,0,strlen($where)-1);
		$where = $where.", `date_created`, `date_modified`, `ip`)";

		$what = "(".substr($what,0,strlen($what)-1);
		$what = $what.",'".time()."'".",'".time()."'".",'".$_SERVER['REMOTE_ADDR']."')";
		
		$sql = "INSERT INTO `".$this->_model_name."`".$where." VALUES ".$what;

		//executing query
		mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

		//retrieving last inserted id;
		return mysqli_insert_id($this->db->dbLink);
	}


	private function editSql($rows = array())
	{
		
		$where = "";

		foreach($rows as $key => $row)
		{
			if ($key != "id")
			{
				if (is_numeric($row))
				{
					$where = "`".$key."` = '".$row."',".$where;
				}
				else
				{
					$where = '`'.$key.'` = "'.mysqli_real_escape_string($this->db->dbLink,$row).'",'.$where;
				}
			}
		}
		$where = $where."`date_modified`='".time()."',`ip`='".$_SERVER['REMOTE_ADDR']."'";

		if ($where)
		{
			//$where = substr($where,0,strlen($where)-1);
			
			$sql = "UPDATE ".$this->_model_name." SET ".$where." WHERE id = ".$rows['id'];


			//executing query
			mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

			return 1;
		}
		else
		{
			return 0;
		}
	}

	// SQL operating comands //

	public function add($row = array())
	{
		unset($row['submit']);
		if($this->_model_name)
		{
			$id = $this->insertSql($row);
			$this->_add_row_images($id, $data);

			return $id ? $id : false;
		}

		return false;
	}


	public function select_all($select = '*', $afterWhere = '1', $beforeWhere = '')
	{
		$this->q = 'SELECT '.$select.' FROM '.$this->_model_name.' '.$beforeWhere.' WHERE '.$afterWhere;

		if($this->dbg)
		{
			$this->dbg();
		}

		return $this->GetSql($this->q);
	}

	public function edit_row($row = array())
	{
		if($this->_model_name)
		{
			$id = $this->editSql($row);
			$this->_add_row_images($id, $data);

			return true;
		}
	}

	public function delete_row($id, $where = "id")
	{
		return mysqli_query($this->db->dbLink,'DELETE FROM '.$this->_model_name.' WHERE '.$where.' = '.(int)$id);
	}

	public function select_one($select = '*', $afterWhere = '1', $beforeWhere = '')
	{
		$this->q = 'SELECT '.$select.' FROM '.$this->_model_name.' '.$beforeWhere.' WHERE '.$afterWhere;

		if($this->dbg)
		{
			$this->dbg();
		}

		return $this->GetOne($this->q);
	}

	public function select_row($select = '*', $afterWhere = '1', $beforeWhere = '')
	{
		$this->q = 'SELECT '.$select.' FROM '.$this->_model_name.' '.$beforeWhere.' WHERE '.$afterWhere;

		if($this->dbg)
		{
			$this->dbg();
		}

		return $this->GetRow($this->q);
	}

	public function selectCol($select = '*', $afterWhere = '1', $beforeWhere = '')
	{
		$this->q = 'SELECT '.$select.' FROM '.$this->_model_name.' '.$beforeWhere.' WHERE '.$afterWhere;

		if($this->dbg)
		{
			$this->dbg();
		}

		return $this->GetSql($this->q);
	}

	public function execute($sql)
	{
		mysqli_query($this->db->dbLink,$sql) or die(mysqli_error($this->db->dbLink));

		return 1;
	}

	public function show_columns()
	{
		return $this->_show_columns('describe '.$this->_model_name);
	}
	
}

?>