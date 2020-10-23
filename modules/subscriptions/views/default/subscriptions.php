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
                    $iconClass = null;
                    switch ($channel['alias']) {
                        case 'email': $iconClass = 'fas fa-envelope'; break;
                        case 'sms': $iconClass = 'fas fa-sms'; break;
                        case 'vkontakte': $iconClass = 'fab fa-vk'; break;
                        case 'odnoklassniki': $iconClass = 'fab fa-odnoklassniki'; break;
                        case 'facebook': $iconClass = 'fab fa-facebook-f'; break;
                        case 'instagram': $iconClass = 'fab fa-instagram'; break;
                        case 'whatsapp': $iconClass = 'fab fa-whatsapp'; break;
                        case 'viber': $iconClass = 'fab fa-viber'; break;
                        case 'telegram': $iconClass = 'fab fa-telegram'; break;
                        case 'browser': $iconClass = 'far fa-comment-alt'; break;
                        default:
                    }
                    ?><?= Html::beginForm('/subscriptions/default/' . (($channel['active']) ? 'unsubscribe' : 'subscribe'), 'post'); ?>
                        <?= Html::input('hidden', 'userId', $userId) ?>
                        <?= Html::input('hidden', 'keyAlias', $key['alias']) ?>
                        <?= Html::input('hidden', 'channelAlias', $channel['alias']) ?>
                        <?= Html::input('hidden', 'hash', SubscriptionHelper::hash($userId, $key['alias'], $channel['alias'])) ?>
                        <?= Html::input('hidden', 'redirectUrl', Yii::$app->request->url) ?>
                        <button type="button" class="btn btn-<?= (($channel['active']) ? 'light' : 'primary') ?> unsubscribe subscribe"><?= (($iconClass) ? '<i class="' . $iconClass . '"></i>&nbsp;' : '') ?> <?= (($channel['active']) ? 'Отписаться' : 'Подписаться') ?> от рассылки по "<?= $channel['name'] ?>"</button>
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
            text: \'Вы уверены, что хотите отписаться?\',
            confirmCallback: () => { $(this).parent(\'form\').submit(); }
        });
    });
    $(\'.subscribe\').click(function () { $(this).parent(\'form\').submit(); });
});'
);
?>

<p><a href="<?= SubscriptionHelper::link($userId) ?>">Другие подписки</a></p>
<?
if (count($result)) { writeElems($result, $userId); }
else { echo '<p>Вы больше не подписаны на указанную рассылку.</p>'; }
?>