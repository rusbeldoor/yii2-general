<?php

namespace rusbeldoor\yii2General\helpers;

class CodeHelper
{
    public static $abc = [
        'numbers' => '0123456789',
        'numbersSafe' => '23456789',
        'latinLowercase' => 'abcdefghijklmnopqrstuvwxyz',
        'latinLowercaseSafe' => 'abcdefghkmnpqrstuvwxyz',
        'latinUppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'latinUppercaseSafe' => 'ABCDEFGHKMNPQRSTUVWXYZ',
        'cyrillicLowercase' => 'абвгдеёжзийклмнопрстуфхцчшщьыъэюя',
        'cyrillicLowercaseSafe' => 'абвгдежзиклмнпрстуфхцчшщыэюя',
        'cyrillicUppercase' => 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ',
        'cyrillicUppercaseSafe' => 'АБВГДЕЖЗИКЛМНПРСТУФХЦЧШЩЫЭЮЯ',
        'specialSymbols' => '+-*/()[]{}<>|!?@#$%^&:;., ',
        'specialSymbolsSafe' => '+-*/()[]{}<>?@#$%^&:;.,',
        'secret' => 'YZRD3XkaQ1Cbce2mnSTopqwW9izEuvUVlstA8JG60B4IfF5H7ghOPxydKLjMNr',
    ];

    /**
     * Генерация уникального кода по массиву
     *
     * @param int $length
     * @param array $abcArray
     * @param array $params
     * @return string
     */
    public static function generateByArray($length, $abcArray, $params = [])
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

    /**
     * Генерация уникального кода по строке
     *
     * @param int $length
     * @param string $abcString
     * @param array $params
     * @return string
     */
    public static function generateByString($length, $abcString, $params = [])
    {
        // Алфавит
        $abcArray = preg_split('/(?<!^)(?!$)/u', $abcString);

        return self::generateByArray($length, $abcArray, $params);
    }

    /**
     * Генерация уникального кода по названиям алфавитов
     *
     * @param int $length
     * @param array $abcNames
     * @param array $params
     * @return string
     */
    public static function generateByAbcNames($length, $abcNames, $params = [])
    {
        // Алфавит
        $abc = '';
        foreach ($abcNames as $abcName) { $abc .= self::$abc[$abcName]; }

        return self::generateByString($length, $abc, $params);
    }

    /**
     * Генерация пароля
     *
     * @param int $length
     * @return string
     */
    public static function generatePassword($length)
    { return self::generateByAbcNames($length, ['numbersSafe', 'latinLowercaseSafe']); }

    /**
     * Генерация системного пароля
     *
     * @param int $length
     * @return string
     */
    public static function generateSystemPassword($length)
    { return self::generateByAbcNames($length, ['numbers', 'latinLowercase', 'latinUppercase', 'specialSymbols']); }

    /**
     * Проверка безопасности пароля
     *
     * @param string $password
     * @return string
     */
    public static function checkPasswordSecurity($password)
    {
        $problems = [];
        if (mb_strlen($password) < 8) { $problems[] = 'Пароль должен быть 8 или более символов.'; }
        if (!(bool)preg_match('/[' . self::$abc['numbers'] . ']+/', $password)) { $problems[] = 'Пароль должен содержать хотябы одну цифру.'; }
        if (!(bool)preg_match('/[' . self::$abc['latinUppercase'] . self::$abc['cyrillicUppercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну заглавную букву.'; }
        if (!(bool)preg_match('/[' . self::$abc['latinLowercase'] . self::$abc['cyrillicLowercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну строчную (не заглавную) букву.'; }
        return $problems;
    }
}