<?php
   namespace App\Models;
   use App\Database\Db\Db;
   use App\core\Model;
   use App\Database\migrations\UserMigration;

   class Post extends Model
   {
       protected static $table = "posts";
   }