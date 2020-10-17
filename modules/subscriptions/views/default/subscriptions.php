<?php
/* @var $this yii\web\View */
/* @var $result array */

function write($elems) {
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
        if (count($elem['childKeys'])) { write($elem['childKeys']); }
    }

}

if (count($result)) { echo '<div class="row">'; write($result); write($result); write($result); echo '</div>'; }
else { echo 'У Вас нет ни одной подписки на рассылки.'; }
?>


