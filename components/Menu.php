<?php

namespace rusbeldoor\yii2General\components;

use yii;
use yii\helpers\Html;

/**
 * Меню
 */
class Menu
{
    public $menu = [];

    /**
     * Поучение меню
     *
     * @return array
     */
    public function get()
    {
        $items = [];

        foreach ($this->menu as $item) {
            $items[] = $item;
        }

        if (Yii::$app->user->isGuest) {
            $items[] = ['label' => 'Вход', 'url' => ['/site/login']];
        } else {
            $items[] =
                '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'btn nav-link']) . Html::endForm()
                . '</li>';
        }
        return $items;
    }
}
