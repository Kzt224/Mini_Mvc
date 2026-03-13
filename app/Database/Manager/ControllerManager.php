<?php

namespace App\Database\Manager;

class ControllerManager
{
    private static $controllerName;

    public function __construct($name)
    {
        $migName = '';
        $name = strtolower(preg_replace('/[_\s]+/', '', trim($name)));
        $firstString = str_replace("controller", "", $name);
        $lastString = str_replace($firstString, "", $name);
        static::$controllerName = ucwords($firstString) . ucwords($lastString);
    }

    public static function CreateController($name)
    {
        $time = date('Y_m_d_His');
        $folder = BASE_PATH . "/app/Controllers/";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        new ControllerManager($name);
        $className = self::$controllerName;
        $fileName = "{$className}.php";
        $request = '$'."request";
        $param = "$"."param";
        $content = <<<PHP
        <?php

        namespace App\Controllers;
        use App\Http\Request;

        class {$className} extends Controller{
            
            public function index()
            {
                    
            }

            public function showCreate()
            {
                    
            }
            public function store(Request $request)
            {
               
            }
             public function delete(Request $request,array $param)
            {
               
            }
            public function showEdit(Request $request, array $param)
             {
                
             }
            public function update(Request $request, array $param)
             {
                
             }
        }
        PHP;
        file_put_contents($folder . $fileName, $content);

        echo "Controller created: {$folder}{$fileName}\n";
    }
}
