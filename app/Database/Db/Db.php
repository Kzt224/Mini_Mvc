<?php

namespace App\Database\Db;

use App\Database\helper\QueryBuilder;

class Db{
    
    public static function table($table){
        return new QueryBuilder($table);
    }
}