<?php
/* @var $this yii\web\View */
/* @var $result array */

function write($elems) {
    foreach ($elems as $keyAlias => $elem) {
        echo '<li>';
        echo $elem['name'] . ' ';
        foreach ($elem['channels'] as $chanelAlias => $channelName) {
            echo '<input type="checkbox" name="' . $chanelAlias . '" title="' . $channelName . '" checked> ';
        }
        echo '</li>';
        if (count($elem['childKeys'])) { echo '<ul>'; write($elem['childKeys']); echo '</ul>'; }
    }

}

if (count($result)) { echo '<ul>'; write($result); echo '</ul>'; }
else { echo 'У Вас нет ни одной подписки на рассылки.'; }
?>