<?php

class H_form_bs {

	static public $i = 0;

	static private function _make_sticker($type, $value, $settings)
	{
		return self::_row($type, '<p class="form-control-static">'.$value.'</p>', $settings);
	}

	static public function _row($type, $code, $settings = array(), $props = array())
	{
		if(isset($settings['stripped']) === false || $settings['stripped'] == false)
		{
			self::$i++;
			//$classes = (self::$i%2 ? 'odd' : 'even');
			$classes = ucfirst($type);

			$label = '';
			$extra_label = '';
			$addon = '';
			if(isset($settings['required']) && $settings['required'] == true)
			{
				$classes.= ' req';
				$extra_label = '<span style="color: red; font-weight: bold;">*</span>';
			}

			if(isset($settings['addon']) && strlen($settings['addon']))
			{
				$addon = '<span class="input-group-addon">'.$settings['addon'].'</span>';
				$row_class = 'input-group';
			}
			else
			{
				$row_class = 'form-group';
				if(isset($settings['title']) && strlen($settings['title']))
				{
					if(isset($settings['TII']) === false || $settings['TII'] == false)
					{
						if(isset($settings['after']) && strlen($settings['after']))
						{
							$settings['title'] = '<span class="toolt" data-toggle="tooltip" data-placement="bottom" title="'.$settings['after'].'"><span class="glyphicon glyphicon-info-sign"></span> '.$settings['title'].'</span>';
						}

						$label = '<label class="control-label" for="'.$props['id'].'">'.$settings['title'].$extra_label.'</label>';
					}
				}
			}

			return '<div class="'.$row_class.' '.$classes.'">'.$label.$addon.$code.'</div>';
		}
		return $code;
	}

	static public function input_text($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'text';

		if(isset($settings['sticker']) && $settings['sticker'] == true)
		{
			return self::_make_sticker($props['type'], $value, $settings);
		}

		$props['name'] = $name;
		$props['value'] = $value;
		$props['id'] = !empty($props['id']) ? $props['id'] : 'input_'.$props['name'];
		$props['class'] = 'form-control'.(!empty($props['class']) ? ' '.$props['class'] : '');
		
		if(isset($settings['TII']) && $settings['TII'] === true && isset($settings['title']) && strlen($settings['title']))
		{
			$props['placeholder'] = $settings['title'];
		}
	
		return self::_row($props['type'], '<input'.H_html::make_properties($props).'/>', $settings, $props);
	}

	static public function input_hidden($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'hidden';
		$props['name'] = $name;
		$props['value'] = $value;

		return '<input'.H_html::make_properties($props).'/>';
	}

	static public function input_password($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'password';
		$props['name'] = $name;
		$props['value'] = $value;
		$props['id'] = $props['id'] ? $props['id'] : 'input_'.$props['name'];
		$props['class'] = 'form-control'.(strlen($props['class']) ? ' '.$props['class'] : '');

		if(isset($settings['TII']) && $settings['TII'] === true && isset($settings['title']) && strlen($settings['title']))
		{
			$props['placeholder'] = $settings['title'];
		}

		return self::_row($props['type'], '<input'.H_html::make_properties($props).'/>', $settings, $props);
	}

	static public function input_checkbox($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'checkbox';
		$props['name'] = $name;

		if(isset($settings['check_val']) === false)
		{
			$settings['check_val'] = 1;
		}
		$props['value'] = $settings['check_val'];

		return self::_row($props['type'], '<input'.H_html::make_properties($props).($value == $props['value'] ? ' checked' : '').'/>', $settings, $props);
	}

	static public function input_radio($name, $options = array(), $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'radio';
		$props['name'] = $name;

		if(isset($settings['separator']) === false)
		{
			$settings['separator'] = '&nbsp;';
		}

		$code = '';
		foreach($options as $key => $option)
		{
			$code.= '<input'.H_html::make_properties($props).' value="'.$key.'"'.($value == $key ? ' checked' : '').'/>'.$option.$settings['separator'];
		}
		return self::_row($props['type'], $code, $settings, $props);
	}

