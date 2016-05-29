<?

class M_useri extends Model{

	public $titles = array(
		'1' => 'Starter',
		'10' => 'Ucenic',
		'25' => 'Initiat',
		'50' => 'Bruta',
		'80' => 'Rival',
		'110' => 'Rival extrem',
		'150' => 'Predator',
		'200' => 'Nasu\'',
		'300' => 'Spartan',
		'1000' => 'Jamie Oliver Wannabe',
		'2000' => 'Gurmand'
	);

	public function __construct(){
		parent::__construct('useri');
	}

	public function is_logged()
	{
		if($_SESSION['loggedin'])
		{
			header('Location: '.APP_URL_PRE);
			exit();
		}
		else
		{
			return 1;
		}
	}

	public function is_not_logged()
	{
		if($_SESSION['loggedin'])
		{
			return 1;
		}
		else
		{
			header('Location: '.APP_URL_PRE.'useri/login');
			exit();
		}
	}

	public function update_title($id, $score)
	{
		foreach($this->titles as $k => $t)
		{
			if($k <= $score)
			{
				$title = $t;
			}
			else
			{
				break;
			}
		}

		if($title)
		{
			$this->edit_row(array('id' => $id, 'title' => $title));

			$id_achiv = $this->_req->m_achievements->select_one('id', 'name = \''.$title.'\'');
			
			if(!$this->_req->m_useri_achievements->select_one('id','id_user = '.$id.' AND id_achievement = '.$id_achiv))
			{
				$this->_req->m_useri_achievements->add(array('id_user' => $id, 'id_achievement' => $id_achiv));
			}
		}
	}


}


?>