<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LanguageController extends Controller
{
  public function getFileLang($filename) {
    $lang = config('app.locale');
    $src   = resource_path('lang/' . $lang . '/' . $filename . '.php');
    $data = "{}";

    if(file_exists($src)) {
      $data = json_encode(require $src);
    }

    header('Content-Type: text/javascript');
    echo('
      if(!window.trans) {
        window.trans = {};
      }
      window.trans.'. $filename . '=' . $data . ';
    ');

    exit();
  }
}
