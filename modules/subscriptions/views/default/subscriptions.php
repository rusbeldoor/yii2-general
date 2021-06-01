<?php
/* @var yii\web\View $this */
/* @var int $userId */
/* @var array $result */

use yii\bootstrap4\Html;
use rusbeldoor\yii2General\helpers\UserSubscriptionHelper;

$this->registerCss(
'.card .card-body .channels {
    margin-bottom: 5px;
}

.card .card-body .channels form + form {
    margin-top: 5px;
}'
);
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

if (!count($result)) { echo '<p>У Вас нет указанных подписок на рассылки.</p>'; }
else {
    foreach ($result as $subscript) {
        ?><div class="card" style="float: left; margin: 0 10px 10px 0;">
        <div class="card-body">
            <h5 class="card-title"><?= $subscript['name'] ?></h5><?
            foreach ($subscript['actions'] as $action) {
                echo '<h6>' . $action['name'] . '</h6>';

                $buttons = [];
                foreach ($action['channels'] as $channel) {
                    $channelIcon = UserSubscriptionHelper::channelIcon($channel['alias']);
                    $buttons[] =
                        Html::beginForm('/subscriptions/default/change', 'post')
                            . Html::input('hidden', 'userId', $userId)
                            . Html::input('hidden', 'subscriptId', $subscript['id'])
                            . Html::input('hidden', 'actionId', $action['id'])
                            . Html::input('hidden', 'channelId', $channel['id'])
                            . Html::input('hidden', 'hash', UserSubscriptionHelper::hash($userId, '', '', $subscript['id'], $action['id'], $channel['id']))
                            . Html::input('hidden', 'active', (($channel['active']) ? '0' : '1'))
                            . Html::input('hidden', 'redirectUrl', Yii::$app->request->url)
                        . '<button type="button" class="btn btn-' . (($channel['active']) ? 'light unsubscribe' : 'primary subscribe') . ' " data-key-name="' . $subscript['name'] . '" data-channel-name="' . $channel['name'] . '">' . (($channelIcon) ? $channelIcon . '&nbsp;' : '') . ' ' . $channel['name'] . ' — ' . (($channel['active']) ? 'отписаться' : 'подписаться') . '</button>'
                        . Html::endForm();
                }
                echo '<div class="channels" style="">' . implode('', $buttons) . '</div>';
            }
            ?></div>
        </div><?
    }
}
?>