<?php

namespace VTURefill\Library;
use VTURefill\Library\Generate;
use VTURefill\Core\Logger;

 /**
  * Uploader Class
  *
  */

class Uploader {

    public static $allowedMime = [
        "image" =>  ["jpeg", "png", "gif", "jpeg"],
        "csv"   =>  ['text/csv', 'application/vnd.ms-excel', 'text/plain'],
        "file"  =>  ['application/msword',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/pdf',
                        'application/zip',
                        'application/vnd.ms-powerpoint']
    ];

    public static $maximumFilesize = 4194304; //4MB in Bytes(binary)


    public function __construct() {}


    public static function process($file, $directory, $type = ""){
        if (!isset($file['error']) || is_array($file['error']) || UPLOAD_ERR_NO_FILE === $file["error"] || UPLOAD_ERR_FORM_SIZE === $file["error"] || UPLOAD_ERR_FORM_SIZE === $file["error"]) {
            return false;
        }

        if($type === "csv"){
            $basename = "grades" . "." . "csv";
            $data = ["basename" => $basename, "extension" => "csv"];
        } else {
            $filename = self::getFileName($file);
            $extension = self::mimeToExtension(self::mime($file));
            if(empty($extension) || $extension === false || $file["size"] > self::$maximumFilesize) return false;
            $hashedFilename = substr(Generate::hash(strtolower($filename.$extension)), 0, 10);
            $basename = $hashedFilename . "." . $extension;
            $path = $directory . DS . $basename;
            $data = ["basename" => $basename, "path" => $path];
        }
        return $data;
    }

    public static function fileExists($path){
       return (file_exists($path) && is_file($path)) ? true : false;
    }

    private static function mime($file){
        if(!file_exists($file["tmp_name"])){
            return false;
        }elseif(!function_exists('finfo_open')) {
            Logger::log("finfo_open FUNCTION DOES NOT EXISTS", $error->getMessage(), __FILE__, __LINE__);
            return false;
        }

        $finfo_open = finfo_open(FILEINFO_MIME_TYPE);
        $finfo_file = finfo_file($finfo_open, $file["tmp_name"]);
        finfo_close($finfo_open);
        list($mime) = explode(';', $finfo_file);
        return $mime;
    }

    private static function mimeToExtension($mime){
        $array = [
            'image/jpeg' => 'jpeg', // for both jpeg & jpg.
            'image/png' => 'png',
            'image/gif' => 'gif',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/pdf' => 'pdf',
            'application/zip' => 'zip',
            'application/vnd.ms-powerpoint' => 'ppt'
        ];
        return isset($array[$mime]) ? $array[$mime]: false;
    }

    private static function getFileName($file){
        $filename = pathinfo($file['name'], PATHINFO_FILENAME);
        $filename = preg_replace("/([^A-Za-z0-9_\-\.]|[\.]{2})/", "", $filename);
        $filename = basename($filename);
        return $filename;
    }

    public static function upload($file, $path, $width, $height) {
        if(!move_uploaded_file($file["tmp_name"], $path)){
            throw new \Exception("Error Uploading file");
        }elseif(!chmod($path, 0644)) {
            throw new \Exception("Upload Permission Error");
        }else {
            $gumlet = new \Gumlet\ImageResize($path);
            $gumlet->resizeToBestFit($width, $height);
            $gumlet->save($path);
        }
    }


}
