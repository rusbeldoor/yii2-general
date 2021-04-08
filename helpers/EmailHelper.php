<?php

namespace rusbeldoor\yii2General\helpers;

class EmailHelper
{
    /**
     * Коррекция электронной почты
     *
     * @param string $email
     * @return string
     */
    public static function correct($email)
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
            $arrayEmail[1] = preg_replace('/\.(kom|con|c\.com|vom|com\.m|cim|cjm|ccom|сom|соm|сом|cоm|cом|coм)$/', '.com', $arrayEmail[1]);

            // Убираем лишине символы после самого верхнего домена
            // .ru# на .ru, .coma на .com
            $arrayEmail[1] = preg_replace('/\.(com|net|org|ru)[^\.]+$/', '.$1', $arrayEmail[1]);

            // Повторение домена верхнего уровня
            // .ru.ru на .ru, .com.com на .com и т.д.
            $arrayEmail[1] = preg_replace('/(\.com){2,}$/', '$1', $arrayEmail[1]); // Исправляем .com.com на .com
            $arrayEmail[1] = preg_replace('/(\.net){2,}$/', '$1', $arrayEmail[1]); // Исправляем .net.net на .net
            $arrayEmail[1] = preg_replace('/(\.org){2,}$/', '$1', $arrayEmail[1]); // Исправляем .org.org на .org
            $arrayEmail[1] = preg_replace('/(\.ru){2,}$/', '$1', $arrayEmail[1]); // Исправляем .ru.ru на .ru

            // Замена Punycode на латиницу


            // Массив возможных почт, которые подразумивают искомую почту
            // Внимание! Перед добавлением удостовериться, что такого случая ещё нет
            $filterArray = [
                'rambler.ru' => [
                    'ramdler.ru', 'rabler.ru', 'ramber.ru', 'ramler.ru', 'tambler.ru', 'rambier.ru', 'rambler.comru',
                    'rambler.rucom', 'ramble.ru', 'ramblerl.ru', 'rumbler.ru', 'ra.bler.ru',
                    'rambler.rurambler.ru',
                ],
                'outlook.com' => [
                    'outlook.ru', 'iutlook.com', 'outiook.com',
                    'outlook.comoutlook.com', 'outlook.ruoutlook.ru'
                ],
                'hotmail.com' => [
                    'hotmails.com', 'hotmal.com', 'hormail.com',
                    'hotmail.comhotmail.com', 'hotmail.ruhotmail.ru',
                ],
                'yandex.ru' => [
                    'yndex.ru', 'jandex.ru', 'yadex.ru', 'eandex.ru', 'yande.ru', 'yndekx.ru', 'aandex.ru', 'andex.ru',
                    'tandex.ru', 'yanex.ru', 'yanded.ru', 'yandeks.ru', 'yandwex.ru', 'yanbex.ru', 'yanlex.ru',
                    'yandrx.ru', 'ysndex.ru', 'yandrx.ru', 'ysndex.ru', 'yavdex.ru', 'yanfex.ru', 'yandex.eu',
                    'yandex.rucom', 'yahdex.ru', 'ayndex.ru', 'yundex.ru', 'yandx.ru', 'yangex.ru', 'uandex.ru',
                    'uyandex.ru', 'yandech.ru', 'ygoandex.ru', 'yande.dru', 'yabdex.ru', 'yansex.ru', 'usndex.ru',
                    'yanhdex.ru', 'yanrex.ru', 'yaundex.ru', 'yfndex.ru', 'efndtx.ru', 'efndex.ru', 'yndekc.ru',
                    'iandex.ru', 'ayandex.ru', 'ayandex.ru', 'yindex.ru', 'yandexl.ru', 'yandex.read', 'yaqndex.ru',
                    'gandex.ru',
                    'yandex.ruyandex.ru',
                    'xn--ngex-u6d.ru', 'xn--yndex-4ve.ru', 'xn--andex-dze.ru',
                ],
                'yandex.com' => [
                    'jandex.com', 'yandex.comru',
                    'yandex.comyandex.com',
                ],
                'yahoo.com' => [
                    'yahoi.com', 'yahoo.co',
                    'yahoo.comyahoo.com',
                ],
                'icloud.com' => [
                    'icoud.com', 'icloud.comru', 'icloud.rucom', 'icloud.ru', 'iclond.com', 'iciaud.com', 'lcloud.com',
                    'icliud.com',
                    'icloud.comicloud.com', 'icloud.ruicloud.ru',
                ],
                'gmail.com' => [
                    'gmal.com',  'gmeil.com', 'gmai.com', 'gmsil.com', 'qmail.com', 'gimail.com', 'gnail.com',
                    'jmail.com', 'cmail.com', 'gmail.ru', 'gmail.co', 'gmail.rcom', 'gmal.ru', 'gmail.comru',
                    'gmail.rucom', 'gmale.com', 'qmajl.com', 'fgmail.com', 'gmaill.ru', 'zgmail.com', 'g.mail.com',
                    'gmaii.ru', 'gmaii.com', 'gmali.com', 'gemail.com', 'dgail.com', 'gmfil.com', 'gmaik.com',
                    'gmail.c', 'gmail.com.ru', 'gmfil.com',
                    'gmail.comgmail.com', 'gmail.rugmail.ru',
                ],
                'inbox.ru' => [
                    'ihbox.ru', 'invox.ru', 'indox.ru', 'ibox.ru', 'inbox.comru', 'inbox.rucom', 'inboks.ru',
                    'inb0x.ru', 'innox.ru',
                    'inbox.ruinbox.ru',
                ],
                'mail.ru' => [
                    'mail.lu', 'mal.ru', 'majl.ru', 'maul.ru', 'meil.ru', 'maij.ru', 'main.ru', 'maill.ru', 'mali.ru',
                    'mai.lru', 'mail.comru', 'mail.rucom', 'nail.ru', 'msil.ru', 'maik.ru', 'mail.bk', 'mnail.ru',
                    'mail.mail', 'mai.l',
                    'mail.rumail.ru',
                ],
                'list.ru' => [
                    'lis.tru', 'lust.ru', 'lilst.ru', 'list.com', 'liist.ru', 'liist.ru',
                    'list.rulist.ru',
                ],
                'bk.ru' => [
                    'bk.mail', 'bk.comru', 'bk.rucom', 'bj.ru', 'bk.bk',
                    'bk.rubk.ru',
                ],
            ];

