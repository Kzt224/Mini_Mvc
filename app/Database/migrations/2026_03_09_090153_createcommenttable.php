<?php

use App\Database\schema\Schema;
use App\Database\BluePrint;

class Createcommenttable {

    public function up(){
        Schema::create("createcommenttable", function(BluePrint $table){
            // define columns here
        });
    }

    public function down(){
        // drop table logic
    }
}