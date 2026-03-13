<?php

use App\Database\schema\Schema;
use App\Database\BluePrint;

class CreatePostTable {

    public function up(){
        Schema::create("posts", function(BluePrint $table){
           $table->id();
           $table->string('title',255,false);
           $table->string('body',255,false);
           $table->number("authorId",false,null);
           $table->timestamps();
        });
    }

    public function down(){
        // drop table logic
    }
}