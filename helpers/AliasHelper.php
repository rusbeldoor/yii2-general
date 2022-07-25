<?php

class AliasHelper
{
    public static $pattern = '^[a-z0-9\-]+$';

    /** Коррекция */
    public static function correct(string $alias): string
    { return mb_strtolower($alias); }

    /** Проверка */
    public static function check(string $alias): string
    { return (bool)preg_match('/' . self::$pattern . '/', $alias); }
}