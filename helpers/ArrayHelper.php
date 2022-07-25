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
    public static function sortByField(array $array, string $field, string $order = 'asc'): array
    {
        uasort($array, function($a, $b) use($field, $order) {
            if ($order == 'desc') { return (($a[$field] < $b[$field]) ? 1 : -1); }
            else { return (($a[$field] > $b[$field]) ? 1 : -1); }
        });
        return $array;
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
     * [0 => ['id' => 1, 'name' = 'aaa'], 2 => ['id' => 5, 'name' = 'bbb']], 'name', 'id'
     * --> ['1' => 'aaa', '5' => 'bbb']
     *
     * [0 => ['id' => 1, 'name' = 'aaa'], 2 => ['id' => 5, 'name' = 'bbb']], 'name', 'id'
     * --> [0 => 'aaa', 1 => 'bbb']
     *
     * ['a' => {id: 1, name: 'aaa'}, 'b' => {id: 5, name: 'bbb'}], 'name', 'id'
     * --> ['1' => 'aaa', '5' => 'bbb']
     *
     * ['a' => {id: 1, name: 'aaa'}, 'b' => {id: 5, name: 'bbb'}], 'name', 'id'
     * --> [0 => 'aaa', 1 => 'bbb']
     */
    public static function arrayValuesByField(array $array, string $fieldValue, string $fieldKey = null): ?array
    {
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
     * ['1', '11bb', '111', 'z' => '111bb'], ['111', 'bb']
     * --> ['11bb', '111', '111bb']
     *
     * ['1', '11bb', '111', '111bb'], ['111', 'bb'], true
     * --> [1 => '11bb', 2 => '111', 'z' => '111bb']
     */
    public static function arrayWithStrings(array $array, string|array $strings, bool $safeKeys = false): array
    {
        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];

        foreach ($array as $key => $item) {
            // Если элемент массива не строка, прпоускаем его
            if (!is_string($item)) { continue; }

            // Перебираем искомые подстроки
            $add = false;
            foreach ($strings as $string) {
                // Если хотябы одна из подстрок найдена, элемент массива будет добавлен
                $add = ((mb_strpos($item, $string) !== false) ? true : $add);
            }

            // Если элемент массива содержит искомую строку
            if ($add) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }

        return $result;
    }

    /**
     * Получение массива, не содержащего элементы с указанными подстроками
     *
     * Примеры:
     *
     * ['1', '11bb', '111', 'z' => 'bbb'], ['1']
     * --> ['111bb']
     *
     * ['1', '11bb', '111', 'z' => 'bbb'], ['1'], true
     * --> ['z' => '111bb']
     */
    public static function arrayWithoutStrings(array $array, string|array $strings, bool $safeKeys = false): array
    {
        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];

        foreach ($array as $key => $item) {
            // Если элемент массива не строка, прпоускаем его
            if (!is_string($item)) { continue; }

            // Перебираем искомые подстроки
            $add = true;
            foreach ($strings as $string) {
                // Если хотябы одна из подстрок найдена, элемент массива не будет добавлен
                $add = ((mb_strpos($item, $string) !== false) ? false : $add);
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
     * Получение массива, содержащего элементы (массивы или объекты), содержащие в значении по ключу (массив) или поле (объект) одну из указанных подстрок
     *
     * Примеры:
     *
     * [['id' => 1, 'name' => '1'], ['id' => 2, 'name' => '11bb'], ['id' => 3, 'name' => '111'], 'z' => ['id' => 4, 'name' => '111bb']], ['111', 'bb'], 'name'
     * --> [['id' => 2, 'name' => '11bb'],['id' => 3, 'name' => '111'], ['id' => 4, 'name' => '111bb']]
     *
     * [['id' => 1, 'name' => '1'], ['id' => 2, 'name' => '11bb'], ['id' => 3, 'name' => '111'], 'z' => ['id' => 4, 'name' => '111bb']], ['111', 'bb'], 'name', true
     * --> [1 => ['id' => 2, 'name' => '11bb'], 2 => ['id' => 3, 'name' => '111'], 'z' => ['id' => 4, 'name' => '111bb']]
     */
    public static function arrayWithStringsInField(array $array, string|array $strings, string $fieldName, bool $safeKeys = false): array
    {
        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];

        foreach ($array as $key => $item) {
            if (is_object($item)) {
                // Если поле в объекте не существует или значение в этом поле не является строкой
                if (!isset($item->$fieldName) || !is_string($item->$fieldName)) { continue; }
            } else {
                // Если ключ в массиве не существует или значение по этому ключу не является строкой
                if (!isset($item[$fieldName]) || !is_string($item[$fieldName])) { continue; }
            }

            // Перебираем искомые подстроки
            $add = false;
            foreach ($strings as $string) {
                // Если хотябы одна из подстрок найдена, элемент массива будет добавлен
                $add = ((mb_strpos(((is_object($item)) ? $item->$fieldName : $item[$fieldName]), $string) !== false) ? true : $add);
            }

            // Если элемент массива содержит одну из искомых подстрок
            if ($add) {
                // Записываем элемент массива в результат
                if ($safeKeys) { $result[$key] = $item; }
                else { $result[] = $item; }
            }
        }

        return $result;
    }

    /**
     * Получение массива, содержащего элементы (массивы или объекты), содержащие в значении по ключу (массив) или поле (объект) одну из указанных подстрок
     *
     * Примеры:
     *
     * [['id' => 1, 'name' => '1'], ['id' => 2, 'name' => '11bb'], ['id' => 3, 'name' => '111'], 'z' => ['id' => 4, 'name' => 'bb']], ['1'], 'name'
     * --> [['id' => 4, 'name' => 'bb']]
     *
     * [['id' => 1, 'name' => '1'], ['id' => 2, 'name' => '11bb'], ['id' => 3, 'name' => '111'], 'z' => ['id' => 4, 'name' => 'bb']], ['1'], 'name', true
     * --> ['z' => ['id' => 4, 'name' => 'bb']]
     */
    public static function arrayWithoutStringsInField(array $array, string|array $strings, string $fieldName, bool $safeKeys = false): array
    {
        if (!is_array($strings)) { $strings = [$strings]; }

        $result = [];

        foreach ($array as $key => $item) {
            if (is_object($item)) {
                // Если поле в объекте не существует или значение в этом поле не является строкой
                if (!isset($item->$fieldName) || !is_string($item->$fieldName)) { continue; }
            } else {
                // Если ключ в массиве не существует или значение по этому ключу не является строкой
                if (!isset($item[$fieldName]) || !is_string($item[$fieldName])) { continue; }
            }

            // Перебираем искомые подстроки
            $add = true;
            foreach ($strings as $string) {
                // Если хотябы одна из подстрок найдена, элемент массива не будет добавлен
                $add = ((mb_strpos($item[$fieldName], $string) !== false) ? false : $add);
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
     * Получить уникальные значения по ключу
     *
     * Примеры:
     *
     * [0 => ['a' => '111'], 1 => ['a' => '111'], 2 => ['a' => '222']], 'a'
     * --> ['111' => '111', '222' => '222']
     */
    public static function getUniqueValuesByKey(array $elems, string $key): array
    {
        $values = [];
        // Перебираем элементы
        foreach ($elems as $elem) {
            $value = ((is_object($elem)) ? $elem->$key : $elem[$key]);
            if (!isset($values[$value])) { $values[$value] = $value; }
        }

        // Возвращаем одинаковое значение
        return $values;
    }

    /*** Соединение массивов ***/

    /**
     * Сложение значений ключей массивов
     *
     * Примеры:
     * ['a' => 10, 'b' => 20], ['a' => 5, 'c' => 5]
     * --> ['a' => 15, 'b' => 20]
     */
    public static function leftJoinSum(array $array1, array $array2): array
    {
        // Перебираем элементы первого массива
        foreach ($array1 as $key => $x) {
            // Если в втором массиве нет такого элемента
            if (!isset($array2[$key])) { continue; }

            // Если значение элемента первого массива и соотвествующее ему значение элемента второго массива являются массивами
            // Расчитываем рекурсивно их сложение
            if (is_array($x) && is_array($array2[$key])) { $array1[$key] = self::leftJoinSum($x, $array2[$key]); }
            elseif (
                // Если значение элемента первого массива это число
                is_numeric($x)
                // Если соотвествующее значение элемента второго массива это число
                && is_numeric($array2[$key])
            ) { $array1[$key] = $x + $array2[$key]; }
        }

        return $array1;
    }

    /*** Другое ***/

    /**
     * Единое значение во всех элементах массива
     * Возвращает значение, если оно едино для всех элементов, иначе $default
     */
    public static function sameValueByKey(array $elems, string $key, mixed $default = null): mixed
    {
        // Первый элемент
        $firstElem = current($elems);
        // Значение в первом элементе
        $firstElemValue = ((is_object($firstElem)) ? $firstElem->$key : $firstElem[$key]);

        // Перебираем элементы
        foreach ($elems as $elem) {
            // Если значение в очередном элементе отличается от знаачения в первом элементе
            if (((is_object($elem)) ? $elem->$key : $elem[$key]) !== $firstElemValue) {
                // Возвращаем значение по умолчанию
                return $default;
            }
        }

        // Возвращаем одинаковое значение
        return $firstElemValue;
    }
}