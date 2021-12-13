<?php

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

    static function GetFormattedDate($timestamp)
    {
        return date('j ' . Date::DATE_M[date('m', $timestamp) - 1] . ' Y года', $timestamp);
    }
}