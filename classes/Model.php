<?php

namespace classes;

/**
 * Наследуемый класс для работы с базой данных
 */
abstract class Model
{
    public \mysqli $connection;
    protected string $table;
    protected array $columns;
    protected string $database = "site";

    private string $where = "";
    private string $operator = "AND";
    private string $order = "";
    private string $limit = "";
    private string $offset = "";

    private string $sql = "";

    public function __construct()
    {
        $cfg = require "config.php";
        $this->connection = new \mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"], $this->database);
    }

    /**
     * Вставка записей в таблицу
     *
     * ['column' => $value]
     * @param array $attributes
     * @return $this|false
     */
    public function insert(array $attributes = []): Model|false
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

    /**
     * Выбор записей из таблицы по ранее заданному условию
     * @param array $columns
     * @return $this|false
     */
    public function select(array $columns = []): Model|false
    {
        $str = "";
        if (count($columns) > 0) {
            foreach ($columns as $id => $column) {
                if (!in_array($column, $this->columns)) {
                    return false;
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

    /**
     * @param string $column
     * @param string $value
     * @return false|$this
     */
    public function where(string $column, string $value): Model|false
    {
        if (!in_array($column, $this->columns)) {
            return false;
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

    /**
     * Добавление AND в SQL запрос
     * @return $this
     */
    public function and(): Model
    {
        $this->operator = "AND";
        return $this;
    }

    /**
     * Добавление OR в SQL запрос
     * @return $this
     */
    public function or(): Model
    {
        $this->operator = "OR";
        return $this;
    }

    /**
     * Сортировка записей
     *
     * @param string $column
     * @param string $type
     * @return $this|false
     */
    public function order(string $column, string $type = "DESC"): Model|false
    {
        if (!in_array($column, $this->columns)) {
            return false;
        }
        $this->order = " ORDER BY '" . $column . "' " . $type . " ";

        return $this;
    }

    /**
     * Ограничение по количеству выбираемых записей
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit = 1): Model
    {
        $this->limit = " LIMIT " . $limit . " ";
        return $this;
    }

    /**
     * Отступ при выборе записей
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): Model
    {
        $this->offset = " OFFSET " . $offset . " ";
        return $this;
    }

    /**
     * Окончательное выполнение сформированного запроса
     * @param string $sql Чистый SQL для выполнения вместе с сформированным запросом
     * @return array
     */
    public function run(string $sql = ""): array
    {
        $result = [];
        $this->sql .= $sql;
        $this->sql = $this->connection->query($this->sql);

        if ($this->sql->num_rows > 0) {
            while ($row = $this->sql->fetch_assoc()) {
                $collection = new \Collection();
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

    /**
     * Возвращение приватных свойств к их изначальным значениям
     * @return void
     */
    private function clear(): void
    {
        $this->where = null;
        $this->operator = "AND";
        $this->order = "";
        $this->limit = "";
        $this->offset = "";
    }
}