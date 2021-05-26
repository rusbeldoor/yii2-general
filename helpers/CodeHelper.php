<?php

namespace rusbeldoor\yii2General\helpers;

class CodeHelper {
    public static $chars = [
        'numbers' => '0123456789',
        'numbers_safe' => '23456789',
        'latin_lowercase' => 'abcdefghijklmnopqrstuvwxyz',
        'latin_lowercase_safe' => 'abcdefghkmnpqrstuvwxyz',
        'latin_uppercase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'latin_uppercase_safe' => 'ABCDEFGHKMNPQRSTUVWXYZ',
        'cyrillic_lowercase' => 'абвгдеёжзийклмнопрстуфхцчшщьыъэюя',
        'cyrillic_lowercase_safe' => 'абвгдежзиклмнпрстуфхцчшщыэюя',
        'cyrillic_uppercase' => 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ',
        'cyrillic_uppercase_safe' => 'АБВГДЕЖЗИКЛМНПРСТУФХЦЧШЩЫЭЮЯ',
        'special_symbols' => '+-*/()[]{}<>|!?@#$%^&:;., ',
        'special_symbols_safe' => '+-*/()[]{}<>?@#$%^&:;.,',
        'secret' => 'YZRD3XkaQ1Cbce2mnSTopqwW9izEuvUVlstA8JG60B4IfF5H7ghOPxydKLjMNr',
    ];

    /**
     * Генерация уникального кода
     *
     * @param int $length
     * @param array $chars_names
     * @param array $params
     * @return string
     */
    public static function generate($length, $chars_names, $params = [])
    {
        if (isset($chars_names['numbers']) && isset($chars_names['numbers_safe'])) { unset($chars_names['numbers']); }
        if (isset($chars_names['latin_lowercase']) && isset($chars_names['latin_lowercase_safe'])) { unset($chars_names['latin_lowercase_safe']); }
        if (isset($chars_names['latin_uppercase']) && isset($chars_names['latin_uppercase_safe'])) { unset($chars_names['latin_uppercase_safe']); }

        $result = '';

        $chars = '';
        foreach ($chars_names as $chars_name) { $chars .= self::$chars[$chars_name]; }
        $chars_length = mb_strlen($chars);

        for ($i = 1; $i <= $length; $i++) {
            $char = $chars[mt_rand(0, ($chars_length - 1))];

            // Если это первый символ
            if ($i == 1) {
                // Если символ пробела
                if ($char == ' ') { $i--; continue; }

                if (
                    // Если символ 0 (ноль)
                    ($char == '0')
                    // Если первый символ не может быть нулём
                    && (isset($params['not_first_zero']))
                ) { $i--; continue; }
            }

            // Если это последний символ
            if ($i == $length) {
                // Если символ пробела
                if ($char == ' ') { $i--; continue; }
            }

            $result .= $char;
        }

        return $result;
    }

    /**
     * Генерация пароля
     *
     * @param int $length
     * @return string
     */
    public static function generatePassword($length)
    { return self::generate($length, ['numbers_safe', 'latin_lowercase_safe']); }

    /**
     * Генерация системного пароля
     *
     * @param int $length
     * @return string
     */
    public static function generateSystemPassword($length)
    { return self::generate($length, ['numbers', 'latin_lowercase', 'latin_uppercase', 'special_symbols']); }

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
        if (!(bool)preg_match('/[' . self::$chars['numbers'] . ']+/', $password)) { $problems[] = 'Пароль должен содержать хотябы одну цифру.'; }
        if (!(bool)preg_match('/[' . self::$chars['latin_uppercase'] . self::$chars['cyrillic_uppercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну заглавную букву.'; }
        if (!(bool)preg_match('/[' . self::$chars['latin_lowercase'] . self::$chars['cyrillic_lowercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну строчную (не заглавную) букву.'; }
        return $problems;
    }
}