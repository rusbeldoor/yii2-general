<?php
namespace rusbeldoor\yii2General\components;

use yii;
use yii\helpers\Html;

/**
 * ...
 */
class BaseModule extends \yii\base\Module
{
    /**
     * Меню
     *
     * @return array
     */
    public static function menu()
    {
        $menuItems = [];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Вход', 'url' => ['/site/login']];
        } else {
            $menuItems[] = '<li class="nav-item">' . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'btn nav-link']) . Html::endForm() . '</li>';
        }
        return $menuItems;
    }
}
