<?php
/**
 * upload.php
 *
 * Copyright 2009, Moxiecode Systems AB
 * Released under GPL License.
 *
 * License: http://www.plupload.com/license
 * Contributing: http://www.plupload.com/contributing
 */
mb_internal_encoding("UTF-8");
mb_regex_encoding("UTF-8");

// HTTP headers for no cache etc
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

session_name('soteshop');

session_start();

$token = sha1($_SESSION['backend/soteshop/jQueryTools/plupload'].$_REQUEST['namespace']);

if (!isset($_SESSION['backend/soteshop/jQueryTools/plupload']) || $_REQUEST['token'] != $token)
{
   header('HTTP/1.0 403 Forbidden');
   exit('You are not allowed to access this file.');   
}

$root_dir = realpath(dirname(__FILE__).'/../../');

if (file_exists($root_dir.'/.profile.php'))
{
    include_once($root_dir.'/.profile.php');
}

if (defined('ST_ROOT_DIR'))
{
    define('SF_ROOT_DIR',    $root_dir.ST_ROOT_DIR);
} 
else 
{
    define('SF_ROOT_DIR',    realpath($root_dir.'/..'));
}

include_once(SF_ROOT_DIR.'/plugins/stSearchPlugin/lib/stTextAnalyzer.class.php');

// Settings
$targetDir = SF_ROOT_DIR.'/web/uploads/plupload/'.preg_replace('/[^0-9a-z]+/', '', $_REQUEST['namespace']);

if (!is_dir($targetDir))
{
   mkdir($targetDir, 0775, true);
}

$cleanupTargetDir = rand(1, 100) == 1; // Remove old files
$maxFileAge = 7200; // Temp file age in seconds

// 5 minutes execution time
@set_time_limit(5 * 60);

// Get parameters
$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';

// Clean the fileName for security reasons
$fileName = preg_replace('/[^a-z0-9A-Z\.]+/', '-', stTextAnalyzer::unaccent($fileName));
// $fileName = preg_replace('/[-]+/', '-', $fileName);


// Make sure the fileName is unique but only if chunking is disabled
if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {
    $info = pathinfo($fileName);
    $ext = '.'.$info['extension'];

    $count = 1;
    while (file_exists($targetDir . DIRECTORY_SEPARATOR . $info['filename'] . '-' . $count . $ext))
        $count++;

    $fileName = $info['filename'] . '-' . $count . $ext;
}

$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Remove old temp files    
if ($cleanupTargetDir && is_dir($targetDir.'/..')) {
   $maxAge = time() - $maxFileAge;
   foreach (glob($targetDir.'/../*') as $dir)
   {
      if (filemtime($dir) < $maxAge) 
      {
         foreach (glob($dir.'/*') as $file)
         {
            @unlink($file);
         }

         @rmdir($dir);
      }
   }
} 

// Look for the content type header
if (isset($_SERVER["HTTP_CONTENT_TYPE"]))
    $contentType = $_SERVER["HTTP_CONTENT_TYPE"];

if (isset($_SERVER["CONTENT_TYPE"]))
    $contentType = $_SERVER["CONTENT_TYPE"];

// Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
if (strpos($contentType, "multipart") !== false) {
    if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
        // Open temp file
        $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
        if ($out) {
            // Read binary input stream and append it to temp file
            $in = fopen($_FILES['file']['tmp_name'], "rb");

            if ($in) {
                while ($buff = fread($in, 4096))
                    fwrite($out, $buff);
            } else
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            fclose($in);
            fclose($out);
            @unlink($_FILES['file']['tmp_name']);
        } else
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
    } else
        die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
} else {
    // Open temp file
    $out = fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
    if ($out) {
        // Read binary input stream and append it to temp file
        $in = fopen("php://input", "rb");

        if ($in) {
            while ($buff = fread($in, 4096))
                fwrite($out, $buff);
        } else
            die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');

        fclose($in);
        fclose($out);
    } else
        die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
}

// Check if file has been uploaded
if (!$chunks || $chunk == $chunks - 1) {
    // Strip the temp .part suffix off 
    rename("{$filePath}.part", $filePath);
}


// Return JSON-RPC response
die('{"jsonrpc" : "2.0", "result": {"filename": "'.$fileName.'"}, "id" : "id"}');

?>