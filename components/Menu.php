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
        /*
        '' => [
            ['label' => 'Главная', 'url' => ['/']],
        ],
        'admin' => [
            ['label' => 'Первая панель', 'url' => ['/first-panel']],
            ['label' => 'Вторая панель', 'url' => ['/second-panel']],
        ],
        */
    ];

    /**
     * Получение меню
     *
     * @return array
     */
    public function get()
    {
        $menu = [];

        // Перебираем модули
        foreach ($this->menu as $moduleId => $items) {
            // Если модуль текущий или не указан
            if (in_array($moduleId, ['', Yii::$app->controller->module->id])) {
                // Перебираем пункты меню
                foreach ($items as $item) {
                    // Добавляем пункт меню
                    $menu[] = $item;
                }
            }
        }

        if (Yii::$app->user->isGuest) {
            $menu[] = ['label' => 'Вход', 'url' => ['/site/login']];
        } else {
            $menu[] =
                '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'btn nav-link']) . Html::endForm()
                . '</li>';
        }

        return $menu;
    }
}
