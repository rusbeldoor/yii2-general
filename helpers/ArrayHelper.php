<?php

namespace rusbeldoor\yii2General\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Массив по полю
     *
     * @param $array array
     * @param $field string
     * @return array
     */
    public static function arrayByField($array, $field)
    {
        if (!is_array($array)) { return []; }

        $result = [];
        foreach ($array as $item) {
            $key = ((is_object($item)) ? $item->$field : $item[$field]);
            $result[$key] = $item;
        }
        return $result;
    }

    /**
     * Массив строк содержащих передаваему строку
     *
     * @param $array array
     * @param $string string
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithString($array, $string, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        $result = [];
        foreach ($array as $key => $item) {
            // Если элемент массива не строк, прпоускаем его
            if (!is_string($item)) { continue; }
            // Если элемент массива содержит искомую строку
            if (mb_strpos($item, $string) !== false) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }

    /**
     * Массив строк не содержащих передаваемые строки
     *
     * @param $array array
     * @param $strings string|array
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithoutString($array, $strings, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];
        foreach ($array as $key => $item) {
            // Если элемент массива не строк, прпоускаем его
            if (!is_string($item)) { continue; }

            // Ищем хотябы одну из подстрок
            $flag = true;
            foreach ($strings as $string) { $flag = ((mb_strpos($item, $string) === false) ? false : $flag); }

            // Если элемент массива содержит искомую строку
            if ($flag) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }

    /**
     * Массив элементов не содержащих передаваемые подстроки в одном из полей
     *
     * @param $array array
     * @param $strings string|array
     * @param $field string
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithoutStringInField($array, $strings, $field, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];
        foreach ($array as $key => $item) {
            if (
                // Если поле в элементе не существует
                !isset($item[$field])
                // Если поле не строка
                || !is_string($item[$field])
            ) { continue; }

            // Ищем хотябы одну из подстрок
            $flag = true;
            foreach ($strings as $string) { $flag = ((mb_strpos($item[$field], $string) === false) ? false : $flag); }

            // Если элемент массива содержит одну из искомых подстрок
            if ($flag) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }
}