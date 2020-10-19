<?php
/* @var $this yii\web\View */
/* @var $userId int */
/* @var $result array */

use yii\bootstrap4\Html;

use rusbeldoor\yii2General\helpers\SubscriptionHelper;

/**
 * Вывод элементов
 *
 * @param $elems array
 * @param $userId int
 */
function writeElems($elems, $userId) {
    foreach ($elems as $key) {
        foreach ($key['channels'] as $channel) {
            ?><div class="card" style="float: left; margin: 0 10px 10px 0;">
            <div class="card-body">
                <h5 class="card-title"><?= $key['name'] ?></h5>
                <p class="card-text"><?= $channel['name'] ?></p>
                <?= Html::beginForm('/subscriptions/default/unsubscribe', 'post'); ?>
                    <?= Html::input('hidden', 'userId', $userId) ?>
                    <?= Html::input('hidden', 'keyAlias', $key['alias']) ?>
                    <?= Html::input('hidden', 'channelAlias', $channel['alias']) ?>
                    <?= Html::input('hidden', 'hash', SubscriptionHelper::hash($userId, $key['alias'], $channel['alias'])) ?>
                    <?= Html::input('hidden', 'redirectUrl', Yii::$app->request->url) ?>
                    <button type="button" class="btn btn-primary unsubscribe">Отписаться</button>
                <?= Html::endForm(); ?>
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

<p><a href="<?= SubscriptionHelper::link($userId) ?>">Другие подписки</a></p>
<?
if (count($result)) { writeElems($result, $userId); }
else { echo '<p>Вы больше не подписаны на указанную рассылку.</p>'; }
?>