<?php

namespace App\Database\Manager;

use App\Database\Database;

class MigrationManager
{
    private static $migrationName;

    public function __construct($name)
    {
        $migName = '';
        $name = strtolower(preg_replace('/[_\s]+/', '', trim($name)));
        $lastTwoString = (str_replace("create", '', $name));
        $middleString = (str_replace("table", '', $lastTwoString));
        $lastString = (str_replace($middleString, '', $lastTwoString));
        $first_string = (str_replace($lastTwoString, "", $name));
        $migName .= ucwords($first_string) . ucwords($middleString) . ucwords($lastString);
        self::$migrationName = $migName;
    }

    public static function CreateMigration($name)
    {
        $time = date('Y_m_d_His');
        $folder = BASE_PATH . "/app/Database/migrations/";
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }
        new MigrationManager($name);
        $className = self::$migrationName;
        $fileName = "{$time}_{$className}.php";
        $tableName = strtolower(str_replace("table", 's', ucwords(str_replace("create", '', $name))));
        $content = <<<PHP
        <?php

        use App\Database\schema\Schema;
        use App\Database\BluePrint;

        class {$className} {

            public function up(){
                Schema::create("{$tableName}", function(BluePrint \$table){
                    // define columns here
                });
            }

            public function down(){
                // drop table logic
            }
        }
        PHP;
        file_put_contents($folder . $fileName, $content);

        echo "Migration created: {$folder}{$fileName}\n";
    }

    public static function runMigrations()
    {
        $folder = BASE_PATH . "/app/Database/migrations/";

        if (!is_dir($folder)) {
            echo "No migrations folder found.\n";
            return;
        }

        $files = glob($folder . '*.php');
        if (!$files) {
            echo "No migration files found.\n";
            return;
        }

        $conn = Database::getInstance()->getConnection();
        $conn->exec("CREATE TABLE IF NOT EXISTS migrations (id INT AUTO_INCREMENT PRIMARY KEY, migration VARCHAR(255), batch INT, migrated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

        $stmt = $conn->query("SELECT migration FROM migrations");
        $ran = $stmt->fetchAll(\PDO::FETCH_COLUMN);

        $batch = (int) $conn->query("SELECT MAX(batch) FROM migrations")->fetchColumn() + 1;

        $files = glob($folder . '*.php');
        sort($files);

        foreach ($files as $file) {

            require_once $file;

            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $className = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $fileName);

            if (in_array($fileName, $ran)) {
                continue;
            }
            $migration = new $className();
            $migration->up();

            $stmt = $conn->prepare("INSERT INTO migrations (migration, batch) VALUES (?, ?)");
            $stmt->execute([$fileName, $batch]);

            echo "Migrated: $className\n";
        }
        echo "All migrations executed successfully.\n";
    }
}
