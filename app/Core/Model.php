<?php

namespace App\core;

use App\Database\Db\Db;

class Model
{
   protected static $table;

   public static function all($limit = '')
   {
      $data = Db::table(static::$table)->where('deleted',"!=",1)->get();
      return $data;
   }
   public static function get($id)
   {
      $data = DB::table(static::$table)->where("id", "=", $id)->get();
      if ($data) {
         return $data;
      } else {
         http_response_code(404);
         echo "404 user Not Found";
      }
   }
   public static function create($data){
      $query = Db::table(static::$table);
      $data = $query->create($data);
      return $data;
   }
   public static function softDelete($id){
      $query = DB::table(static::$table);
      $query->where('id',"=",$id)->update(['deleted' => 1]);
   }
   public static function update($id,$data){
      $query = DB::table(static::$table);
      $query->where('id',"=",$id)->update($data);
      return $query->where('id','=',$id)->get();
   }
}
