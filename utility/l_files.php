<?

class L_files {

	public $allowed_extensions = array('jpg','jpeg','gif','doc','xls','pdf','txt','flv','psd','swf','mp3','png');
	public $multimedia_extensions = array('jpg','jpeg');
	public $photo_thumbs = array(
		'photo'   => array(500, 200),
		'thumbs'  => array(100, 100),
		'thumbs2' => array(100, 100),
	);

	public $use_image_magick = false;
	
	public function dir_files($path)
	{
		if(!file_exists($path) || !is_dir($path))
		{
			return false;
		}

		$dirOB = dir($path);
		$files = array();
		while(($file = $dirOB->read()) !== false) 
		{
			if($file!='.' && $file!='..')
			{
				$files[] = $file;
			}
		}
		return $files;
	}
	
	public function make_dir($directory)
	{
		if (!is_dir($directory))
		{
			umask(0);
			if($directory)
			{
				mkdir($directory, 0777);
			}
		}	
	}
	
	public function upload_file($file, $destination_dir, $new_name = false)
	{
		if(!is_array($_FILES) || !is_array($_FILES[$file]))
		{
			return false;
		}

		if(!is_dir($destination_dir))
		{
			$this->make_dir($destination_dir);
		}

		//ini_set("memory_limit", "64M");
		set_time_limit(0);
		
		$file = $_FILES[$file];
		$extension = self::get_extension($file['name']);

		if(!in_array($extension, $this->allowed_extensions))
		{
			return false;
		}
		
		if($new_name!==false)
		{
			if($new_name=='')
			{
				$new_file_name = time().'.'.$extension;
			}
			else
			{
				$new_file_name = $new_name.'.'.$extension;
			}
		}
		else
		{
			$new_file_name = basename($file['name']);
		}
		
		//if(move_uploaded_file($file['tmp_name'], $destination_dir.$new_file_name)) return $new_file_name; else return false;
		if(rename($file['tmp_name'], $destination_dir.$new_file_name))
		{
			chmod($destination_dir.$new_file_name, 0755);
			return $new_file_name;
		}
		else
		{
			return false;
		}
	}
	
	public function upload_photo($file, $destination_dir, $new_name = false, $remove_original = true, &$error_code = false)
	{
		$extension = self::get_extension($_FILES[$file]['name']);

		if(in_array($extension, array('jpg','jpeg','gif','png')))
		{
			$photo_name = $this->upload_file($file, $destination_dir, $new_name);

			if(is_array($this->photo_thumbs))
			{
				foreach(array_keys($this->photo_thumbs) as $type)
				{
					$this->process_image($destination_dir, $photo_name, $type);
				}
			}

			if($remove_original)
			{
				unlink($destination_dir.$photo_name);
			}
			
			return $photo_name;			
		}
		else
		{
			return $this->upload_file($file, $destination_dir, $new_name);
		}
	}
	
	public function process_image($destination_dir, $photo_name, $type)
	{
		$photo_path = $destination_dir.$photo_name;
		$new_photo_path = $destination_dir.$type.'/';

		if(!is_dir($new_photo_path))
		{
			$this->make_dir($new_photo_path.'/');
		}

		$new_photo_path = $destination_dir.$type.'/'.$photo_name;
		
		$image_size = getimagesize($photo_path);

		if($image_size[0] > $this->photo_thumbs[$type][0]) //verificarea latimii
		{
			$w1 = $this->photo_thumbs[$type][0];
			$h1 = ($image_size[1]*$w1) / $image_size[0];
		}
		else
		{
			$w1 = $image_size[0];
			$h1 = $image_size[1];
		}
		
		if($h1 > $this->photo_thumbs[$type][1]) //verificarea inaltimii
		{
			$h = $this->photo_thumbs[$type][1];
			$w = ($w1*$h) / $h1;
		}
		else
		{
			$h = $h1;
			$w = $w1;
		}
	
		if ($this->use_image_magick)
		{
			exec(sprintf("convert %s -resize %dx%d -quality %d %s", $photo_path, $w, $h, 100, $new_photo_path));
		}
		else
		{
			$dest = imagecreatetruecolor($w, $h);
			imageantialias($dest, TRUE);

			if($image_size['mime'] == 'image/gif')
			{
				$src = imagecreatefromgif($photo_path);
			}
			elseif($image_size['mime'] == 'image/png')
			{
				$src = imagecreatefrompng($photo_path);
			}
			else
			{
				$src = imagecreatefromjpeg($photo_path);
			}

			imagecopyresampled($dest, $src, 0, 0, 0, 0, $w, $h, $image_size[0], $image_size[1]);

			if($image_size[0] > 800 || $image_size[1] > 800)
			{
				$quality = 90;
			}
			else
			{
				$quality = 100;
			}
			imagejpeg($dest, $new_photo_path, $quality);
		}
	}
	
	public function get_extension($file)
	{
		return substr(strtolower(strrchr($file,".")),1);
	}	

	public function generate_crop($thumb_w, $thumb_h, $path, $save_to = false)
	{
		$org = imagecreatefromjpeg($path);

		if($org)
		{
			list($org_w, $org_h) = getimagesize($path);

			if($org_w < $org_h)
			{
				$cut_h = $org_w*$thumb_h/$thumb_w;

				$cut_x = 0;
				$cut_y = ($org_h-$cut_h)/2;
				$cut_w = $org_w;

				$dst_x = 0;
				$dst_y = 0;
				$dst_w = $thumb_w;
				$dst_h = $thumb_h;
			}
			else
			{
				$cut_w = $org_h*$thumb_w/$thumb_h;

				$cut_x = ($org_w-$cut_w)/2;
				$cut_y = 0;
				$cut_h = $org_h;

				$dst_x = 0;
				$dst_y = 0;
				$dst_w = $thumb_w;
				$dst_h = $thumb_h;
			}

			$thumb = imagecreatetruecolor($thumb_w, $thumb_h);

			imagecopyresampled($thumb, $org, $dst_x, $dst_y, $cut_x, $cut_y, $dst_w, $dst_h, $cut_w, $cut_h);

			if($save_to)
			{
				$ok = imagejpeg($thumb, $save_to, 100);
			}

			header('Content-Type: image/jpeg');
			imagejpeg($thumb, null, 100);
		}
	}

	public function resize_image_by_width($thumb_w, $path, $save_to = false)
	{
		$org = imagecreatefromjpeg($path);
		if($org)
		{
			list($org_w, $org_h) = getimagesize($path);

			if($org_w > $thumb_w)
			{
				$thumb_h = $thumb_w*$org_h/$org_w;

				$cut_x = 0;
				$cut_y = 0;
				$cut_w = $org_w;
				$cut_h = $org_h;

				$dst_x = 0;
				$dst_y = 0;
				$dst_w = $thumb_w;
				$dst_h = $thumb_h;
			}

			$thumb = imagecreatetruecolor($thumb_w, $thumb_h);

			imagecopyresampled($thumb, $org, $dst_x, $dst_y, $cut_x, $cut_y, $dst_w, $dst_h, $cut_w, $cut_h);

			if($save_to)
			{
				$ok = imagejpeg($thumb, $save_to, 100);
			}

			header('Content-Type: image/jpeg');
			imagejpeg($thumb, null, 100);
		}
	}

}

?>