<?php

$cfg = require "config.php";

class LocaleData
{
    private $id;
    private $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }
}

class LocalesStore
{
    private static $loaded = false;
    private static $locales = [];

    public static function load()
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;
        global $cfg;

        $connection = new mysqli($cfg["DB_HOST"], $cfg["DB_USERNAME"], $cfg["DB_PASSWORD"], "site");
        $result = $connection->query(
            "SELECT * FROM `locales`;"
        );

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                self::$locales[] = new LocaleData($row["id"], $row["name"]);
            }
        }

        $connection->close();
    }

    public static function isLocaleExists(int $id): bool
    {
        foreach (self::$locales as $loc) {
            if ($loc->getId() == $id) {
                return true;
            }
        }
        return false;
    }

    public  static  function getName(int $id) : string
    {
        foreach (self::$locales as $loc) {
            if ($loc->getId() == $id) {
                return $loc->getName();
            }
        }
        return "";
    }
}

LocalesStore::load();