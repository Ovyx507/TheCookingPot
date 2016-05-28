<?php

class Database
{
	public $dbLink;


	public function __construct()
	{
		if(SERVER && SERVER_ROOT && DB_NAME)
		{
			$this->dbLink = mysqli_connect(SERVER,SERVER_ROOT,PASSWORD,DB_NAME);
		}
	}

	public function __destruct()
	{
		if($this->dbLink)
		{
			mysqli_close($this->dbLink);
		}
	}
}



?>