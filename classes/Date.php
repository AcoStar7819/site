<?php

namespace classes\Controllers;

/**
 * Класс для работы с отформатированной датой
 */
class Date
{
    private const DATE_M = [
        'января',
        'февраля',
        'марта',
        'апреля',
        'мая',
        'июня',
        'июля',
        'августа',
        'сентября',
        'октября',
        'ноября',
        'декабря',
    ];

    /**
     * Возвращает отформатированную дату
     * UNIX->Человеческий формат
     *
     * @param $timestamp
     * @param bool $time Учитывать часы и минуты
     * @return string
     */
    static function getFormattedDate($timestamp, bool $time = false) : string
    {
        if ($time)
        {
            return date('j ' . Date::DATE_M[date('m', $timestamp) - 1] . ' Y года, в G:i', $timestamp);
        } else
        {
            return date('j ' . Date::DATE_M[date('m', $timestamp) - 1] . ' Y года', $timestamp);
        }
    }
}