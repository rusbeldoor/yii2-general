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
        if (count($key['channels'])) {
            ?><div class="card" style="float: left; margin: 0 10px 10px 0;">
            <div class="card-body">
                <h5 class="card-title"><?= $key['name'] ?></h5><?
                foreach ($key['channels'] as $channel) {
                    $channelIcon = SubscriptionHelper::channelIcon($channel['alias']);
                    ?><?= Html::beginForm('/subscriptions/default/change', 'post'); ?>
                        <?= Html::input('hidden', 'userId', $userId) ?>
                        <?= Html::input('hidden', 'keyAlias', $key['alias']) ?>
                        <?= Html::input('hidden', 'channelAlias', $channel['alias']) ?>
                        <?= Html::input('hidden', 'hash', SubscriptionHelper::hash($userId, $key['alias'], $channel['alias'])) ?>
                        <?= Html::input('hidden', 'active', (($channel['active']) ? '0' : '1')) ?>
                        <?= Html::input('hidden', 'redirectUrl', Yii::$app->request->url) ?>
                        <p><button type="button" class="btn btn-<?= (($channel['active']) ? 'light unsubscribe' : 'primary subscribe') ?> " data-key-name="<?= $key['name'] ?>" data-channel-name="<?= $channel['name'] ?>"><?= (($channelIcon) ? $channelIcon . '&nbsp;' : '') ?> <?= $channel['name'] ?> — <?= (($channel['active']) ? 'отписаться' : 'подписаться') ?></button></p>
                    <?= Html::endForm(); ?><?
                }
            ?></div>
            </div><?
        }

        if (count($key['childKeys'])) { writeElems($key['childKeys'], $userId); }
    }
}

$this->registerJs(
'$(document).ready(function () {
    $(\'.unsubscribe\').click(function () {
        confirmDialog({
            text: \'Вы уверены, что хотите отписаться от "\' + $(this).data(\'key-name\') + \'" (\' + $(this).data(\'channel-name\') + \')? <i class="far fa-frown"></i>\',
            confirmCallback: () => { $(this).closest(\'form\').submit(); }
        });
    });
    $(\'.subscribe\').click(function () { $(this).closest(\'form\').submit(); });
});'
);
?>

<p><a href="<?= SubscriptionHelper::link($userId) ?>">Другие подписки</a></p>
<?
if (count($result)) { writeElems($result, $userId); }
else { echo '<p>Вы больше не подписаны на указанную рассылку.</p>'; }
?>