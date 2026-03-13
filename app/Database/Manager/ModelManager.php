<?php

namespace App\Database\Manager;

class ModelManager
{
    protected static $tableName;
    protected static $className;

    private function __construct($model)
    {
        $model = preg_replace('/_?Model$/', '', $model);

        $snake = strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model));

        self::$className = $snake;
        $finalName =  $snake . 's';
        self::$tableName = $finalName;
    }
    public static function CreateModel($name)
    {
        $folder = BASE_PATH . "/app/Models/";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        new ModelManager($name);
        $className = str_replace(' ', '', ucwords(self::$className));

        $fileName = "{$className}.php";
        $table = '$' . 'table';
        $tableName = self::$tableName;
        $content = <<<PHP
         <?php
            namespace App\Models;
            use App\Database\Db\Db;
            use App\core\Model;
            use App\Database\migrations\UserMigration;

            class {$className} extends Model
            {
                protected static $table = "$tableName";
            }
         PHP;
        file_put_contents($folder . $fileName, $content);

        echo "Model created: {$folder}{$fileName}\n";
    }
}
