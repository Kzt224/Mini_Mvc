<?php

use App\Database\schema\Schema;
use App\Database\BluePrint;

class CreateOrderTable {

    public function up(){
        Schema::create("orders", function(BluePrint $table){
            $table->id();
            $table->string("dishes",255,false);
            $table->number("tableNo",false,null);
            $table->string("orderNo",255,false);
            $table->number("total",false,null);
            $table->timestamps();
        });
    }

    public function down(){
        // drop table logic
    }
}