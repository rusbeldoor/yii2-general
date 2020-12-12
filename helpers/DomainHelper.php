<?php

namespace rusbeldoor\yii2General\helpers;

class DomainHelper
{
    /**
     * Коррекция электронной почты
     *
     * @param $domain string
     * @return string
     */
    public static function correct($domain)
    {
        // Переводим в нижний регистр
        $domain = mb_strtolower($domain);

        // Удаляем все не подходящие символы
        $domain = preg_replace('/[^\.-_0-1a-zа-я]/', '', $domain);

        // Удаляем точки, минусы, подчеркивания в начале b конце строки
        $domain = preg_replace('/(\.-_)+$/', '', $domain); // Не существует: .$, -_$, и т.д. — удаляем
        $domain = preg_replace('/^(\.-_)+/', '', $domain); // Не существует: ^., ^_-, и т.д. — удаляем

        return $domain;
    }

    /**
     * Проверка домена
     *
     * @param $domain string
     * @return bool
     */
    public static function check($domain)
    {
        return $domain != '';
    }
}