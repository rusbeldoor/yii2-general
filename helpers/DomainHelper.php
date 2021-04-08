<?php

namespace rusbeldoor\yii2General\helpers;

class DomainHelper
{
    /**
     * Коррекция домена
     *
     * @param string $domain
     * @return string
     */
    public static function correct($domain)
    {
        // Переводим в нижний регистр
        $domain = mb_strtolower($domain);

        // Удаляем протокол
        $domain = str_replace('http://', '', $domain);
        $domain = str_replace('https://', '', $domain);

        // Удаляем всё не относящееся к домену
        $domain = explode('/', $domain);
        $domain = $domain[0];

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
     * @param string $domain
     * @return bool
     */
    public static function check($domain)
    {
        return $domain != '';
    }
}