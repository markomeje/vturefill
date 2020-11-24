<?php

namespace VTURefill\Core;
use VTURefill\Core\Help;


class Logger{


    private function __construct(){}


    public static function log($subject = "", $message = "", $fileName = "", $lineNumber = ""){
        $error = "*******************************************************************\n";
        $logfile = ROOT . DS . "errors.log";
        $error .= mb_strtoupper($subject)." Logged On ".Help::formatDatetime()."\n";
        $error .= is_array($message) ? implode("\n", $message) : $message."\n";
        $error .= "At File ".$fileName ." On Line ".$lineNumber ."\n";
        $error .= "*******************************************************************\n\n";
        error_log($error, 3, $logfile);
    }

}