<?php

class H_html {

	static public function body_open()
	{
		$browser = '';
		if(strstr($_SERVER['HTTP_USER_AGENT'], 'Opera'))
		{
			$browser = 'opera';
		}
		if(strstr($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
		{
			$browser = 'firefox';
		}
		if(strstr($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
		{
			$browser = 'chrome';
		}
		if(strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE') && preg_match('/^Mozilla\/4\.0 \(compatible; MSIE ([0-9]\.[0-9])/i', $_SERVER['HTTP_USER_AGENT'], $matches))
		{
			$browser = 'ie'.floatval($matches[1]);
		}

		$reg = Registry::get_instance();

		$class = '';
		if($reg->auth->is_logged())
		{
			$class = 'logged';
		}
		else
		{
			$class = 'loggedout';
		}

		return '<body class="'.$reg->active_lang.' '.$reg->device_type.' '.$browser.' '.$class.($_SESSION['menu_collapse'] ? ' collapse-resize' : '').'">';
	}

	static public function title($inner_html)
	{
		return '<title>'.$inner_html.'</title>';
	}

	static public function meta($name, $content)
	{
		return '<meta name="'.$name.'" content="'.$content.'"/>';
	}

	static public function script($src, $type = 'text/javascript')
	{
		return '<script type="'.$type.'" src="'.$src.'"></script>';
	}

	static public function link($href, $type = 'text/css', $media = 'screen', $rel = 'stylesheet')
	{
		return '<link rel="'.$rel.'" type="'.$type.'" href="'.$href.'" media="'.$media.'"/>';
	}

	static public function a($inner_html, $href = '#', $props = array())
	{
		if(isset($props['title']) === false)
		{
			$props['title'] = strip_tags($inner_html);
		}
		return '<a href="'.$href.'"'.self::make_properties($props).'>'.$inner_html.'</a>';
	}

	static public function img($src, $props = array(), $dir4size = false)
	{
		if(isset($props['alt']) === false)
		{
			//$props['alt'] = $src;
		}
		if($dir4size)
		{
			$size = @getimagesize($dir4size);
			$props['width'] = $size[0];
			$props['height'] = $size[1];
		}
		return '<img src="'.$src.'"'.self::make_properties($props).'/>';
	}

	static public function aimg($src, $href = '#', $title = '', $props = array(), $dir4size = false)
	{
		$props['title'] = $title;
		return self::a(self::img($src, array('alt' => $title), $dir4size), $href, $props);
	}

	static public function make_properties($props = array())
	{
		$code = '';
		foreach($props as $property => $value)
		{
			if(isset($value) && strlen($value)) $code.= ' '.$property.'="'.$value.'"';
		}
		return $code;
	}
}

?>
