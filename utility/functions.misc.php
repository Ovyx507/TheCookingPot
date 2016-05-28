<?

///////////////////////////////////////
//                                   //
//          Misc   Functions         //
//     (c) 2001 Agachi Valentin      //
//                                   //
///////////////////////////////////////


/////////////////
//    Debug    //
/////////////////

function d_array_as_string (&$array, $s = "", $column = 0) {
    $str = "<span style=\"color:#009900\">Array $s </span>(<br />\n";
    while(list($var, $val) = each($array)) {
		$str .= "<span style=\"color:white\">";
        for ($i = 0; $i < $column+1; $i++){
            $str .= "===";
        }
		$str .= "</span>";
        $str .= '[<span style="color:#3399CC">'.$var.'</span>] --> ';
        $str .= d_wr2($val, $var, $column + 1)."<br />\n";
    }
	$str .= "<span style=\"color:white\">";
    for ($i = 0; $i < $column; $i++){
        $str .= "=====";
    }
	$str .= "</span>)";
	reset($array);
    return $str;
}

function d_object_as_string (&$object, $s = "", $column = 0) {
    if (trim(get_class($object)) == "") {
        return "$object";
    }
    else {
		$str = "<span style=\"color:#009900\">Object ".get_class($object)." </span>(<br />\n";
		$vars = get_object_vars($object);
        while (list($var, $val) = each($vars)) {
			$str .= "<span style=\"color:white\">";
			for ($i = 0; $i < $column+1; $i++){
				$str .= "=====";
			}
			$str .= "</span>";
			$str .= '[<span style="color:#3399CC">'.$var.'</span>] --> ';
            $str .= d_wr2($val, "", $column+1)."<br />\n";
        }
		$vars = get_class_methods(get_class($object));
        while (list($id, $val) = each($vars)) {
			$str .= "<span style=\"color:white\">";
			for ($i = 0; $i < $column+1; $i++){
				$str .= "=====";
			}
			$str .= "</span><span style=\"color:#FF0000\">";
            $str .= $val."</span>()<br />\n";
        }
		$str .= "<span style=\"color:white\">";
        for ($i = 0; $i < $column-1; $i++){
            $str .= "=====";
        }
		$str .= "</span>)";
        return $str;
    }
}

function d_wr2(&$thing, $s = "", $column = 0) {
    if (is_object($thing)) {
        return d_object_as_string($thing, $s, $column);
    }
    elseif (is_array($thing)) {
        return d_array_as_string($thing, $s, $column);
    }
    elseif (is_double($thing)) {
        return "Double(<span style=\"color:#0000CC\">".$thing."</span>)";
    }
    elseif (is_long($thing)) {
        return "Long(<span style=\"color:#0000CC\">".$thing."</span>)";
    }
    elseif (is_string($thing)) {
        return "String(<span style=\"color:#FF00CC\">".htmlentities($thing)."</span>)";
    }
	elseif (is_bool($thing)) {
		if ($thing)
			return "Bool(<span style=\"color:#CC0000\">True</span>)";
		else return "Bool(<span style=\"color:#CC0000\">False</span>)";
	}
    else {
        return "Unknown(<span style=\"color:#CC0000\">".$thing."</span>)";
    }
}

function wr(&$thing, $s = "") {
	echo "<span style=\"font-family:Tahoma; font-size:8pt; font-weight:bold\">";
	echo d_wr2($thing, $s);
	echo "</span>";
}

?>