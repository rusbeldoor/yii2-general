<?php
/* @var $this yii\web\View */
/* @var $result array */

print_r($result);
if (!count($result)) { echo 'У Вас нет ни одной подписки на рассылки.'; }
foreach ($result as $keyAlias => $subscription) {
    //
}
?>