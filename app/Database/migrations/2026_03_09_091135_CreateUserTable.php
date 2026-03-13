<?php

use App\Database\schema\Schema;
use App\Database\BluePrint;

class CreateUserTable {

    public function up(){
        Schema::create(" users", function(BluePrint $table){
            $table->id();
            $table->string("userName",255,false);
            $table->string("email",100,false);
            $table->string("password",255,false);
            $table->boolean("isAdmin",false,1);
            $table->timestamps();
        });
    }

    public function down(){
        // drop table logic
    }
}