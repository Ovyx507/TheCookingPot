<?

class M_ingredients extends Model{

	public $image_fields = array(
		'image' => array( 
			'micro' => array(100,100),
			'thumbs' => array(300,300),
		)
	);

	public function __construct(){
		parent::__construct('ingredients');
	}

}


?>