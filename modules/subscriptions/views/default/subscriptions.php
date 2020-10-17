<?php
/* @var $this yii\web\View */
/* @var $userId int */
/* @var $result array */

/**
 * Вывод элементов
 *
 * @param $elems array
 * @param $userId int
 */
function writeElems($elems, $userId) {
    foreach ($elems as $key) {
        foreach ($key['channels'] as $channel) {
            $subscriptionHash = hash('sha256', $userId . $key['alias'] . $channel['alias']);
            $subscriptionHash = hash('sha256', $subscriptionHash . Yii::$app->controller->module->salt);
?><div class="card" style="float: left; margin: 0 10px 10px 0;">
<div class="card-body">
    <h5 class="card-title"><?= $key['name'] ?></h5>
    <p class="card-text"><?= $channel['name'] ?></p>
    <form action="/subscriptions/unsubscribe" method="post">
        <input type="hidden" name="userId" value="<?= $userId ?>">
        <input type="hidden" name="keyId" value="<?= $key['id'] ?>">
        <input type="hidden" name="channelId" value="<?= $channel['id'] ?>">
        <input type="hidden" name="hash" value="<?= $subscriptionHash ?>">
        <input type="hidden" name="redirectUrl" value="<?= Yii::$app->request->url ?>">
        <button type="button" class="btn btn-primary unsubscribe">Отписаться</button>
    </form>
</div>
</div><?
        }
        if (count($key['childKeys'])) { writeElems($key['childKeys'], $userId); }
    }
}

$this->registerJs(
'$(document).ready(function () {
    $(\'.unsubscribe\').click(function () {
        confirmDialog({
            text: \'Вы уверены, что хотите отписаться?\',
            confirmCallback: () => { $(this).parent(\'form\').submit(); }
        });
    });
});'
);
?>

<h1>Подписки на рассылки</h1>
<?
if (count($result)) { writeElems($result, $userId); }
else { echo 'У Вас нет ни одной подписки на рассылки.'; }
?>