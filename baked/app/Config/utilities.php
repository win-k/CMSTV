<?php
function v($val)
{
  var_dump($val);
}

function fmdate($datetime) {
  return date('Y/m/d', strtotime($datetime));
}
function fmdatetime($datetime) {
  return date('Y/m/d H:i', strtotime($datetime));
}

function formatBytes($bytes, $precision = 2) {
  $units = array('B', 'KB', 'MB', 'GB', 'TB');

  $bytes = max($bytes, 0);
  $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
  $pow = min($pow, count($units) - 1);

  // Uncomment one of the following alternatives
  $bytes /= pow(1024, $pow);
  // $bytes /= (1 << (10 * $pow));

  return round($bytes, $precision) . ' ' . $units[$pow];
}

/**
 * Mimeタイプを取得
 *
 * @param  str $filename
 * @return str Mimeタイプ
 */
function mime_content_type2($filename) {
    $ext = strtolower(array_pop(explode('.',$filename)));

    switch($ext)
    {
        case "js" :
            return "application/x-javascript";

        case "json" :
            return "application/json";

        case "jpg" :
        case "jpeg" :
        case "jpe" :
            return "image/jpg";

        case "png" :
        case "gif" :
        case "bmp" :
        case "tiff" :
            return "image/".$ext;

        case "css" :
            return "text/css";

        case "xml" :
            return "application/xml";

        case "doc" :
        case "docx" :
            return "application/msword";

        case "xls" :
        case "xlt" :
        case "xlm" :
        case "xld" :
        case "xla" :
        case "xlc" :
        case "xlw" :
        case "xll" :
            return "application/vnd.ms-excel";

        case "ppt" :
        case "pps" :
            return "application/vnd.ms-powerpoint";

        case "rtf" :
            return "application/rtf";

        case "pdf" :
            return "application/pdf";

        case "html" :
        case "htm" :
        case "php" :
            return "text/html";

        case "txt" :
            return "text/plain";

        case "mpeg" :
        case "mpg" :
        case "mpe" :
            return "video/mpeg";

        case "mp3" :
            return "audio/mpeg3";

        case "wav" :
            return "audio/wav";

        case "wma" :
            return "audio/x-ms-wma";

        case "aiff" :
        case "aif" :
            return "audio/aiff";

        case "avi" :
            return "video/msvideo";

        case "wmv" :
            return "video/x-ms-wmv";

        case "mov" :
            return "video/quicktime";

        case "zip" :
            return "application/zip";

        case "tar" :
            return "application/x-tar";

        case "swf" :
            return "application/x-shockwave-flash";

        /*
        default :
        if(function_exists("mime_content_type"))
        {
            $fileSuffix = mime_content_type($filename);
        }
        */

        return "unknown/" . trim($ext, ".");
    }
}

/**
 * Mimeタイプから拡張子文字を取得
 *
 * @param  str $mimetype Mimeタイプ
 * @return str 拡張子
 */
function extWithMime($mimetype) {
    $mimetype = strtolower($mimetype);

    switch($mimetype)
    {
        case "application/x-javascript" :
            return "js";

        case "application/json" :
            return "json";

        case "image/jpg" :
        case "image/jpeg" :
            return "jpg";

        case "image/png" :
            return "png";

        case "image/gif" :
            return "gif";

        case "image/bmp" :
            return "bmp";

        case "image/tiff" :
            return "tiff";

        case "text/css" :
            return "css";

        case "application/xml" :
            return "xml";

        case "application/msword" :
            return "doc";

        case "application/vnd.ms-excel" :
            return "xls";

        case "application/vnd.ms-powerpoint" :
            return "ppt";

        case "application/rtf" :
            return "rtf";

        case "application/pdf" :
            return "pdf";

        case "text/html" :
            return "html";

        case "text/plain" :
            return "txt";

        case "video/mpeg" :
            return "mpeg";

        case "audio/mpeg3" :
            return "mp3";

        case "audio/wav" :
            return "wav";

        case "audio/x-ms-wma" :
            return "wma";

        case "audio/aiff" :
            return "aif";

        case "video/msvideo" :
            return "avi";

        case "video/x-ms-wmv" :
            return "wmv";

        case "video/quicktime" :
            return "mov";

        case "application/zip" :
            return "zip";

        case "application/x-tar" :
            return "tar";

        case "application/x-shockwave-flash" :
            return "swf";

        return false;
    }
}

