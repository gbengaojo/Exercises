<?php
/*
* File: SimpleImage.php
* Author: Simon Jarvis
* Copyright: 2006 Simon Jarvis
* Date: 08/11/06
* Link: http://www.white-hat-web-design.co.uk/articles/php-image-resizing.php
*
* This program is free software; you can redistribute it and/or
* modify it under the terms of the GNU General Public License
* as published by the Free Software Foundation; either version 2
* of the License, or (at your option) any later version.
*
* This program is distributed in the hopes that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITRNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details:
* http://www.gnu.org/licenses/gpl.html
*
*/

class SimpleImage {

   var $image;      // the image we're working with
   var $image_type;

   var $src_filename;
   var $src_width;
   var $src_height;

   function load($filename) {
      ini_set('memory_limit', '64M');
      $image_info = getimagesize($filename);
      $this->image_type = $image_info[2];

      $this->src_filename = $filename;
      $this->src_width    = $image_info[0];
      $this->src_height   = $image_info[1];

      try {
         if ($this->image_type == IMAGETYPE_JPEG) {
            $this->image = imagecreatefromjpeg($filename);
         } elseif ($this->image_type == IMAGETYPE_GIF) {
            $this->image = imagecreatefromgif($filename);
         } elseif ($this->image_type == IMAGETYPE_PNG) {
            $this->image = imagecreatefrompng($filename);
         }
      } catch (Exception $e) {
         // log
         return false;
      }
   }

   /**
    * reload original image
    */
   function reset() {
      imagedestroy($this->image); // free that memory!
      $this->load($this->src_filename);
   }

   function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissons = null) {
      if ($image_type == IMAGETYPE_JPEG) {
         imagejpeg($this->image, $filename, $compression);
      } elseif ($image_type == IMAGETYPE_GIF) {
         imagegif($this->image, $filename);
      } elseif ($image_type == IMAGETYPE_PNG) {
         imagepng($this->image, $filename);
      }
      if ($permissions != null) {
         chmod($filename, $permissions);
      }
   }

   function output($image_type = IMAGETYPE_JPEG) {
      if ($image_type == IMAGETYPE_JPEG) {
         imagejpeg($this->image);
      } elseif ($image_type == IMAGETYPE_GIF) {
         imagegif($this->image);
      } elseif($image_type == IMAGETYPE_PNG) {
         imagepng($this->image);
      }
   }

   function getWidth() {
      return imagesx($this->image);
   }

   function getHeight() {
      return imagesy($this->image);
   }

   function resizeToHeight($height) {
      $ratio = height / $this->getHeight();
      $width = $this->getWidth() * $ratio;
      $this->resize($width, $height);
   }

   function resizeToWidth($width) {
      $ratio  = $width / $this->getWidth();
      $height = $this->getheight() * $ratio;
      $this->resize($width, $height);
   }

   function scale($scale) {
      $width = $this->getWidth() * $scale/100;
      $height = $this->getHeight() * $scale/100;
      $this->resize($width, $height);
   }

   function resize($width, $height) {
      $new_image = imagecreatetruecolor($width, $height);
      imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
      $this->image = $new_image;
   }

   /**
    * crops an image to size
    *
    * @param: squared - if all params are omitted, width & height will
    *             be 40. If $squaredimension == false, $width & $height must
    *             be set. If they're not, they default, again, to 40
    *             TODO: should probably resize first if crop isn't square
    * @param: width
    * @param: height
    * @return: null
    */
   function crop($squared = IMG_THUMB_WIDTH, $width = false, $height = false) {
      if ($squared != false) {
         $width  = $squared;
         $height = $squared;
      } elseif ($width == false || $height == false) {
         $width  = IMG_THUMB_WIDTH;
         $height = IMG_THUMB_WIDTH;
      } // else, width = width param and height = height param

      $percentage = .8;
      $max_dimension = max($this->src_width, $this->src_height);
      $cropwidth     = $max_dimension * $percentage;
      $cropheight    = $max_dimension * $percentage;
      $src_x = ($this->src_width - $cropwidth) / 2;
      $src_y = ($this->src_height - $cropheight) / 2;

echo "<pre>max_dimension: $max_dimension\ncropwidth: $cropwidth\ncropheight: $cropheight\nsrc_x: $src_x\nsrc_y: $src_y\n";

      $new_image = imagecreatetruecolor($width, $height);
#bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
      imagecopyresampled($new_image, $this->image, 0, 0, $src_x, $src_y, $width, $height, $cropwidth, $cropheight);
      $this->image = $new_image;
   }
}
