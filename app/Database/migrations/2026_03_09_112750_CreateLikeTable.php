<?php

use App\Database\schema\Schema;
use App\Database\BluePrint;

class CreateLikeTable {

    public function up(){
        Schema::create("likes", function(BluePrint $table){
            // define columns here
        });
    }

    public function down(){
        // drop table logic
    }
}