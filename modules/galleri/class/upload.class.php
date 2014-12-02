<?php
/**
*
* @ Copyright: Copyright (C) Farsus Design. All rights reserved. 
* @ Package: ScarPoX / shortterm SPX
* @ Subpackage: RUNCMS 
* @ License: http://www.gnu.org/copyleft/gpl.html GNU/GPL
*
*/
if (!defined("RCX_UPLOADCLASS_INCLUDED")) {
  define("RCX_UPLOADCLASS_INCLUDED", 1);

/**
THIS CLASS IS DEPRACTED & WILL BE REMOVED IN NEXT VERSION! ...use fileupload.php
*/

if (!defined('UPLOAD_MAX_FILE_SIZE')) {
   define('UPLOAD_MAX_FILE_SIZE', 1048576);
}
if (!defined('UPLOAD_IMAGE_MAX_WIDTH')) {
    define('UPLOAD_IMAGE_MAX_WIDTH', 300);
}
if (!defined('UPLOAD_IMAGE_MAX_HEIGHT')) {
    define('UPLOAD_IMAGE_MAX_HEIGHT', 300);
}
if (!defined('UPLOAD_FIELD_NAME')) {
    define('UPLOAD_FIELD_NAME', "uploadFile");
}

if (!defined('UPLOAD_DEBUG_OUTPUT')) {
    define('UPLOAD_DEBUG_OUTPUT', false);
}
if (!defined('UPLOAD_ENV_OUTPUT')) {
    define('UPLOAD_ENV_OUTPUT', false);
}
if (!defined('UPLOAD_LINE_BREAK')) {
    define('UPLOAD_LINE_BREAK',"<br />");
}

class Upload {

  // array
  var $uploadErrors;
  var $registeredMimeTypes;
  var $allowedMimeTypes;

  // int
  var $maxImageWidth;
  var $maxImageHeight;
  var $maxFileSize;

  // name of uploaded file names array
  var $uploadFileNamesArrName;

  /*
  * used to track the number of fields created and name them accordingly
  */
  var $fieldCounter;

  // string
  var $uploadPath;
  var $uploadFieldName;
  var $fieldName;
  var $errorType;

// ALT tag
  var $alt;
  var $destinationFileName;

  // bool
  var $imageSizeOk;
  var $uploadValidated;
  var $uploadFail;

  function Upload()
  {
    $this->uploadErrors     = array();
    $this->registeredMimeTypes  = array();
    $this->allowedMimeTypes   = array();

    $this->maxImageWidth    = 0;
    $this->maxImageHeight   = 0;
    $this->maxFileSize      = 0;
    $this->fieldCounter     = 0;

    $this->uploadFieldName    = "";
// ALT tag
    $this->alt            = "";
    $this->uploadPath     = "";

    $this->imageSizeOk      = false;
    $this->uploadValidated    = false;
    $this->uploadFail     = false;

    if(!$this->registeredMimeTypes) {
      $this->setRegisteredMimeTypes();
    }

    if(!$this->maxImageWidth || !$this->maxImageHeight) {
      $this->setMaxImageSize();
    }

    if(!$this->maxFileSize) {
      $this->setMaxFileSize();
    }

    $this->checkLocalEnv();
  }

  function setMaxImageSize($maxImageWidth = UPLOAD_IMAGE_MAX_WIDTH, $maxImageHeight = UPLOAD_IMAGE_MAX_HEIGHT)
  {
    $this->maxImageWidth  = $maxImageWidth;
    $this->maxImageHeight   = $maxImageHeight;
  }

  function setUploadPath($uploadPath)
  {
    $this->uploadPath   = $uploadPath;
  }

  function setDestinationFileName($destinationFileName = "uploadedFile.file")
  {
    $this->destinationFileName = $destinationFileName;
  }

  function setRegisteredMimeTypes($registeredMimeTypes = array())
  {
    if (count($registeredMimeTypes) == 0) {
      $this->registeredMimeTypes =
        array(
          "application/x-gzip-compressed"   => ".tar.gz, .tgz",
          "application/x-zip-compressed"    => ".zip",
          "application/x-tar"         => ".tar",
          "text/plain"            => ".php, .txt, .inc (etc)",
          "text/html"             => ".html, .htm (etc)",
          "image/bmp"             => ".bmp, .ico",
          "image/gif"             => ".gif",
          "image/pjpeg"           => ".jpg, .jpeg",
          "image/jpeg"            => ".jpg, .jpeg",
          "image/x-png"           => ".png",
          "audio/mpeg"            => ".mp3 etc",
          "audio/wav"             => ".wav",
          "application/pdf"         => ".pdf",
          "application/x-shockwave-flash"   => ".swf",
          "application/msword"        => ".doc",
          "application/vnd.ms-excel"      => ".xls",
          "application/octet-stream"      => ".exe, .fla, .psd (etc)"
        );
    } else {
      $this->registeredMimeTypes = $registeredMimeTypes;
    }
  }

  function setAllowedMimeTypes($allowedMimeTypes = array())
  {
    $this->allowedMimeTypes = $allowedMimeTypes;
  }

  function setMaxFileSize($maxFileSize = UPLOAD_MAX_FILE_SIZE)
  {
    $this->maxFileSize = $maxFileSize;
  }

  function getUploadErrors()
  {
    return $this->uploadErrors;
  }

  function printFormStart($formAction = "./", $formMethod = "POST", $formName = "uploadForm", $formTarget = "_self", $formInlineJavaScript="")
  {
    print "<FORM ACTION='"  . $formAction .
        "' METHOD='"  . $formMethod .
        "' TARGET='"  . $formTarget .
        "' NAME='"    . $formName .
        "' ENCTYPE='multipart/form-data'" . $formInlineJavaScript . ">\n";
  }

  function printFormField($fieldName = "")
  {
    if(!$fieldName) {
      $fieldName = UPLOAD_FIELD_NAME . "_" . $this->fieldCounter;
    }
    print "<INPUT TYPE='FILE' class='file' NAME='" . $fieldName . "'>\n";
    print "<INPUT TYPE='HIDDEN' NAME='uploadFileName[" .
        $this->fieldCounter . "]' VALUE='" . $fieldName . "'>\n";
    $this->fieldCounter++;
  }

  function printFormSubmit($name="submit", $value="Upload", $formInlineJavaScript="")
  {
    print "<INPUT TYPE='HIDDEN' NAME='fieldCounter' VALUE='" .
        $this->fieldCounter . "'>\n";
    print "<INPUT TYPE='SUBMIT'
         class='button' NAME='" . $name . "' VALUE='" . $value . "'" . $formInlineJavaScript . ">\n";
  }

  function printFormEnd()
  {
    print "</FORM>\n";
  }

  function checkLocalEnv()
  {
    if (UPLOAD_ENV_OUTPUT) {
      print UPLOAD_LINE_BREAK . "::PHP Environment - php.ini settings::" . UPLOAD_LINE_BREAK;

      print UPLOAD_LINE_BREAK . "(php.ini variable: file_uploads)" . UPLOAD_LINE_BREAK;
      print "HTTP File Uploads are ";
      if (ini_get("file_uploads")) {
        print "[ On ]";
      } else {
        print "[ Off ] - This is a *major* issue. This script WILL NOT WORK!";
        print UPLOAD_LINE_BREAK . "Please check php.ini if you have access to it, if not you cannot use this Script, sorry.";
      }
      print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: upload_tmp_dir)";
      print UPLOAD_LINE_BREAK . "Temp Upload Directory is set to [ " . ini_get("upload_tmp_dir") . " ]";
      print UPLOAD_LINE_BREAK . "Note, this is a fully qualified path on the *server*";

      print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: upload_max_filesize)";
      print UPLOAD_LINE_BREAK . "Maximum allowed file size is set to [ " . ini_get("upload_max_filesize") . " ]";

      print UPLOAD_LINE_BREAK . UPLOAD_LINE_BREAK . "(php.ini variable: safe_mode)" . UPLOAD_LINE_BREAK;
      print "Safe mode is ";
      if (!ini_get("safe_mode")) {
        print "[ Off ]";
      } else {
        print "[ On ] - This script will almost certainly not work!";
        print UPLOAD_LINE_BREAK . "Please check php.ini if you have access to it, if not you cannot use this Script, sorry.";
      }
    }
  }

  function setError($errorType)
  {
    $this->uploadErrors[$this->HTTP_POST_FILES[$this->uploadFieldName]['name']][] = $errorType; //+++
  }

  function getAllowedMimeTypes()
  {
    return $this->allowedMimeTypes;
  }

  function getUploadImageSize()
  {
    $dimensions = GetImageSize($this->uploadFile);

    if (UPLOAD_DEBUG_OUTPUT) {
      print "WIDTH: " . $dimensions[0] . UPLOAD_LINE_BREAK . "HEIGHT: " .
          $dimensions[1] . UPLOAD_LINE_BREAK;
    }

    if (!UPLOAD_ALLOW_DUBIOUS_IMAGES) {
      $this->setError("cannotGetImageSize");
    }
    return array($dimensions[0],$dimensions[1]);
  }

  function checkMimeType()
  {
    if (!in_array($this->HTTP_POST_FILES[$this->uploadFieldName]['type'],$this->getAllowedMimeTypes())) {
      $this->setError("mimeException");
      return false;
    } else {
      return true;
    }
  }

  function checkImageSize()
  {
    $this->imageSize = $this->getUploadImageSize($this->uploadFile); //+++

    $imageSizeOK = true;

    if ($this->imageSize[0] > $this->maxImageWidth) {
      $imageSizeOK = false;
      $this->setError("imageWidthException");
    }

    if ($this->imageSize[1] > $this->maxImageHeight) {
      $imageSizeOK= false;
      $this->setError("imageHeightException");
    }
    return $imageSizeOK;
  }

  function copyFile()
  {
    $ext = preg_replace("/^.+\.([^.]+)$/sU", "\\1", $this->HTTP_POST_FILES[$this->uploadFieldName]['name']);
    $func = function_exists(move_uploaded_file) ? move_uploaded_file : copy;
    return $func($this->uploadFile, $this->uploadPath . "/" . $this->destinationFileName.".".strtolower($ext));
  }

  function checkMaxFileSize()
  {
    if ($this->HTTP_POST_FILES[$this->uploadFieldName]['size'] > $this->maxFileSize) {    //+++ ISSUE
      return false;
    } else {
      return true;
    }
  }

  function setDefaults()
  {
    if(!$this->registeredMimeTypes) {
      $this->setRegisteredMimeTypes();
    }

    if(!$this->maxImageWidth || !$this->maxImageHeight) {
      $this->setMaxImageSize();
    }

    if(!$this->maxFileSize) {
      $this->setMaxFileSize();
    }
  }

  function processUpload() {
    if (UPLOAD_DEBUG_OUTPUT) {
      print UPLOAD_LINE_BREAK . "::DEBUG::" . UPLOAD_LINE_BREAK  .
        "Field Name: " . $this->uploadFieldName .
        UPLOAD_LINE_BREAK .
        "Mime Type: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['type'] .
        UPLOAD_LINE_BREAK .
        "File Name: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['name'] .
        UPLOAD_LINE_BREAK .
        "File Size: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['size'] .
        UPLOAD_LINE_BREAK .
        "Temp Name: " . $this->HTTP_POST_FILES[$this->uploadFieldName]['tmp_name'] .
        UPLOAD_LINE_BREAK;
    }

    $this->uploadFile = $this->HTTP_POST_FILES[$this->uploadFieldName]['tmp_name'];
    $this->setDefaults();

    if (!$this->uploadPath) {
      $this->setError("noUploadPathException");
      $this->uploadFail = true;
    }

    if (!$this->allowedMimeTypes) {
      $this->setError("noAllowedTypesException");
      $this->uploadFail = true;
    }

    if ($this->uploadFile == "none") {
      $this->setError("noFileException");
      $this->uploadFail = true;
    }

    if (!$this->checkMaxFileSize()) {
      $this->setError("fileTooBigException");
      $this->uploadFail = true;
    } elseif(in_array("cannotGetImageSize",$this->getUploadErrors())) {
      $this->uploadFail = true;
    }

    if (!$this->uploadFail) {
      if (ereg("image", $this->HTTP_POST_FILES[$this->uploadFieldName]['type'])) {
        $this->imageSizeOk = $this->checkImageSize();
      } else {
        $this->imageSizeOk = true;
      }
    }

    if($this->checkMimeType() && $this->imageSizeOk && !$this->uploadFail) {
      if (!$this->copyFile()) {
        $this->setError("fileCopyException");
      }
    }

    if (count($this->uploadErrors) == 0)
    {
      $this->uploadValidated = true;
    }
    return $this->uploadValidated;
  }

  function doUpload() {
  global $_POST, $_FILES;

    $this->HTTP_POST_FILES = $_FILES;
    $filenames_arr = $_POST[$this->uploadFileNamesArrName];
    $count = count($filenames_arr);
    for ($i = 0; $i < $count; $i++) {

      $this->uploadFieldName  = $filenames_arr[$i];
      $currentUpload = $this->processUpload();

      if (!$currentUpload) {
        $errorsOccured = true;
      }
    }

    if ( !empty($errorsOccured) ) {
      return false;
    } else {
      return true;
    }
  }

  function setUploadFileNamesArrName($value){
    $this->uploadFileNamesArrName = trim($value);
  }
}

// ------------------------------------------------------------------------- //
}
?>
