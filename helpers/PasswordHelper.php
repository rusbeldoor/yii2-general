<?php

namespace rusbeldoor\yii2General\helpers;

class PasswordHelper
{
    /** Генерация пароля */
    public static function generate(int $length): string
    { return self::generate($length, ['numbersSafe', 'latinLowercaseSafe']); }

    /** Генерация системного пароля */
    public static function generateSystem(int $length): string
    { return self::generate($length, ['numbers', 'latinLowercase', 'latinUppercase', 'specialSymbols']); }

    /** Проверка безопасности пароля */
    public static function checkSecurity(string $password): array
    {
        $problems = [];
        if (mb_strlen($password) < 8) { $problems[] = 'Пароль должен быть 8 или более символов.'; }
        if (!(bool)preg_match('/[' . self::$abc['numbers'] . ']+/', $password)) { $problems[] = 'Пароль должен содержать хотя бы одну цифру.'; }
        if (!(bool)preg_match('/[' . self::$abc['latinUppercase'] . self::$abc['cyrillicUppercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотя бы одну заглавную букву.'; }
        if (!(bool)preg_match('/[' . self::$abc['latinLowercase'] . self::$abc['cyrillicLowercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотя бы одну строчную (не заглавную) букву.'; }
        return $problems;
    }
}