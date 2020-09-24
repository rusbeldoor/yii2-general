<?php

namespace rusbeldoor\yii2General\components;

use yii;
use yii\helpers\Html;

/**
 * Меню
 */
class Menu
{
    public $menu = [
        '' => [],
    ];

    /**
     * Получение меню
     *
     * @return array
     */
    public function get()
    {
        $items = [];

        // Перебираем модули
        foreach ($this->menu as $moduleId => $items) {
            // Если модуль текущий
            if (Yii::$app->controller->module->id == $moduleId) {
                // Перебираем пункты меню
                foreach ($items as $item) {
                    // Добавляем пункт меню
                    $items[] = $item;
                }
            }
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
