<?php

namespace rusbeldoor\yii2General\components;

use Yii;
use rusbeldoor\yii2General\helpers\HtmlHelper;

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
            $menuItems[] = '<li class="nav-item">' . HtmlHelper::beginForm(['/site/logout'], 'post') . HtmlHelper::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'btn nav-link']) . HtmlHelper::endForm() . '</li>';
        }
        return $menuItems;
    }
}
