<?php

require_once "Collection.php";

abstract class Model
{
    public $connection;
    protected $table;
    protected $columns;
    protected $database = "site";

    private $where = "";
    private $operator = "AND";
    private $order = "";
    private $limit = "";
    private $offset = "";

    private $sql = "";

    public function __construct()
    {
        $cfg = require "config.php";
        $this->connection = new mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"], $this->database);
    }

    public function insert(array $attributes = [])
    {
        $columns = "";
        $values = "";
        if (count($attributes) > 0) {
            $i = 0;
            foreach ($attributes as $column => $value) {
                if (!in_array($column, $this->columns)) {
                    return false;
                }

                $column = $this->connection->real_escape_string($column);
                $columns .= "'" . $column . "'";

                $value = $this->connection->real_escape_string($value);
                $values .= "'" . $value . "'";

                $i++;
                if (count($attributes) != $i) {
                    $columns .= ", ";
                    $values .= ", ";
                }
            }
        }

        $sql = "INSERT INTO  " . $this->table . " (" . $columns . ") VALUES (" . $values . ");";
        $this->sql .= $sql;
        $this->clear();

        return $this;
    }

    public function select(array $columns = [])
    {
        $str = "";
        if (count($columns) > 0) {
            foreach ($columns as $id => $column) {
                if (!in_array($column, $this->columns)) {
                    return [];
                }
                $column = $this->connection->real_escape_string($column);
                $str .= $column;

                if (count($columns) - 1 != $id) {
                    $str .= ", ";
                }
            }
        } else {
            $str = "*";
        }
        $sql = "SELECT " . $str . " FROM " . $this->table . $this->where . $this->order . ";";
        $this->sql .= $sql;

        $this->clear();
        return $this;
    }

    public function where(string $column, string $value)
    {
        if (!in_array($column, $this->columns)) {
            return null;
        }

        $column = $this->connection->real_escape_string($column);
        $value = $this->connection->real_escape_string($value);

        if ($this->where == "") {
            $this->where = " WHERE " . $column . " = '" . $value . "'";
        } else {
            $this->where .= " " . $this->operator . " " . $column . " = '" . $value . "'";
        }

        return $this;
    }

    public function and()
    {
        $this->operator = "AND";
        return $this;
    }

    public function or()
    {
        $this->operator = "OR";
        return $this;
    }

    public function order(string $column, string $type = "DESC")
    {
        if (!in_array($column, $this->columns)) {
            return false;
        }
        $this->order = " ORDER BY '" . $column . "' " . $type . " ";

        return $this;
    }

    public function limit(int $limit = 1)
    {
        $this->limit = " LIMIT " . $limit . " ";
        return $this;
    }

    public function offset(int $offset)
    {
        $this->offset = " OFFSET " . $offset . " ";
        return $this;
    }

    public function run(string $sql = ""): array
    {
        $result = [];
        $this->sql .= $sql;
        $this->sql = $this->connection->query($this->sql);

        if ($this->sql->num_rows > 0) {
            while ($row = $this->sql->fetch_assoc()) {
                $collection = new Collection();
                foreach ($row as $key => $value) {
                    $collection->$$key = $value;
                }
                $result[] = $collection;
            }
        }

        $this->sql = "";
        $this->clear();
        return $result;
    }

    private function clear()
    {
        $this->where = null;
        $this->operator = "AND";
        $this->order = "";
        $this->limit = "";
        $this->offset = "";
    }
}