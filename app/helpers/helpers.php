<?php

use App\helpers\Cache;
use App\helpers\Error;
use App\Http\Request;

if (!function_exists('csrf_field')) {
    function csrf_field() {
        $token = Request::generateCsrfToken();
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }
}

function error(){
    static $errors;

    if(!$errors){
        $errors = new Error();
    }
    return $errors;
}

function cache(){
    static $caches;

    if(!$caches){
        $caches = new Cache();
    }
    return $caches;
}