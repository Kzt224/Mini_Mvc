<?php

namespace App\Database\helper;

use App\Database\Database;
use PDO;

class QueryBuilder
{
    private $table = '';
    protected $where = [];
    protected $bindings = [];

    public function __construct($table)
    {
        $this->table = $table;
    }
    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function where($column, $operator, $value)
    {
        $this->where[] = "$column $operator ?";
        $this->bindings[] = $value;
        return $this;
    }

    public function get($limit = null)
    {
        try {
            $sql = "SELECT * FROM {$this->table}";
            if (!empty($this->where)) {
                $sql .= " WHERE " . implode(" AND ", $this->where);
            }
            if ($limit) {
                $sql .= " LIMIT " . intval($limit);
            }
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute($this->bindings);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return [];
        }
    }

    public function create(array $data)
    {
        try {
            $columns = implode(", ", array_keys($data));
            $placeholders = implode(", ", array_fill(0, count($data), "?"));
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            return $stmt->execute(array_values($data));
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function update(array $data)
    {
        try {
            $set = [];
            foreach ($data as $column => $value) {
                $set[] = "$column = ?";
            }
            $sql = "UPDATE {$this->table} SET " . implode(", ", $set);
            if (!empty($this->where)) {
                $sql .= " WHERE " . implode(" AND ", $this->where);
            }
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            $stmt->execute(array_merge(array_values($data), $this->bindings));
            
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function delete()
    {
        try {
            $sql = "DELETE FROM {$this->table}";
            if (!empty($this->where)) {
                $sql .= " WHERE " . implode(" AND ", $this->where);
            }
            $conn = Database::getInstance()->getConnection();
            $stmt = $conn->prepare($sql);
            return $stmt->execute($this->bindings);
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function limit($limit)
    {
        return $this->get(intval($limit));
    }

    public function reset()
    {
        $this->where = [];
        $this->bindings = [];
        return $this;
    }
}