	static public function textarea($name, $value = '', $settings = array(), $props = array())
	{
		if(isset($settings['sticker']) && $settings['sticker'] == true)
		{
			return self::_make_sticker('textarea', $value, $settings);
		}
		
		$props['name'] = $name;
		$props['id'] = !empty($props['id']) ? $props['id'] : 'input_'.$props['name'];
		$props['class'] = 'form-control'.(!empty($props['class']) ? ' '.$props['class'] : '');

		if(isset($props['rows']) === false)
		{
			$props['rows'] = 5;
		}
		if(isset($props['cols']) === false)
		{
			$props['cols'] = 25;
		}

		if(isset($settings['TII']) && $settings['TII'] === true && isset($settings['title']) && strlen($settings['title']))
		{
			$props['placeholder'] = $settings['title'];
		}

		return self::_row('textarea', '<textarea'.H_html::make_properties($props).'>'.$value.'</textarea>', $settings, $props);
	}

	static public function fck($name, $value = '', $settings = array(), $props = array())
	{
		if(isset($settings['sticker']) && $settings['sticker'] == true)
		{
			return self::_make_sticker('fck', $value, $settings);
		}
		
		$props['name'] = $name;
		$props['class'] = 'ckeditor';

		if(isset($props['rows']) === false)
		{
			$props['rows'] = 5;
		}
		if(isset($props['cols']) === false)
		{
			$props['cols'] = 25;
		}

		$registry = Registry::get_instance();
		$registry->render->add_in_head(H_html::script(SYS_URL.'_library_3p/ckeditor/ckeditor.js'));

		return self::_row('fck', '<textarea'.H_html::make_properties($props).'>'.$value.'</textarea>', $settings, $props);
	}


	static public function select($name, $options = array(), $value = array(), $settings = array(), $props = array())
	{
		if(isset($settings['sticker']) && $settings['sticker'] == true)
		{
			return self::_make_sticker('select', $options[$value], $settings);
		}
		
		$props['name'] = $name;
		$props['id'] = !empty($props['id']) ? $props['id'] : 'input_'.$props['name'];
		$props['class'] = 'form-control'.(!empty($props['class']) ? ' '.$props['class'] : '');

		$mt = '';
		if(isset($settings['multiple'])) {
			$mt = ' multiple';
			$props['size'] = $settings['multiple'];
		}

		if(is_array($value) === false)
		{
			$value = array($value);
		}

		$code = '<select'.H_html::make_properties($props).$mt.'>';
		foreach($options as $key => $option)
		{
			$code.= '<option value="'.$key.'"'.(in_array((string)$key, $value) ? ' selected="selected"' : '').'>'.$option.'</option>';
		}
		$code.= '</select>';
		return self::_row('select', $code, $settings, $props);
	}

	static public function input_submit($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'submit';
		$props['name'] = $name;
		$props['value'] = $value;

		return self::_row($props['type'], '<input'.H_html::make_properties($props).'/>', $settings, $props);
	}

	static public function input_image($name, $src = '', $settings = array(), $props = array())
	{
		$props['type'] = 'image';
		$props['name'] = $name;
		$props['value'] = $name;
		$props['src'] = $src;

		return self::_row($props['type'], '<input'.H_html::make_properties($props).'/>', $settings, $props);
	}

	static public function input_file($name, $value = '', $settings = array(), $props = array())
	{
		$props['type'] = 'file';
		$props['name'] = $name;
		$props['value'] = $value;
		$props['id'] = $props['id'] ? $props['id'] : 'input_'.$props['name'];

		return self::_row($props['type'], '<input'.H_html::make_properties($props).'/>', $settings, $props);
	}

	static public function email_valid($email)
	{
		if($email)
		{
			return preg_match("~^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$~", $email);
		}
		return false;
	}

	
}

?>