/**
 * ファイルポインタから行を取得し、CSVフィールドを処理する
 *
 * @param  File pointer $handle
 * @param  int          $length
 * @param  String       $d
 * @param  Strinh       $e
 * @return Array
 */
function fgetcsv_reg(&$handle, $length = null, $d = ',', $e = '"') {
    $d = preg_quote($d);
    $e = preg_quote($e);
    $_line = "";
    $eof = NULL;

    while ($eof != true)
    {
        $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
        $itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);
        if ($itemcnt % 2 == 0) $eof = true;
    }

    $_csv_line = preg_replace('/(?:\\r\\n|[\\r\\n])?$/', $d, trim($_line));
    $_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';
    preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
    $_csv_data = $_csv_matches[1];

    for ($_csv_i=0; $_csv_i<count($_csv_data); $_csv_i++)
    {
        $_csv_data[$_csv_i] = preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
        $_csv_data[$_csv_i] = str_replace($e.$e, $e, $_csv_data[$_csv_i]);
    }

    return empty($_line) ? false : $_csv_data;
}

function read_csv($file)
{
    if (!file_exists($file)) return FALSE;

    $lines = array();
    $file = file_get_contents($file);
    $file = ereg_replace("\r\n|\r|\n","\n",mb_convert_encoding($file,"UTF-8","SJIS-win"));
    $fp = tmpfile();
    fputs($fp, $file);
    fseek($fp, 0);

    $lines = array();
    while ($o = fgetcsv($fp, 1024)) {
        $lines[] = $o;
    }

    return $lines;
}

/**
 * ランダムな文字列を取得
 */

function getRandomString($nLengthRequired = 8, $onlyNumber = FALSE)
{
  if ($onlyNumber) {
    $sCharList = '0123456789';
  } else {
    $sCharList = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_';
  }

  mt_srand();
  $sRes = '';
  for ($i = 0; $i < $nLengthRequired; $i++) $sRes .= $sCharList[mt_rand(0, strlen($sCharList) - 1)];
  return $sRes;
}

/**
 * ファイル名から拡張子を取得
 */
function extensionByFilename($filename)
{
  $ext = substr($filename, strrpos($filename, '.') + 1);
    return preg_match("/\//", $ext) ? '' : $ext;
}


/**
 * 改行タグをスペースに置換
 */
function brToSpace($str){
    return str_replace(array('<br>', '<br/>', '<br />'), ' ', $str);
}


/**
 * csv出力用に変換
 */
function enc_csv($str){
    return mb_convert_encoding($str, 'SJIS-win', 'UTF-8');
}

function arrayWithKeys($array, $keys)
{
  foreach ($array as $key => $value) {
    if (!in_array($key, $keys)) unset($array[$key]);
  }
  return $array;
}

function deleteDir($dir)
{
  if (!is_dir($dir)) {
    return FALSE;
  } else {
    $filelist = scandir($dir);
    foreach ($filelist as $filename) {
      if ($filename == '.' || $filename == '..') continue;
      $path = $dir.DIRECTORY_SEPARATOR.$filename;
      if (is_dir($path)) {
        deleteDir($path);
      } else {
        unlink($path);
      }
    }
  }
  rmdir($dir);
  return TRUE;
}

function copyRecursively($src, $dest)
{
  $src = rtrim($src, DIRECTORY_SEPARATOR);
  $dest = rtrim($dest, DIRECTORY_SEPARATOR);

  $dir = opendir($src);
  mkdir($dest);
  while (FALSE !== ($file = readdir($dir))) {
    if (($file != '.') && ($file != '..')) {
      if (is_dir($src.DIRECTORY_SEPARATOR.$file)) {
        $r = copyRecursively($src.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
        if (!$r) return FALSE;
      } else {
        $r = copy($src.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file);
        if (!$r) return FALSE;
      }
    }
  }
  closedir($dir);

  return TRUE;
}





