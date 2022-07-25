<?php

namespace rusbeldoor\yii2General\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    const YES_NO = [1 => 'Да', 0 => 'Нет'];

    /*** Преобразование массива ***/

    /** Объединение с значением по уомлчанию */
    public static function mergeWithDefault(array $array, string|array|null $default = null): array
    {
        if ($default === null) { return $array; }
        if (!is_array($default)) { $default = ['' => (string)$default]; }
        return $default + $array;
    }

    /** Сортировка двумерного массива по полю */
    public static function sortByField(array &$array, string $field, string $order = 'asc'): void
    {
        uasort($array, function($a, $b) use($field, $order) {
            if ($order == 'desc') { return (($a[$field] < $b[$field]) ? 1 : -1); }
            else { return (($a[$field] > $b[$field]) ? 1 : -1); }
        });
    }

    /**
     * Удалить элементы массива по значению
     *
     * Примеры:
     *
     * [0 => '0', 1 => null, 2 => 3, 3 => 12, 4 => '0'], [null, 0, '0']
     * --> [2 => 3, 3 => 12]
     */
    public static function unsetByValues(array $array, array $values): array
    {
        foreach ($array as $key => $value) {
            if (in_array($value, $values, true)) { unset($array[$key]); }
        }

        return $array;
    }

    /*** Формирование нового массива ***/

    /**
     * Формирование массива по ключю взятому из поля
     *
     * Примеры:
     *
     * [0 => ['id' => 1, 'name' = 'aaa'], 2 => ['id' => 5, 'name' = 'bbb']]
     * --> ['1' => ['id' => 1, 'name' = 'aaa'], '5' => ['id' => 5, 'name' = 'bbb']]
     *
     * ['a' => {id: 1, name: 'aaa'}, 'b' => {id: 5, name: 'bbb'}]
     * --> ['1' => {id: 1, name: 'aaa'}, '5' => {id: 5, name: 'bbb'}]
     */
    public static function arrayByField(array $array, string|array $field, string $separator = ''): ?array
    {
        if (!is_array($array)) { return null; }

        $result = [];
        foreach ($array as $item) {
            if (is_array($field)) {
                $keys = [];
                foreach ($field as $f) { $keys[] = (string)((is_object($item)) ? $item->$f : $item[$f]); }
                $key = implode($separator, $keys);
            } else { $key = (string)((is_object($item)) ? $item->$field : $item[$field]); }
            $result[$key] = $item;
        }

        return $result;
    }

    /**
     * Формирование массива по ключю и значению взятых из полей
     *
     * Примеры:
     *
     * [0 => ['id' => 1, 'name' = 'aaa'], 2 => ['id' => 5, 'name' = 'bbb']]
     * --> ['1' => 'aaa', '5' => 'bbb']
     *
     * [0 => ['id' => 1, 'name' = 'aaa'], 2 => ['id' => 5, 'name' = 'bbb']]
     * --> [0 => 'aaa', 1 => 'bbb']
     *
     * ['a' => {id: 1, name: 'aaa'}, 'b' => {id: 5, name: 'bbb'}]
     * --> ['1' => 'aaa', '5' => 'bbb']
     *
     * ['a' => {id: 1, name: 'aaa'}, 'b' => {id: 5, name: 'bbb'}]
     * --> [0 => 'aaa', 1 => 'bbb']
     */
    public static function arrayValuesByField(array $array, string $fieldValue, string $fieldKey = null): ?array
    {
        if (!is_array($array)) { return null; }

        $result = [];
        foreach ($array as $item) {
            $value = (string)((is_object($item)) ? $item->$fieldValue : $item[$fieldValue]);

            if ($fieldKey === null) { $result[] = $value; }
            else { $result[(string)((is_object($item)) ? $item->$fieldKey : $item[$fieldKey])] = $value; }
        }

        return $result;
    }

    /**
     * Получение массива, содержащего элементы с одной из указанных подстрок
     *
     * Примеры:
     *
     * ['0' => '1', '2' => '11bb', '3' => '111', '4' => '111bb'], ['111', 'bb']
     * --> ['2' => 'aaa', '5' => 'bbb']
     */
    public static function arrayWithStrings(array $array, string|array $strings, bool $safeKeys = false): array
    {
        if (!is_array($array)) { return []; }
        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];

        foreach ($array as $key => $item) {
            // Если элемент массива не строка, прпоускаем его
            if (!is_string($item)) { continue; }

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
     * Примеры:
     *
     * ...
     */
    public static function arrayWithStringsInField(array $array, string|array $strings, string $field, bool $safeKeys = false): array
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
     * Примеры:
     *
     * ...
     */
    public static function arrayWithoutStrings(array $array, string|array $strings, bool $safeKeys = false): array
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
     * Примеры:
     *
     * ...
     */
    public static function arrayWithoutStringsInField(array $array, string|array $strings, string $field, bool $safeKeys = false): array
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