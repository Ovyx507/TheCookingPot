<?

class M_concursuri_dovezi extends Model{

	public $image_fields = array(
		'poza' => array( 
			'micro' => array(300,300),
			'thumbs' => array(500,500),
		)
	);

	public function __construct(){
		parent::__construct('concursuri_dovezi');
	}

}


?>