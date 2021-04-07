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
     * @param $strings string|array
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithStrings($array, $strings, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        $result = [];
        foreach ($array as $key => $item) {
            // Если элемент массива не строк, прпоускаем его
            if (!is_string($item)) { continue; }

            if (!is_array($strings)) { $strings = [$strings]; }

            // Ищем хотябы одну из подстрок
            $flag = false;
            foreach ($strings as $string) { $flag = ((mb_strpos($item, $string) !== false) ? true : $flag); }

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
     * Массив элементов содержащих передаваемые подстроки в одном из полей
     *
     * @param $array array
     * @param $strings string|array
     * @param $field string
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithStringsInField($array, $strings, $field, $safeKeys = false)
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
            $flag = false;
            foreach ($strings as $string) { $flag = ((mb_strpos($item[$field], $string) !== false) ? true : $flag); }

            // Если элемент массива содержит одну из искомых подстрок
            if ($flag) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }

    /**
     * Массив строк не содержащих все передаваемые строки
     *
     * @param $array array
     * @param $strings string|array
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithoutStrings($array, $strings, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];
        foreach ($array as $key => $item) {
            $add = true;

            // Если элемент массива строка
            if (is_string($item)) {
                // Перебираем искомые подстроки
                foreach ($strings as $string) {
                    // Если хотябы одна из подстрок найдена, элемент массива не будет добавлен
                    $add = ((mb_strpos($item, $string) !== false) ? false : $add);
                }
            }

            // Если элемент массива нужно добавить
            if ($add) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }

    /**
     * Массив элементов не содержащих все передаваемые подстроки в одном из полей
     *
     * @param $array array
     * @param $strings string|array
     * @param $field string
     * @param $safeKeys bool
     * @return array
     */
    public static function arrayWithoutStringsInField($array, $strings, $field, $safeKeys = false)
    {
        if (!is_array($array)) { return []; }

        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];
        foreach ($array as $key => $item) {
            $add = true;

            if (
                // Если поле в элементе массива существует
                isset($item[$field])
                // Если поле в элементе массива строка
                && is_string($item[$field])
            ) {
                // Перебираем искомые подстроки
                foreach ($strings as $string) {
                    // Если хотябы одна из подстрок найдена, элемент массива не будет добавлен
                    $add = ((mb_strpos($item[$field], $string) !== false) ? false : $add);
                }
            }

            // Если элемент массива нужно добавить
            if ($add) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }
        return $result;
    }
}