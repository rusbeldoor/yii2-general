<?php

class EmailCatalog
{
    // Корректные
    public static $validDomain = [];

    // Некорректные, но узнаваемые
    public static $invalidDomain = [
        // yandex.ru, yandex.com
        'yandexru' => 'yandex.ru',
        'yandexcom' => 'yandex.com',
        'jandex.ru' => 'yandex.ru',
        'jandex.com' => 'yandex.com',
        'eandex.ru' => 'yandex.ru',
        'yndekx.ru' => 'yandex.ru',
        'aandex.ru' => 'yandex.ru',
        'yandeks.ru' => 'yandex.ru',
        'yanbex.ru' => 'yandex.ru',
        'yanlex.ru' => 'yandex.ru',
        'yavdex.ru' => 'yandex.ru',
        'yundex.ru' => 'yandex.ru',
        'yangex.ru' => 'yandex.ru',
        'uandex.ru' => 'yandex.ru',
        'yandech.ru' => 'yandex.ru',
        'ygoandex.ru' => 'yandex.ru',
        'yande.dru' => 'yandex.ru',
        'usndex.ru' => 'yandex.ru',
        'yfndex.ru' => 'yandex.ru',
        'efndtx.ru' => 'yandex.ru',
        'efndex.ru' => 'yandex.ru',
        'iandex.ru' => 'yandex.ru',
        'yindex.ru' => 'yandex.ru',
        'yandex.read' => 'yandex.ru',
        'yandtx.ru' => 'yandex.ru',
        'yandex.rucom' => 'yandex.ru',
        'yandex.ruyandex.ru' => 'yandex.ru',
        'yandex.comyandex.com' => 'yandex.com',
        'yandwex.ru' => 'yandex.ru',
        'yandwex.com' => 'yandex.com',
        'uyandex.ru' => 'yandex.ru',
        'uyandex.com' => 'yandex.com',
        'yanhdex.ru' => 'yandex.ru',
        'yanhdex.com' => 'yandex.com',
        'yaundex.ru' => 'yandex.ru',
        'yaundex.com' => 'yandex.com',
        'ayandex.ru' => 'yandex.ru',
        'ayandex.com' => 'yandex.com',
        'yandexl.ru' => 'yandex.ru',
        'yandexl.com' => 'yandex.com',
        'yaqndex.ru' => 'yandex.ru',
        'yaqndex.com' => 'yandex.com',
        'yeandex.ru' => 'yandex.ru',
        'yeandex.com' => 'yandex.com',
        'yandekx.ru' => 'yandex.ru',
        'yandekx.com' => 'yandex.com',
        'yaandex.ru' => 'yandex.ru',
        'yaandex.com' => 'yandex.com',
        'yandexc.ru' => 'yandex.ru',
        'yandexc.com' => 'yandex.com',
        'yande.xru' => 'yandex.ru',
        'yande.xcom' => 'yandex.com',
        'ayndex.ru' => 'yandex.ru',
        'ayndex.com' => 'yandex.com',
        'yadnex.ru' => 'yandex.ru',
        'yadnex.com' => 'yandex.com',
        'tandex.ru' => 'yandex.ru',
        'tandex.com' => 'yandex.com',
        'yanded.ru' => 'yandex.ru',
        'yanded.com' => 'yandex.com',
        'yandrx.ru' => 'yandex.ru',
        'yandrx.com' => 'yandex.com',
        'ysndex.ru' => 'yandex.ru',
        'ysndex.com' => 'yandex.com',
        'yanfex.ru' => 'yandex.ru',
        'yanfex.com' => 'yandex.com',
        'yahdex.ru' => 'yandex.ru',
        'yahdex.com' => 'yandex.com',
        'yabdex.ru' => 'yandex.ru',
        'yabdex.com' => 'yandex.com',
        'yansex.ru' => 'yandex.ru',
        'yansex.com' => 'yandex.com',
        'yanrex.ru' => 'yandex.ru',
        'yanrex.com' => 'yandex.com',
        'yndekc.ru' => 'yandex.ru',
        'yndekc.com' => 'yandex.com',
        'gandex.ru' => 'yandex.ru',
        'gandex.com' => 'yandex.com',
        'yandex.eu' => 'yandex.ru',
        'andex.ru' => 'yandex.ru',
        'andex.com' => 'yandex.com',
        'yndex.ru' => 'yandex.ru',
        'yndex.com' => 'yandex.com',
        'yadex.ru' => 'yandex.ru',
        'yadex.com' => 'yandex.com',
        'yanex.ru' => 'yandex.ru',
        'yanex.com' => 'yandex.com',
        'yandx.ru' => 'yandex.ru',
        'yandx.com' => 'yandex.com',
        'yande.ru' => 'yandex.ru',
        'yande.com' => 'yandex.com',
        'yandex.u' => 'yandex.ru',
        'yandex.r' => 'yandex.ru',
        'yandex.om' => 'yandex.com',
        'yandex.cm' => 'yandex.com',
        'yandex.co' => 'yandex.com',
        'yandex.c' => 'yandex.com',
        'yandex.o' => 'yandex.com',
        'yandex.m' => 'yandex.com',
        'yanndex.ru' => 'yandex.ru',
        'xn--ngex-u6d.ru' => 'yandex.ru',
        'xn--ngex-u6d.com' => 'yandex.com',
        'xn--yndex-4ve.ru' => 'yandex.ru',
        'xn--yndex-4ve.com' => 'yandex.com',
        'xn--andex-dze.ru' => 'yandex.ru',
        'xn--andex-dze.com' => 'yandex.com',
        // rambler.ru
        'ramdlerru' => 'rambler.ru',
        'ramdler.ru' => 'rambler.ru',
        'rumbler.ru' => 'rambler.ru',
        'ra.bler.ru' => 'rambler.ru',
        'rfmbler.ru' => 'rambler.ru',
        'ranibler.ru' => 'rambler.ru',
        'rambler.com' => 'rambler.ru',
        'rambler.comru' => 'rambler.ru',
        'rambler.rucom' => 'rambler.ru',
        'rambler.rurambler.ru',
        'ramblerl.ru' => 'rambler.ru',
        'ramble.rru' => 'rambler.ru',
        'tambler.ru' => 'rambler.ru',
        'rambier.ru' => 'rambler.ru',
        'ramblee.ru' => 'rambler.ru',
        'rzmbler.ru' => 'rambler.ru',
        'rzmbler.u' => 'rambler.ru',
        'rzmbler.r' => 'rambler.ru',
        'ambler.ru' => 'rambler.ru',
        'rmbler.ru' => 'rambler.ru',
        'rabler.ru' => 'rambler.ru',
        'ramler.ru' => 'rambler.ru',
        'ramber.ru' => 'rambler.ru',
        'ramblr.ru' => 'rambler.ru',
        'ramble.ru' => 'rambler.ru',
        'rambler.u' => 'rambler.ru',
        'rambler.r' => 'rambler.ru',
        'rambler.' => 'rambler.ru',
        'rambler' => 'rambler.ru',
        'ramble' => 'rambler.ru',
        // outlook.com
        'outlook.ru' => 'outlook.com',
        'outlook.comoutlook.com' => 'outlook.com',
        'outlook.ruoutlook.ru' => 'outlook.com',
        'outloook.com' => 'outlook.com',
        'outlooook.com' => 'outlook.com',
        'outloo.kcom' => 'outlook.com',
        'iutlook.com' => 'outlook.com',
        'outiook.com' => 'outlook.com',
        'utlook.com' => 'outlook.com',
        'otlook.com' => 'outlook.com',
        'oulook.com' => 'outlook.com',
        'outook.com' => 'outlook.com',
        'outlok.com' => 'outlook.com',
        'outloo.com' => 'outlook.com',
        'outlook.om' => 'outlook.com',
        'outlook.cm' => 'outlook.com',
        'outlook.co' => 'outlook.com',
        'outlook.c' => 'outlook.com',
        'outlook.o' => 'outlook.com',
        'outlook.m' => 'outlook.com',
        // hotmail.com
        'hotmail.comhotmail.com' => 'hotmail.com',
        'hotmail.ruhotmail.ru' => 'hotmail.com',
        'hotmails.com' => 'hotmail.com',
        'hotmai.lcom' => 'hotmail.com',
        'hormail.com' => 'hotmail.com',
        'otmail.com' => 'hotmail.com',
        'htmail.com' => 'hotmail.com',
        'homail.com' => 'hotmail.com',
        'hotail.com' => 'hotmail.com',
        'hotmil.com' => 'hotmail.com',
        'hotmal.com' => 'hotmail.com',
        'hotmai.com' => 'hotmail.com',
        'hotmail.om' => 'hotmail.com',
        'hotmail.cm' => 'hotmail.com',
        'hotmail.co' => 'hotmail.com',
        'hotmail.c' => 'hotmail.com',
        'hotmail.o' => 'hotmail.com',
        'hotmail.m' => 'hotmail.com',
        // yahoo.com
        'yahoocom' => 'yahoo.com',
        'yahoo.comyahoo.com' => 'yahoo.com',
        'yahooo.com' => 'yahoo.com',
        'yahoooo.com' => 'yahoo.com',
        'yaho.ocom' => 'yahoo.com',
        'yahoi.com' => 'yahoo.com',
        'ahoo.com' => 'yahoo.com',
        'yhoo.com' => 'yahoo.com',
        'yaoo.com' => 'yahoo.com',
        'yaho.com' => 'yahoo.com',
        'yahoo.om' => 'yahoo.com',
        'yahoo.cm' => 'yahoo.com',
        'yahoo.co' => 'yahoo.com',
        'yahoo.c' => 'yahoo.com',
        'yahoo.o' => 'yahoo.com',
        'yahoo.m' => 'yahoo.com',
        // icloud.com
        'iclaudcom' => 'icloud.com',
        'iclaud.com' => 'icloud.com',
        'iclond.com' => 'icloud.com',
        'iciaud.com' => 'icloud.com',
        'icloud.ru' => 'icloud.com',
        'icloud.comru' => 'icloud.com',
        'icloud.rucom' => 'icloud.com',
        'icloud.comicloud.com' => 'icloud.com',
        'icloud.ruicloud.ru' => 'icloud.com',
        'iicloud.com' => 'icloud.com',
        'iclloud.com' => 'icloud.com',
        'iiclloud.com' => 'icloud.com',
        'iclou.dcom' => 'icloud.com',
        'lcloud.com' => 'icloud.com',
        'icliud.com' => 'icloud.com',
        'ocloud.com' => 'icloud.com',
        'cloud.com' => 'icloud.com',
        'iloud.com' => 'icloud.com',
        'icoud.com' => 'icloud.com',
        'iclud.com' => 'icloud.com',
        'iclod.com' => 'icloud.com',
        'iclou.com' => 'icloud.com',
        'icloud.om' => 'icloud.com',
        'icloud.cm' => 'icloud.com',
        'icloud.co' => 'icloud.com',
        'icloud.c' => 'icloud.com',
        'icloud.o' => 'icloud.com',
        'icloud.m' => 'icloud.com',
        'icloyd.com' => 'icloud.com',
        // gmail.com
        'gmeilcom' => 'gmail.com',
        'gmeil.com' => 'gmail.com',
        'qmail.com' => 'gmail.com',
        'gimail.com' => 'gmail.com',
        'jmail.com' => 'gmail.com',
        'cmail.com' => 'gmail.com',
        'gmale.com' => 'gmail.com',
        'dgail.com' => 'gmail.com',
        'gmfil.com' => 'gmail.com',
        'gmal.ru' => 'gmail.com',
        'gmai.ru' => 'gmail.com',
        'gmsil.ru' => 'gmail.com',
        'gmaii.ru' => 'gmail.com',
        'gmail.ru' => 'gmail.com',
        'gmail.rcom' => 'gmail.com',
        'gmail.comru' => 'gmail.com',
        'gmail.rucom' => 'gmail.com',
        'gmail.com.ru' => 'gmail.com',
        'gmail.comgmail.com' => 'gmail.com',
        'gmail.rugmail.ru' => 'gmail.com',
        'fgmail.com' => 'gmail.com',
        'gmaiil.ru' => 'gmail.com',
        'gmaill.ru' => 'gmail.com',
        'zgmail.com' => 'gmail.com',
        'g.mail.com' => 'gmail.com',
        'gemail.com' => 'gmail.com',
        'gmali.com' => 'gmail.com',
        'gmai.lcom' => 'gmail.com',
        'gmsil.com' => 'gmail.com',
        'gnail.com' => 'gmail.com',
        'qmajl.com' => 'gmail.com',
        'gmaii.com' => 'gmail.com',
        'gmaik.com' => 'gmail.com',
        'gmall.com' => 'gmail.com',
        'gmayl.com' => 'gmail.com',
        'gmhil.com' => 'gmail.com',
        'dmail.com' => 'gmail.com',
        'gmel.com' => 'gmail.com',
        'kgmail.com' => 'gmail.com',
        'mail.com' => 'gmail.com',
        'gail.com' => 'gmail.com',
        'gmil.com' => 'gmail.com',
        'gmal.com' => 'gmail.com',
        'gmai.com' => 'gmail.com',
        'gmail.om' => 'gmail.com',
        'gmail.cm' => 'gmail.com',
        'gmail.co' => 'gmail.com',
        'gmail.c' => 'gmail.com',
        'gmail.o' => 'gmail.com',
        'gmail.m' => 'gmail.com',
        'gmli.com' => 'gmail.com',
        // mail.ru, inbox.ru, list.ru, bk.ru
        'mailru' => 'mail.ru',
        'meil.ru' => 'mail.ru',
        'main.ru' => 'mail.ru',
        'mai.l' => 'mail.ru',
        'mail.lu' => 'mail.ru',
        'mail.bk' => 'mail.ru',
        'mail.mail' => 'mail.ru',
        'mail.comru' => 'mail.ru',
        'mail.rucom' => 'mail.ru',
        'mail.rumail.ru' => 'mail.ru',
        'inboxru' => 'inbox.ru',
        'inboks.ru' => 'inbox.ru',
        'indox.ru' => 'inbox.ru',
        'innox.ru' => 'inbox.ru',
        'inbox.comru' => 'inbox.ru',
        'inbox.rucom' => 'inbox.ru',
        'inbox.ruinbox.ru' => 'inbox.ru',
        'listru' => 'list.ru',
        'list.com' => 'list.ru',
        'list.rulist.ru' => 'list.ru',
        'bkru' => 'bk.ru',
        'bk.bk' => 'bk.ru',
        'bk.mail' => 'bk.ru',
        'bk.comru' => 'bk.ru',
        'bk.rucom' => 'bk.ru',
        'bk.rubk.ru' => 'bk.ru',
        'maill.ru' => 'mail.ru',
        'maiil.ru' => 'mail.ru',
        'maiill.ru' => 'mail.ru',
        'mnail.ru' => 'mail.ru',
        'mmail.ru' => 'mail.ru',
        'lilst.ru' => 'list.ru',
        'liist.ru' => 'list.ru',
        'llist.ru' => 'list.ru',
        'lliist.ru' => 'list.ru',
        'mali.ru' => 'mail.ru',
        'mai.lru' => 'mail.ru',
        'inbo.xru' => 'inbox.ru',
        'lis.tru' => 'list.ru',
        'b.kru' => 'bk.ru',
        'majl.ru' => 'mail.ru',
        'maul.ru' => 'mail.ru',
        'maij.ru' => 'mail.ru',
        'nail.ru' => 'mail.ru',
        'msil.ru' => 'mail.ru',
        'maik.ru' => 'mail.ru',
        'maii.ru' => 'mail.ru',
        'mail41.ru' => 'mail.ru',
        'ihbox.ru' => 'inbox.ru',
        'invox.ru' => 'inbox.ru',
        'inb0x.ru' => 'inbox.ru',
        'inbex.ru' => 'inbox.ru',
        'lust.ru' => 'list.ru',
        'bj.ru' => 'bk.ru',
        'ail.ru' => 'mail.ru',
        'mil.ru' => 'mail.ru',
        'mal.ru' => 'mail.ru',
        'mai.ru' => 'mail.ru',
        'mail.u' => 'mail.ru',
        'mail.r' => 'mail.ru',
        'nbox.ru' => 'inbox.ru',
        'ibox.ru' => 'inbox.ru',
        'inox.ru' => 'inbox.ru',
        'inbx.ru' => 'inbox.ru',
        'inbo.ru' => 'inbox.ru',
        'inbox.u' => 'inbox.ru',
        'inbox.r' => 'inbox.ru',
        'inbox.' => 'inbox.ru',
        'inbox' => 'inbox.ru',
        'ist.ru' => 'list.ru',
        'lst.ru' => 'list.ru',
        'lit.ru' => 'list.ru',
        'lis.ru' => 'list.ru',
        'list.u' => 'list.ru',
        'list.r' => 'list.ru',
        'k.ru' => 'bk.ru',
        'b.ru' => 'bk.ru',
        'bk.u' => 'bk.ru',
        'bk.r' => 'bk.ru',
        // sberbank.ru
        'sberbnk.ru' => 'sberbank.ru',
    ];
}