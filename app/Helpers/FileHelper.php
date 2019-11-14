<?php
namespace App\Helpers;
use Request;
class FileHelper
{
    public static function uploadFile($file, $prefix, $base_path = 'uploads') {
        $current_unixtime = time();
        $file_ext_array = explode('.', $file->getClientOriginalName());
        $file_ext = end($file_ext_array);
        $file_name = $prefix . '_' . $current_unixtime . '.' . $file_ext;
        $file->move($base_path, $file_name);
        $file_url = $base_path . '/' . $file_name;
        return $file_url;
    }

    public static function removeFileWithPrefix($base_path, $prefix){
        $mask = $base_path . $prefix . '*';
        array_map('unlink', glob($mask));
    }

    public static function removeFile($file_path){
        if(!empty($file_path)){
            unlink($file_path);
        }
    }
}
