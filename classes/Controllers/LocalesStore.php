<?php

namespace classes\Controllers;

/**
 * Работа с загруженными локализациями
 */
class LocalesStore
{
    private static bool $loaded = false;
    private static array $locales = [];

    /**
     * Первичная загрузка всех локализаций
     */
    public static function load()
    {
        if (self::$loaded) {
            return;
        }

        self::$loaded = true;

        $db = new \classes\Database\Locales;
        $result = $db->select()->run();
        $db->connection->close();

        if (count($result) > 0) {
            foreach ($result as $collection) {
                self::$locales[] = $collection;
            }
        }
    }

    /**
     * Проверка существования локализации по её ID
     * @param int $id
     * @return bool
     */
    public static function isLocaleExists(int $id): bool
    {
        foreach (self::$locales as $loc) {
            if ($loc->id == $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * Получение названия локализации по её ID
     * @param int $id
     * @return string
     */
    public static function getName(int $id): string
    {
        foreach (self::$locales as $loc) {
            if ($loc->id == $id) {
                return $loc->name;
            }
        }
        return "";
    }
}

LocalesStore::load();