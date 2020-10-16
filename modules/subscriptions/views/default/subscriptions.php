<?php
/* @var $this yii\web\View */
/* @var $result array */

function write($array) {
    echo '<li>';
    echo $array['name'] . ' ';
    foreach ($array['channels'] as $chanelAlias => $channelName) {
        echo '<input type="checkbox" name="' . $chanelAlias . '" title="' . $channelName . '" checked> ';
    }
    echo '</li>';
    if (count($array['childKeys'])) { echo '<ul>'; write($array['childKeys']); echo '</ul>'; }
}

if (count($result)) { echo '<ul>'; write($result); echo '</ul>'; }
else { echo 'У Вас нет ни одной подписки на рассылки.'; }
?>