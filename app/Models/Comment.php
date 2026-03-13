<?php
   namespace App\Models;
   use App\Database\Db\Db;
   use App\core\Model;
   use App\Database\migrations\UserMigration;

   class Comment extends Model
   {
       protected static $table = "comments";
   }