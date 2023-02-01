<?php
/**
 * @var yii\web\View $this
 * @var int $userId
 * @var array $result
 */

use rusbeldoor\yii2General\helpers\HtmlHelper;
use rusbeldoor\yii2General\helpers\UserSubscriptionHelper;

$this->title = 'Подписки';

$this->registerCss(<<< CSS
.card { margin: 0 10px 10px 0; }
.card .card-body .title { }
.card .card-body .title button { font-size: 20px; }
.card .card-body .subtitle { margin-top: 10px; font-size: 20px; }
.card .card-body .channels { margin-bottom: 5px; }
.card .card-body .channels form + form { margin-top: 5px; }
CSS);

$this->registerJs(<<< JS
$(document).ready(function () {
    $('.unsubscribeAll').click(function () {
        confirmDialog({
            text: 'Вы уверены, что хотите убрать рассылку от "' + $(this).data('sender-name') + '"? <i class="far fa-frown"></i>',
            confirmCallback: () => { $(this).closest('form').submit(); }
        });
    });
    $('.unsubscribe').click(function () {
        confirmDialog({
            text: 'Вы уверены, что хотите убрать рассылку от "' + $(this).data('sender-name') + '" на "' + $(this).data('action-name') + '" (' + $(this).data('channel-name') + ')? <i class="far fa-frown"></i>',
            confirmCallback: () => { $(this).closest('form').submit(); }
        });
    });
    $('.subscribeAll').click(function () { $(this).closest('form').submit(); });
    $('.subscribe').click(function () { $(this).closest('form').submit(); });
});
JS);

if (!count($result)) { echo '<p>У Вас нет указанных подписок на рассылки.</p>'; }
else {
    foreach ($result as $subscription) {
        $titleButton = $subscription['name'];
        if ($subscription['active']) {
            $titleButton =
                '<button'
                    . ' type="button"'
                    . ' class="btn btn-' . (($subscription['active']) ? 'light unsubscribeAll' : 'primary subscribeAll') . '"'
                    . ' data-sender-name="' . $subscription['name'] . '"'
                . ' >' . $subscription['name'] . ' — ' . (($subscription['active']) ? 'отписаться от всего' : 'подписаться') . '</button>';
        }
        ?><div class="card">
        <div class="card-body">
            <div class="title">
                <?= HtmlHelper::beginForm('/subscriptions/default/change-all', 'post') ?>
                <?= HtmlHelper::input('hidden', 'userId', $userId) ?>
                <?= HtmlHelper::input('hidden', 'subscriptionId', $subscription['id']) ?>
                <?= HtmlHelper::input('hidden', 'hash', UserSubscriptionHelper::hash($userId, '', '', $subscription['id'])) ?>
                <?= HtmlHelper::input('hidden', 'action', (($subscription['active']) ? 'deactivate' : 'activate')) ?>
                <?= HtmlHelper::input('hidden', 'redirectUrl', Yii::$app->request->url) ?>
                <?= $titleButton ?>
                <?= HtmlHelper::endForm(); ?>
            </div>
            <?
            foreach ($subscription['actions'] as $action) {
                if (!$subscription['active']) { continue; }

                echo '<div class="subtitle">' . $action['name'] . '</div>';

                $buttons = [];
                foreach ($action['channels'] as $channel) {
                    $channelIcon = UserSubscriptionHelper::channelIcon($channel['alias']);
                    $buttons[] =
                        HtmlHelper::beginForm('/subscriptions/default/change', 'post')
                        . HtmlHelper::input('hidden', 'userId', $userId)
                        . HtmlHelper::input('hidden', 'subscriptionId', $subscription['id'])
                        . HtmlHelper::input('hidden', 'actionId', $action['id'])
                        . HtmlHelper::input('hidden', 'channelId', $channel['id'])
                        . HtmlHelper::input('hidden', 'hash', UserSubscriptionHelper::hash($userId, '', '', $subscription['id'], $action['id'], $channel['id']))
                        . HtmlHelper::input('hidden', 'action', (($channel['active']) ? 'deactivate' : 'activate'))
                        . HtmlHelper::input('hidden', 'redirectUrl', Yii::$app->request->url)
                        . '<button 
                            type="button" 
                            class="btn btn-' . (($channel['active']) ? 'light unsubscribe' : 'primary subscribe') . '" 
                            data-sender-name="' . $subscription['name'] . '" 
                            data-action-name="' . $action['name'] . '" 
                            data-channel-name="' . $channel['name'] . '"
                        >' . (($channelIcon) ? $channelIcon . '&nbsp;' : '') . ' ' . $channel['name'] . ' — ' . (($channel['active']) ? 'отписаться' : 'подписаться') . '</button>'
                        . HtmlHelper::endForm();
                }
                echo '<div class="channels">' . implode('', $buttons) . '</div>';
            }
            ?></div>
        </div><?
    }
}
?>