            foreach ($filterArray as $email => $filter) {
                $filter = str_replace('.', '\.', $filter);
                $arrayEmail[1] = preg_replace('/^(' . implode('|', $filter) . ')$/', $email, $arrayEmail[1]);
            }

            $email = implode('@', $arrayEmail);
        }

        // Яндекс
        $email = preg_replace('/^\+*(\d{10,13})\+*@(yandex|ya)\.(ru|by|kz|ua|com)$/', '$1@$2.$3', $email);

        return $email;
    }

    /**
     * Проверка электронной почты
     *
     * @param string $email
     * @return bool
     */
    public static function check($email)
    {
        return
            (bool)preg_match('/^([a-zA-Z0-9_]|([a-zA-Z0-9_]+[a-zA-Z0-9_\.-]*[a-zA-Z0-9_-]+))@(([a-zA-Z0-9]+[a-zA-Z0-9\.-]*[a-zA-Z0-9]+)\.)+[a-zA-Z]{2,16}$/', $email)
            && !preg_match('/\.\./', $email);
    }

    /**
     * Коррекция текста письма
     *
     * @param string $text
     * @return string
     */
    public static function correctText($text)
    {
        // Удаляем все теги кроме разрешенных
        // Важно! Если есть ошибки в написании тегов, то может удалиться лишнее
        $text = strip_tags($text, '<img><div><p><blockquote><pre><ul><ol><li><table><caption><thead><tbody><tfoot><tr><th><td><h1><h2><h3><h4><h5><h6><a><span><br><hr><strong><b><em><i><del><strike><s><u>');

        // Добавляем необходимые элеметы в правильном порядке
        $text = '<!DOCTYPE html><html><head></head><body>' . $text . '</body></html>';

        return $text;
    }

    /**
     * Проверка электронной почты
     *
     * @param string $email
     * @return bool
     */
    public static function checkMX($email)
    {
        $domain = rtrim(substr($email, strpos($email, '@') + 1), "> \t\n\r\0\x0B");
        if (empty($domain)) { return false; }
        if (in_array($domain, ['qs.local', 'qt.local', 'qskills.local', 'quicktickets.ru'])) { return true; }
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