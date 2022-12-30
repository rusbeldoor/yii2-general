<?php
/**
 * @var yii\web\View $this
 * @var int $userId
 * @var array $result
 */

use rusbeldoor\yii2General\helpers\HtmlHelper;
use rusbeldoor\yii2General\helpers\UserSubscriptionHelper;

$this->title = 'Подписки';

$this->registerCss(
    '.card { margin: 0 10px 10px 0; }
.card .card-body .channels { margin-bottom: 5px; }
.card .card-body .channels form + form { margin-top: 5px; }'
);
$this->registerJs(
    '$(document).ready(function () {
    $(\'.unsubscribe\').click(function () {
        confirmDialog({
            text: \'Вы уверены, что хотите убрать рассылку от "\' + $(this).data(\'sender-name\') + \'" на "\' + $(this).data(\'action-name\') + \'" (\' + $(this).data(\'channel-name\') + \')? <i class="far fa-frown"></i>\',
            confirmCallback: () => { $(this).closest(\'form\').submit(); }
        });
    });
    $(\'.subscribe\').click(function () { $(this).closest(\'form\').submit(); });
});'
);

if (!count($result)) { echo '<p>У Вас нет указанных подписок на рассылки.</p>'; }
else {
    foreach ($result as $subscript) {
        ?><div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $subscript['name'] ?></h5><?
            foreach ($subscript['actions'] as $action) {
                echo '<h6>' . $action['name'] . '</h6>';

                $buttons = [];
                foreach ($action['channels'] as $channel) {
                    $channelIcon = UserSubscriptionHelper::channelIcon($channel['alias']);
                    $buttons[] =
                        HtmlHelper::beginForm('/subscriptions/default/change', 'post')
                        . HtmlHelper::input('hidden', 'userId', $userId)
                        . HtmlHelper::input('hidden', 'subscriptId', $subscript['id'])
                        . HtmlHelper::input('hidden', 'actionId', $action['id'])
                        . HtmlHelper::input('hidden', 'channelId', $channel['id'])
                        . HtmlHelper::input('hidden', 'hash', UserSubscriptionHelper::hash($userId, '', '', $subscript['id'], $action['id'], $channel['id']))
                        . HtmlHelper::input('hidden', 'action', (($channel['active']) ? 'activate' : 'deactivate'))
                        . HtmlHelper::input('hidden', 'redirectUrl', Yii::$app->request->url)
                        . '<button type="button" class="btn btn-' . (($channel['active']) ? 'light unsubscribe' : 'primary subscribe') . ' " data-sender-name="' . $subscript['name'] . '" data-action-name="' . $action['name'] . '" data-channel-name="' . $channel['name'] . '">' . (($channelIcon) ? $channelIcon . '&nbsp;' : '') . ' ' . $channel['name'] . ' — ' . (($channel['active']) ? 'отписаться' : 'подписаться') . '</button>'
                        . HtmlHelper::endForm();
                }
                echo '<div class="channels">' . implode('', $buttons) . '</div>';
            }
            ?></div>
        </div><?
    }
}
?>