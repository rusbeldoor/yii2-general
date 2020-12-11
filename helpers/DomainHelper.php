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
        $domain = preg_replace('/(\.-_0-1a-zа-я)/', '', $domain);

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
        return true;
    }
}