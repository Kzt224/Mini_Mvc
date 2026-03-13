<?php

namespace App\Controllers;
error_reporting(E_ALL);
ini_set('display_errors', 1);

class ViewController{

    public function view($name,$data=[]){
        $viewPath = BASE_PATH . '/views/' . $name . ".php";  
        extract($data);  
        require $viewPath;
    }

}