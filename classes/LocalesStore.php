<?php

require_once "Database/LocalesDatabase.php";
$cfg = require_once "config.php";

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

        $db = new LocalesDatabase();
        $result = $db->select()->run();
        $db->connection->close();

        if (count($result) > 0) {
            foreach ($result as $row) {
                self::$locales[] = new LocaleData($row["id"], $row["name"]);
            }
        }
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

    public static function getName(int $id): string
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