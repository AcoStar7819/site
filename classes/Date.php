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

    static function getFormattedDate($timestamp, bool $time = false)
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