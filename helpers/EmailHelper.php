<?php

namespace rusbeldoor\yii2General\helpers;

use rusbeldoor\yii2General\catalogs\EmailCatalog;

class EmailHelper
{
    /** Коррекция электронной почты */
    public static function correct(string $email): string
    {
        // Если почты нет либо нет знака @
        if (trim($email) == '' || !strpos($email, '@')) { return ''; }

        // Заменяем кириллицу на латиницу
        $email = str_replace('с', 'c', $email);

        // Удаляем пробелы
        $email = preg_replace('/[\s]/', '', $email);

        // Переводим в нижний регистр
        $email = mb_strtolower($email);

        // Удаляем точки или запятые в конце строки
        $email = preg_replace('/(\.|,)+$/', '', $email); // Не существует: .$, ..$, и т.д. — elfkztv

        // Разбиваем электронную почту на значение и домен, чтобы случайно не исправить почту
        $arrayEmail = explode('@', $email);
        if (isset($arrayEmail[1])) {
            // Запятая в домене
            $arrayEmail[1] = str_replace(',', '.', $arrayEmail[1]);

            /**
             * .r6, .r7, .r8, .ry, .ri, .rh, .rj, .rk, .re, .r, .rr, .rree, .rruu, .rreeuu и другие на .ru
             * 6, 7, 8, y, i, h, j, k - потому что стоит рядом с клавишей U
             * e - потому что находится на той же клавише, что и У (кирилица)
             * v - потому что похожа на клавишу U
             * b - потому что стоит рядом с клавишей V
             *
             * .3u, .4u, .5u, .tu, .du, .fu, .gu , .u, .uu, .ttuu, .rrttuu и другие на .ru
             * Исключение, существующие домены .eu
             * 3, 4, 5, t, d, f, g - потому что стоит рядом с клавишей R
             *
             * Punycode на латиницу
             * .rг, .кг, .rи, .гu на .ru
             *
             * Частные случаи
             */
            $arrayEmail[1] = preg_replace('/\.r+(6|7|8|y|i|h|j|k|e|v|b)*u*$/', '.ru', $arrayEmail[1]);
            $arrayEmail[1] = preg_replace('/\.r*(3|4|5|t|d|f|g)*u+$/', '.ru', $arrayEmail[1]);
            $arrayEmail[1] = preg_replace('/\.(xn--ru.*|xn--r-ftb|xn--c1an|xn--r-ptb|xn--u-etb)$/', '.ru', $arrayEmail[1]); //
            $arrayEmail[1] = preg_replace('/\.(pu|tru|кг|rг|кu)$/', '.ru', $arrayEmail[1]);

            /**
             * Punycode на латиницу
             * Замена .соm, .сom, coм на .com
             *
             * Частные случаи
             */
            $arrayEmail[1] = preg_replace('/\.(xn--com.*|xn--m-0tbi|xn--om-nmc|xn--co-9lc)$/', '.com', $arrayEmail[1]);
            $arrayEmail[1] = preg_replace('/\.(kom|con|c\.com|vom|com\.m|cim|cjm|cam|ccom|сom|соm|сом|cоm|cом|coм)$/', '.com', $arrayEmail[1]);

            // Убираем лишине символы после самого верхнего домена
            // .ru# на .ru, .coma на .com
            $arrayEmail[1] = preg_replace('/\.(com|net|org|ru)[^\.]+$/', '.$1', $arrayEmail[1]);

            // Повторение домена верхнего уровня
            // .ru.ru на .ru, .com.com на .com и т.д.
            $arrayEmail[1] = preg_replace('/(\.com){2,}$/', '$1', $arrayEmail[1]); // Исправляем .com.com на .com
            $arrayEmail[1] = preg_replace('/(\.net){2,}$/', '$1', $arrayEmail[1]); // Исправляем .net.net на .net
            $arrayEmail[1] = preg_replace('/(\.org){2,}$/', '$1', $arrayEmail[1]); // Исправляем .org.org на .org
            $arrayEmail[1] = preg_replace('/(\.ru){2,}$/', '$1', $arrayEmail[1]); // Исправляем .ru.ru на .ru

            // Каталог неккоректных доменов
            if (isset(EmailCatalog::$invalidDomain[$arrayEmail[1]])) { $arrayEmail[1] = EmailCatalog::$invalidDomain[$arrayEmail[1]]; }

            // Объединяем почту
            $email = implode('@', $arrayEmail);
        }

        // Яндекс
        $email = preg_replace('/^\+*(\d{10,13})\+*@(yandex|ya)\.(ru|by|kz|ua|com)$/', '$1@$2.$3', $email);

        return $email;
    }

    /** Проверка электронной почты */
    public static function check(string $email): bool
    {
        return
            (bool)preg_match('/^([a-zA-Z0-9_]|([a-zA-Z0-9_]+[a-zA-Z0-9_\.-]*[a-zA-Z0-9_-]+))@(([a-zA-Z0-9]+[a-zA-Z0-9\.-]*[a-zA-Z0-9]+)\.)+[a-zA-Z]{2,16}$/', $email)
            && !preg_match('/\.\./', $email);
    }

    /** Коррекция текста письма */
    public static function correctText(string $text): string
    {
        // Удаляем все теги кроме разрешенных
        // Важно! Если есть ошибки в написании тегов, то может удалиться лишнее
        $text = strip_tags($text, '<img><div><p><blockquote><pre><ul><ol><li><table><caption><thead><tbody><tfoot><tr><th><td><h1><h2><h3><h4><h5><h6><a><span><br><hr><strong><b><em><i><del><strike><s><u>');

        // Добавляем необходимые элеметы в правильном порядке
        $text = '<!DOCTYPE html><html><head></head><body>' . $text . '</body></html>';

        return $text;
    }

    /** Проверка электронной почты */
    public static function checkMX(string $email): bool
    {
        $domain = rtrim(substr($email, strpos($email, '@') + 1), "> \t\n\r\0\x0B");

        if (empty($domain)) { return false; }

        if (
            // Исключение в доменах
            in_array($domain, [
                // Наши домены
                'qs.local', 'qt.local', 'qskills.local', 'quicktickets.ru',
                // Другие домены
                'edu.tgl.ru',
            ])
        ) { return true; }

        $domain_levels = array_reverse(explode('.', $domain));
        if (count($domain_levels) < 2) { return false; }
        if (function_exists('checkdnsrr')) {
            if (checkdnsrr($domain, 'MX')) { return true; }
            if (count($domain_levels) > 2) {
                $domain = implode('.', [$domain_levels[0],$domain_levels[1]]);
                return checkdnsrr($domain, 'MX');
            }
        }

        return true;
    }
}