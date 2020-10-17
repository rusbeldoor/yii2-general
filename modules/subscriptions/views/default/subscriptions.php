<?php
/* @var $this yii\web\View */
/* @var $result array */

/**
 * Вывод элементов
 *
 * @param $elems array
 */
function writeElems($elems) {
    foreach ($elems as $keyAlias => $elem) {
        foreach ($elem['channels'] as $chanelAlias => $channelName) {
            ?><div class="card" style="float: left; margin: 0 10px 10px 0;">
            <div class="card-body">
                <h5 class="card-title"><?= $elem['name'] ?></h5>
                <p class="card-text"><?= $channelName ?></p>
                <a href="#" class="btn btn-primary">Отписаться</a>
            </div>
            </div><?
        }
        if (count($elem['childKeys'])) { writeElems($elem['childKeys']); }
    }
}

$this->registerJs(
'$(document).ready(function () {
    $(\'.btn.btn-primary\').click(function () {
        confirmDialog({
            text: \'Вы уверены, что хотите отписаться?\',
            confirmCallback: () => {
                alert(123);
            }
        });
    });
});'
);
?>

<h1>Подписки на рассылки</h1>
<?
if (count($result)) { writeElems($result); }
else { echo 'У Вас нет ни одной подписки на рассылки.'; }
?>