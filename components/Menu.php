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
            // Идентификаторы родительских (текущего и предшествующих) модулей
            $parentModulesIds = [''];
            $module = Yii::$app->controller->module;
            do {
                if ($module != null) { $parentModulesIds[] = $module->id; }
            } while (null !== ($module = $module->module));

            // Если модуль текущий или не указан
            if (in_array($moduleId, $parentModulesIds)) {
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
