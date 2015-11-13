<?php
/*-----------------------------------------------------------
Class: qqUploadFileForm qqUploadFileXhr
Author: http://valums.com/ajax-upload/
Origin Date: June 25, 2012
Modified Date: August 16, 2012

http://valums.com/ajax-upload/

class qqUploadFileXhr
class qqUploadFileForm
.
.
.
------------------------------------------------------------*/

require_once 'SimpleImage.php';

/**
 * Handle file uploads via XMLHttpRequest
 */
class qqUploadedFileXhr {
   /**
    * Save the file to the specified path
    * @return (bool) true on success
    */
   function save($path) {
      $input    = fopen("php://input", "r");
      $temp     = tmpfile();
      $realSize = stream_copy_to_stream($input, $temp);
      fclose($input);

      /* TODO 20120626: see note below concerning getSize() 
      if ($realSize != $this->getSize()) {
         return false;
      } */

      $target = fopen($path, 'w');
      fseek($temp, 0, SEEK_SET);
      stream_copy_to_stream($temp, $target);
      fclose($target);

      return true;
   }

   function getName() {
      return $_GET['qqfile']; // TODO: scrutinize?
   }

   function getSize() {
      if (isset($_SERVER['CONTENT_LENGTH'])) {
         return(int) $_SERVER['CONTENT_LENGTH'];
      } else {
         throw new Exception('Getting content length is not supported.');
      }
   }
}

/**
 * Hanlde file uploads via regular form post (uses the $_FILES array)
 */
class qqUploadedFileForm {
   /**
    * Save the file to the specified path
    * @return: (bool) true on success
    */
   function save($path) {
      if (!move_uploaded_file($_FILES['qqfile']['tmp_name'], $path)) {
         return false;
      }
      return true;
   }

   function getName() {
      return $_FILES['qqfile']['name']; // TODO: scrutinize?
   }
}

class qqFileUploader {
   private $allowedExtensions = array();
   private $sizeLimit = 10485760;
   private $file;

   function __construct(array $allowedExtensions = array(), $sizeLimit = 10485760) {
      $allowedExtensions = array_map("strtolower", $allowedExtensions);

      $this->allowedExtensions = $allowedExtensions;
      $this->sizeLimit = $sizeLimit;

      $this->checkServerSettings();

      if (isset($_GET['qqfile'])) {
         $this->file = new qqUploadedFileXhr();
      } elseif (isset($_FILES['qqfile'])) {
         $this->file = new qqUploadedFileForm();
      } else {
         $this->file = false;
      }
   }

   private function checkServerSettings() {
      $postSize   = $this->toBytes(ini_get('post_max_size'));
      $uplaodSize = $this->toBytes(ini_get('upload_max_filesize'));
      /*
      if ($postSize < $this->sizeLimit || $uploadSize < $this->sizeLimit) {
         $size = max(1, $this->sizeLimit / 1024 / 1024) . 'M';
         die ("{'error':'increase post_max_size and upload_max_filesize to $size'}");
      }*/
   }

   private function toBytes($str) {
      $val  = trim($str);
      $last = strtolower($str[strlen($str) - 1]);
      switch ($last) {
         case 'g': $val *= 1024;
         case 'm': $val *= 1024;
         case 'k': $val *= 1024;
      }
      return $val;
   } 

   /**
    * Returns array('success' => true) or array('error' => 'error message')
    */
   function handleUpload($uploadDirectory, $data = array(), $replaceOldFile = FALSE) {
      if (!is_writable($uploadDirectory)) {
         return array('error' => "Server error. Upload directory isn't writable.");
      }

      if (!$this->file) {
         return array('error' => 'No files were uploaded.');
      }

      /* TODO 20120626: implement qqUploaderFileXhr::getSize() - $_SERVER['CONTENT_LENGTH'] not
               available when variables dumped, so error is being thrown
      $size = $this->file->getSize();

      if ($size == 0) {
         return array('error' => 'File is empty');
      }

      if ($size > $this->sizeLimit) {
         return array('error' => 'File is too large');
      } */

      $pathinfo = pathinfo($this->file->getName());
      // $filename = pathinfo('filename');  // TODO: 20120626: find why $filename = 'Array'
      $ext = $pathinfo['extension'];
      $filename = md5(uniqid()) . '.' . $ext;

      if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions)) {
         $these = implode(', ', $this->allowedExtensions);
         return array('error' => 'File has an invalid extension, it should be one of '. $these . '.');
      }

      if (!$replaceOldFile) {
         // don't overwrite previous files that were uploaded
         while (file_exists($uploadDirectory . $filename)) {
            $filename .= rand(10, 99);
         }
      }

      // save file; create thumbnails and save those too; see application/configs/config.php
      if ($this->file->save($uploadDirectory . $filename)) {    // hash.ext
         $img = new SimpleImage();

         // tiny thumbnail
         $img->load($uploadDirectory . $filename);
         $img->crop();
         $img->save($uploadDirectory . '1.' . $filename);       // 1.hash.ext (40px square);

         // profile
         $img->reset();
         $img->crop(false, IMG_PROFILE_WIDTH, IMG_PROFILE_HEIGHT);
         $img->save($uploadDirectory . '2.' . $filename);       // 2.hash.ext (155x145)

         // full size
         $img->reset();
         $img->resizeToWidth(IMG_FULL_WIDTH);
         $img->save($uploadDirectory . '3.' . $filename);       // 3.hash.ext (600px width);

         // multi-purpose thumnbail
         $img->reset();
         $img->crop(IMG_SQ_THUMB);     
         $img->save($uploadDirectory . '4.' . $filename);        // 4.hash.ext (155X155)

         // album thumbnails
         $img->reset();
         $img->crop(false, IMG_ALBUM_THUMB_WIDTH, IMG_ALBUM_THUMB_HEIGHT);
         $img->save($uploadDirectory . '5.' . $filename);         // 5.hash.ext (150x113)

         return array('success'          => true,
                      'filename'         => $filename,
                      IMG_THUMB_FIELD    => '1.' . $filename,
                      IMG_PROFILE_FIELD  => '2.' . $filename,
                      IMG_FULL_FIELD     => '3.' . $filename,
                      IMG_SQ_THUMB_FIELD => '4.' . $filename);
      } else {

         return array('error' => 'Could not save uploaded file.' .
            'The upload was cancelled, or server error encountered');
      }
   }
}
