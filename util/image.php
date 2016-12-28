<?php
	if(!defined('IN_ZUS')) {
		exit('<h1>403:Forbidden @util:image.php</h1>');
	}
	
	/** class MyImageCrop, by Junxiao Yi on April 08 2014
	 * mode 1 : 强制裁剪，生成图片严格按照需要，不足放大，超过裁剪，图片始终铺满
	 * mode 2 : 和1类似，但不足的时候 不放大 会产生补白，可以用png消除。
	 * mode 3 : 只缩放，不裁剪，保留全部图片信息，会产生补白，
	 * mode 4 : 只缩放，不裁剪，保留全部图片信息，生成图片大小为最终缩放后的图片有效信息的实际大小，不产生补白
	 * 默认补白为白色，如果要使补白成透明像素，可以使用SaveAlpha()方法代替SaveImage()方法
	 */

	// yi for my test only
	// $img = new MyImageCrop('test.jpg','afterCrop.jpg');
	// $img->Crop(350,350,1);
	// $img->SaveImage(); //|| 
	// // $img->SaveAlpha(); //将补白变成透明像素保存, 这个我觉得挺好，如果要改就把上面一行注释这一行拿掉注释, 
	//                       //我认为在照片展示页面用这个比较好, 如果是上传logo的话其实可以让用户自己选择第三个参数
	// $img->destory();

	class MyImageCrop
	{
	    var $sImage;
	    var $dImage;
	    var $src_file;
	    var $dst_file;
	    var $src_width;
	    var $src_height;
	    var $src_ext;
	    var $src_type;

	    public function __construct($src_file, $dst_file = '')
	    {
	        $this->src_file = $src_file;
	        $this->dst_file = $dst_file;
	        $this->LoadImage();
	    }

	    public function LoadImage()
	    {
	        list($this->src_width, $this->src_height, $this->src_type) = getimagesize($this->src_file);
	        switch ($this->src_type)
	        {
	            case IMAGETYPE_JPEG :
	                $this->sImage = imagecreatefromjpeg($this->src_file);
	                $this->ext    = 'jpg';
	                break;
	            case IMAGETYPE_PNG :
	                $this->sImage = imagecreatefrompng($this->src_file);
	                $this->ext    = 'png';
	                break;
	            case IMAGETYPE_GIF :
	                $this->sImage = imagecreatefromgif($this->src_file);
	                $this->ext    = 'gif';
	                break;
	            default:
	                exit();
	        }
	    }

	    public function SaveImage($fileName = '')
	    {
	        $this->dst_file = $fileName ? $fileName : $this->dst_file;
	        switch ($this->src_type)
	        {
	            case IMAGETYPE_JPEG :
	                imagejpeg($this->dImage, $this->dst_file, 100);
	                break;
	            case IMAGETYPE_PNG :
	                imagepng($this->dImage, $this->dst_file);
	                break;
	            case IMAGETYPE_GIF :
	                imagegif($this->dImage, $this->dst_file);
	                break;
	            default:
	                break;
	        }
	    }

	    public function OutImage()
	    {
	        switch ($this->src_type)
	        {
	            case IMAGETYPE_JPEG :
	                header('Content-type: image/jpeg');
	                imagejpeg($this->dImage);
	                break;
	            case IMAGETYPE_PNG :
	                header('Content-type: image/png');
	                imagepng($this->dImage);
	                break;
	            case IMAGETYPE_GIF :
	                header('Content-type: image/gif');
	                imagegif($this->dImage);
	                break;
	            default:
	                break;
	        }
	    }

	    public function SaveAlpha($fileName = '')
	    {
	        // $this->dst_file = $fileName ? $fileName . '.png' : $this->dst_file . '.png';
	        $this->dst_file = $fileName ? $fileName : $this->dst_file;
	        imagesavealpha($this->dImage, true);
	        imagepng($this->dImage, $this->dst_file);
	    }

	    public function OutAlpha()
	    {
	        imagesavealpha($this->dImage, true);
	        header('Content-type: image/png');
	        imagepng($this->dImage);
	    }

	    public function destory()
	    {
	        imagedestroy($this->sImage);
	        imagedestroy($this->dImage);
	    }

	    public function Crop($dst_width, $dst_height, $mode = 1, $dst_file = '')
	    {
	        if ($dst_file)
	        {
	        	$this->dst_file = $dst_file;
	        }
	        $this->dImage = imagecreatetruecolor($dst_width, $dst_height);

	        $bg = imagecolorallocatealpha($this->dImage, 255, 255, 255, 127);
	        imagefill($this->dImage, 0, 0, $bg);
	        imagecolortransparent($this->dImage, $bg);

	        $ratio_w = 1.0 * $dst_width / $this->src_width;
	        $ratio_h = 1.0 * $dst_height / $this->src_height;
	        $ratio   = 1.0;
	        switch ($mode)
	        {
	            case 1:        // always crop
	                if (($ratio_w < 1 && $ratio_h < 1) || ($ratio_w > 1 && $ratio_h > 1))
	                {
	                    $ratio   = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
	                    $tmp_w   = (int) ($dst_width / $ratio);
	                    $tmp_h   = (int) ($dst_height / $ratio);
	                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
	                    $src_x   = (int) (($this->src_width - $tmp_w) / 2);
	                    $src_y   = (int) (($this->src_height - $tmp_h) / 2);
	                    imagecopy($tmp_img, $this->sImage, 0, 0, $src_x, $src_y, $tmp_w, $tmp_h);
	                    // imagecopyresampled($this->dImage, $tmp_img, 0, 0, 0, 0, $dst_width, $dst_height, $tmp_w, $tmp_h);
	                    //可以截出居中图像
	                    imagecopyresampled($this->dImage, $tmp_img, $dst_width*0.05, $dst_width*0.05, 0, 0, $dst_width*0.9, $dst_height*0.9, $tmp_w, $tmp_h);
	                    imagedestroy($tmp_img);
	                }
	                else
	                {
	                    $ratio   = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
	                    $tmp_w   = (int) ($this->src_width * $ratio);
	                    $tmp_h   = (int) ($this->src_height * $ratio);
	                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
	                    imagecopyresampled($tmp_img, $this->sImage, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->src_width, $this->src_height);
	                    $src_x   = (int) ($tmp_w - $dst_width) / 2;
	                    $src_y   = (int) ($tmp_h - $dst_height) / 2;
	                    imagecopy($this->dImage, $tmp_img, 0, 0, $src_x, $src_y, $dst_width, $dst_height);
	                    imagedestroy($tmp_img);
	                }
	                break;
	            case 2:        // only small
	                if ($ratio_w < 1 && $ratio_h < 1)
	                {
	                    $ratio   = $ratio_w < $ratio_h ? $ratio_h : $ratio_w;
	                    $tmp_w   = (int) ($dst_width / $ratio);
	                    $tmp_h   = (int) ($dst_height / $ratio);
	                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
	                    $src_x   = (int) ($this->src_width - $tmp_w) / 2;
	                    $src_y   = (int) ($this->src_height - $tmp_h) / 2;
	                    imagecopy($tmp_img, $this->sImage, 0, 0, $src_x, $src_y, $tmp_w, $tmp_h);
	                    imagecopyresampled($this->dImage, $tmp_img, 0, 0, 0, 0, $dst_width, $dst_height, $tmp_w, $tmp_h);
	                    imagedestroy($tmp_img);
	                }
	                else if ($ratio_w > 1 && $ratio_h > 1)
	                {
	                    $dst_x = (int) abs($dst_width - $this->src_width) / 2;
	                    $dst_y = (int) abs($dst_height - $this->src_height) / 2;
	                    imagecopy($this->dImage, $this->sImage, $dst_x, $dst_y, 0, 0, $this->src_width, $this->src_height);
	                }
	                else
	                {
	                    $src_x = 0;
	                    $dst_x = 0;
	                    $src_y = 0;
	                    $dst_y = 0;
	                    if (($dst_width - $this->src_width) < 0)
	                    {
	                        $src_x = (int) ($this->src_width - $dst_width) / 2;
	                        $dst_x = 0;
	                    }
	                    else
	                    {
	                        $src_x = 0;
	                        $dst_x = (int) ($dst_width - $this->src_width) / 2;
	                    }

	                    if (($dst_height - $this->src_height) < 0)
	                    {
	                        $src_y = (int) ($this->src_height - $dst_height) / 2;
	                        $dst_y = 0;
	                    }
	                    else
	                    {
	                        $src_y = 0;
	                        $dst_y = (int) ($dst_height - $this->src_height) / 2;
	                    }
	                    imagecopy($this->dImage, $this->sImage, $dst_x, $dst_y, $src_x, $src_y, $this->src_width, $this->src_height);
	                }
	                break;
	            case 3:        // keep all image size and create need size
	                if ($ratio_w > 1 && $ratio_h > 1)
	                {
	                    $dst_x = (int) (abs($dst_width - $this->src_width) / 2);
	                    $dst_y = (int) (abs($dst_height - $this->src_height) / 2);
	                    imagecopy($this->dImage, $this->sImage, $dst_x, $dst_y, 0, 0, $this->src_width, $this->src_height);
	                }
	                else
	                {
	                    $ratio   = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
	                    $tmp_w   = (int) ($this->src_width * $ratio);
	                    $tmp_h   = (int) ($this->src_height * $ratio);
	                    $tmp_img = imagecreatetruecolor($tmp_w, $tmp_h);
	                    imagecopyresampled($tmp_img, $this->sImage, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->src_width, $this->src_height);
	                    $dst_x   = (int) (abs($tmp_w - $dst_width) / 2);
	                    $dst_y   = (int) (abs($tmp_h - $dst_height) / 2);
	                    imagecopy($this->dImage, $tmp_img, $dst_x, $dst_y, 0, 0, $tmp_w, $tmp_h);
	                    imagedestroy($tmp_img);
	                }
	                break;
	            case 4:        // keep all image but create actually size
	                if ($ratio_w > 1 && $ratio_h > 1)
	                {
	                    $this->dImage = imagecreatetruecolor($this->src_width, $this->src_height);
	                    imagecopy($this->dImage, $this->sImage, 0, 0, 0, 0, $this->src_width, $this->src_height);
	                }
	                else
	                {
	                    $ratio        = $ratio_w > $ratio_h ? $ratio_h : $ratio_w;
	                    $tmp_w        = (int) ($this->src_width * $ratio);
	                    $tmp_h        = (int) ($this->src_height * $ratio);
	                    $this->dImage = imagecreatetruecolor($tmp_w, $tmp_h);
	                    imagecopyresampled($this->dImage, $this->sImage, 0, 0, 0, 0, $tmp_w, $tmp_h, $this->src_width, $this->src_height);
	                }
	                break;
	        }
	    }
	}

	class ImageDAO 
	{
		// generate a preview image
		public static function generate_preview_image($home, $src) {
			$file = 'upload/temp';
			if (!file_exists($home.$file)) {
				mkdir($home.$file, 0777, true);
			}
			$file .= '/'. round(microtime(true)) . '.jpg';
			$img = imagecreatefromstring(file_get_contents($src));
			if ($img === false) {
				return '';
			}
			imagejpeg($img, $home.$file);
			return $file;
		}
		
		// clip, save image then return file address
		public static function clip_save_image($home, $pid, $src, $x, $y, $r, $t = 350, $scale = 100, $need_full = false) {
			$img = imagecreatefromstring(file_get_contents($home.$src));
			if ($img === false) {
				return '';
			}
			$file = 'upload/'.$pid;
			if (!file_exists($home.$file)) {
				mkdir($home.$file, 0777, true);
			}
			$file .= '/'. round(microtime(true));
			
			if ($need_full) {
			  imagejpeg($img, $home.$file.'_full.jpg');
			}

			if ( ($x == 0) && ($y == 0) && ($scale == 100) )
			{
				$img = new MyImageCrop($home.$src, $home.$file.'_large.jpg');
				$img->Crop(350,350, 3);
				// $img->SaveImage();
				$img->SaveAlpha(); //将补白变成透明像素保存
				$img->destory();

				$img = new MyImageCrop($home.$src, $home.$file.'_small.jpg');
				$img->Crop(50,50, 1);
				// $img->SaveImage();
				$img->SaveAlpha(); //将补白变成透明像素保存
				$img->destory();
			}
			else
			{
				$s = 350;
				$dest = imagecreatetruecolor($s, $s);
				$bg = imagecolorallocate($dest, 255, 255, 255);
				imagefill($dest,0,0,$bg);
				imagecopyresampled($dest, $img, 0, 0, $x, $y, $s, $s, $r, $r);
				imagejpeg($dest, $home.$file.'_large.jpg');

				$s = 50;
				$dest = imagecreatetruecolor($s, $s);
				$bg = imagecolorallocate($dest, 255, 255, 255);
				imagefill($dest,0,0,$bg);
				imagecopyresampled($dest, $img, 0, 0, $x, $y, $s, $s, $r, $r);
				imagejpeg($dest, $home.$file.'_small.jpg');
			}

			return $file;
		}
		
		// save full image then return file address
		public static function save_full_image($home, $pid, $src) {
			$img = imagecreatefromstring(file_get_contents($home.$src));
			if ($img === false) {
				return '';
			}
			$file = 'upload/'.$pid;
			if (!file_exists($home.$file)) {
				mkdir($home.$file, 0777, true);
			}
			$file .= '/'. round(microtime(true));
			
			imagejpeg($img, $home.$file.'_full.jpg');
		}
	}

	class logoCrop
	{
		public static function getHeight($image)
		{
			$sizes = getimagesize($image);
			$height = $sizes[1];
			return $height;
		}
		//You do not need to alter these functions
		public static function getWidth($image)
		{
			$sizes = getimagesize($image);
			$width = $sizes[0];
			return $width;
		}

		public static function resizeImage($image,$width,$height,$scale)
		{
			list($imagewidth, $imageheight, $imageType) = getimagesize($image);
			$imageType = image_type_to_mime_type($imageType);
			$newImageWidth = ceil($width * $scale);
			$newImageHeight = ceil($height * $scale);
			$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
			switch($imageType)
			{
				case "image/gif":
					$source=imagecreatefromgif($image); 
					break;
			    case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					$source=imagecreatefromjpeg($image); 
					break;
			    case "image/png":
				case "image/x-png":
					$source=imagecreatefrompng($image); 
					break;
		  	}
			imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
			
			switch($imageType)
			{
				case "image/gif":
			  		imagegif($newImage,$image); 
					break;
		      	case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
			  		imagejpeg($newImage,$image,90); 
					break;
				case "image/png":
				case "image/x-png":
					imagepng($newImage,$image);  
					break;
		    }
			
			// chmod($image, 0777);
			return $image;
		}

		public static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale)
		{
			list($imagewidth, $imageheight, $imageType) = getimagesize($image);
			$imageType = image_type_to_mime_type($imageType);
			
			$newImageWidth = ceil($width * $scale);
			$newImageHeight = ceil($height * $scale);
			$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
			switch($imageType)
			{
				case "image/gif":
					$source=imagecreatefromgif($image); 
					break;
			    case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
					$source=imagecreatefromjpeg($image); 
					break;
			    case "image/png":
				case "image/x-png":
					$source=imagecreatefrompng($image); 
					break;
		  	}
			imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
			switch($imageType)
			{
				case "image/gif":
			  		imagegif($newImage,$thumb_image_name); 
					break;
		      	case "image/pjpeg":
				case "image/jpeg":
				case "image/jpg":
			  		imagejpeg($newImage,$thumb_image_name,90); 
					break;
				case "image/png":
				case "image/x-png":
					imagepng($newImage,$thumb_image_name);  
					break;
		    }
			// chmod($thumb_image_name, 0777);
			return $thumb_image_name;
		}

		public static function resizeThumbnailImage_new($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale, $mode)
		{
			if ( $mode == 'square' )
			{
				$img = new MyImageCrop($image, $thumb_image_name);
				$img->Crop(50,50, 1);
				// $img->SaveImage();
				$img->SaveAlpha(); //将补白变成透明像素保存
				$img->destory();
			}
			else
			{
				list($imagewidth, $imageheight, $imageType) = getimagesize($image);
				$imageType = image_type_to_mime_type($imageType);
				
				$newImageWidth = ceil($width * $scale);
				$newImageHeight = ceil($height * $scale);
				$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
				switch($imageType)
				{
					case "image/gif":
						$source=imagecreatefromgif($image); 
						break;
				    case "image/pjpeg":
					case "image/jpeg":
					case "image/jpg":
						$source=imagecreatefromjpeg($image); 
						break;
				    case "image/png":
					case "image/x-png":
						$source=imagecreatefrompng($image); 
						break;
			  	}
				imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$newImageWidth,$newImageHeight,$width,$height);
				switch($imageType)
				{
					case "image/gif":
				  		imagegif($newImage,$thumb_image_name); 
						break;
			      	case "image/pjpeg":
					case "image/jpeg":
					case "image/jpg":
				  		imagejpeg($newImage,$thumb_image_name,90); 
						break;
					case "image/png":
					case "image/x-png":
						imagepng($newImage,$thumb_image_name);  
						break;
			    }
			}
			// chmod($thumb_image_name, 0777);
			return $thumb_image_name;
		}
	}
	
?>
