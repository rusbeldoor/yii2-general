<?php

namespace rusbeldoor\yii2General\helpers;

class PasswordHelper
{
    /**
     * Проверка безопасности
     *
     * @param string $password
     * @return string
     */
    public static function checkSecurity($password)
    {
        $problems = [];
        if (mb_strlen($password) < 8) { $problems[] = 'Пароль должен быть 8 или более символов.'; }
        if (!(bool)preg_match('/[' . self::$chars['numbers'] . ']+/', $password)) { $problems[] = 'Пароль должен содержать хотябы одну цифру.'; }
        if (!(bool)preg_match('/[' . self::$chars['latinUppercase'] . self::$chars['cyrillicUppercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну заглавную букву.'; }
        if (!(bool)preg_match('/[' . self::$chars['latinLowercase'] . self::$chars['cyrillicLowercase'] . ']+/u', $password)) { $problems[] = 'Пароль должен содержать хотябы одну строчную (не заглавную) букву.'; }
        return $problems;
    }
}