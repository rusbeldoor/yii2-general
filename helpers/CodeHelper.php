<?php

namespace rusbeldoor\yii2General\helpers;

class CodeHelper
{
    public static $abc = [
        'numbers' => '0123456789',
        'numbersSafe' => '2456789', // Без: 0, 1, 3
        'latinLowercase' => 'abcdefghijklmnopqrstuvwxyz',
        'latinLowercaseSafe' => 'abcdefghkmnpqrstuvwxyz', // Без: i, j, l, o
        'latinUppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'latinUppercaseSafe' => 'ABCDEFGHKMNPQRSTUVWXYZ', // Без: I, J, L, O
        'cyrillicLowercase' => 'абвгдеёжзийклмнопрстуфхцчшщьыъэюя',
        'cyrillicLowercaseSafe' => 'абвгдежзиклмнпрстуфхцчшщыэюя', // Без: ё, з, й, о
        'cyrillicUppercase' => 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ',
        'cyrillicUppercaseSafe' => 'АБВГДЕЖЗИКЛМНПРСТУФХЦЧШЩЫЭЮЯ', // Без: Ё, З, Й, О
        'specialSymbols' =>     '+-*/()[]{}<>|!?@#$%^&:;., ',
        'specialSymbolsSafe' => '+-*()[]{}<>?@#$%^&:;.,', // Без /, |, !, пробел
        'secret' => 'YZRD3XkaQ1Cbce2mnSTopqwW9izEuvUVlstA8JG60B4IfF5H7ghOPxydKLjMNr',
    ];

    /** Проверка кода по названиям алфавитов */
    public static function checkByAbcNames(string $code, array $abcNames): bool
    {
        $chars = '';
        foreach ($abcNames as $abcName) { $chars .= ((isset(self::$abc[$abcName])) ? self::$abc[$abcName] : $abcName); }
        $chars = array_unique(mb_str_split($chars));

        $codeChars = array_unique(mb_str_split($code));
        foreach ($codeChars as $codeChar) {
            if (!in_array($codeChar, $chars)) { return false; }
        }

        return true;
    }

    /** Генерация уникального кода по массиву символов */
    public static function generateBySymbolsArray(int $length, array $abcArray, array $params = []): string
    {
        // Параметры
        if (!isset($params['notFirstZero'])) { $params['notFirstZero'] = false; }
        if (!isset($params['notFirstAndLastSpace'])) { $params['notFirstAndLastSpace'] = false; }

        // Алфавит
        $abcArray = array_unique($abcArray);
        $abcArray = array_values($abcArray);
        $abcArrayLength = count($abcArray);

        $result = '';

        // Генерируем необходимое количество символов
        for ($i = 1; $i <= $length; $i++) {
            // Генерируем новый символ
            $char = $abcArray[mt_rand(0, ($abcArrayLength - 1))];

            // Если первый символ
            if ($i == 1) {
                if (
                    // Если символ пробела
                    ($char == ' ')
                    // Если первый и последний пробел запрещены
                    && $params['notFirstAndLastSpace']
                ) { $i--; continue; }

                if (
                    // Если символ 0 (ноль)
                    ($char == '0')
                    // Если первый ноль запрещён
                    && ($params['notFirstZero'])
                ) { $i--; continue; }
            }

            // Если последний символ
            if ($i == $length) {
                if (
                    // Если символ пробела
                    ($char == ' ')
                    // Если первый и последний пробел запрещены
                    && $params['notFirstAndLastSpace']
                ) { $i--; continue; }
            }

            // Добавляем новый символ
            $result .= $char;
        }

        return $result;
    }

    /** Генерация уникального кода по строке */
    public static function generateByString(int $length, string $abcString, array $params = []): string
    {
        // Алфавит
        $abcArray = preg_split('/(?<!^)(?!$)/u', $abcString);

        return self::generateBySymbolsArray($length, $abcArray, $params);
    }

    /** Генерация уникального кода по названиям алфавитов */
    public static function generateByAbcNames(int $length, array $abcNames, array $params = []): string
    {
        // Алфавит
        $abc = '';
        foreach ($abcNames as $abcName) { $abc .= self::$abc[$abcName]; }

        return self::generateByString($length, $abc, $params);
    }
}