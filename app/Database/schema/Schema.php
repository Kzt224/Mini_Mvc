<?php

namespace App\Database\schema;

use App\Database\BluePrint;
use App\Database\Database;

class Schema
{

      public static function Create($table, callable $callbak)
      {
            try {
                  $bluePrint = new BluePrint();
                  $callbak($bluePrint);
                  $columnSql = implode(", ", $bluePrint->getColumns());
                  if(!$columnSql){
                     echo("Need to add column on{$table} migration...");
                     exit();
                  }
                  $sql = "CREATE TABLE IF NOT EXISTS {$table} ({$columnSql})";
                  $conn = Database::getInstance()->getConnection();
                  $conn->exec($sql);
            } catch (\PDOException $e) {
                  echo($e->getMessage());
            }
      }
}
