<?php

namespace App\Database;

class BluePrint
{
    protected $columns = [];

    public function id()
    {
        $this->columns[] = "id INT AUTO_INCREMENT PRIMARY KEY";
    }

    public function string($name, $length = 255, $nullable = true)
    {
        $null = $nullable ? "NULL" : "NOT NULL";
        $this->columns[] = "$name VARCHAR($length) $null";
    }

    public function boolean($name, $nullable = true, $default = null)
    {
        $null = $nullable ? "NULL" : "NOT NULL";
        $defaultSql = is_null($default) ? "" : "DEFAULT " . ($default ? 1 : 0);
        $this->columns[] = "$name TINYINT(1) $null $defaultSql";
    }

    public function number($name, $nullable = true, $default = null)
    {
        $null = $nullable ? "NULL" : "NOT NULL";
        $defaultSql = is_null($default) ? "" : "DEFAULT $default";
        $this->columns[] = "$name INT $null $defaultSql";
    }
    public function timestamps()
    {
        $this->columns[] = "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->columns[] = "updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
    }
    public function getColumns()
    {
        return $this->columns;
    }
}
