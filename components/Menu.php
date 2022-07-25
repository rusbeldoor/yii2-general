<?php

namespace rusbeldoor\yii2General\components;

use Yii;
use yii\bootstrap5\Html;

/**
 * Меню
 */
class Menu
{
    private $parentModulesIds = null; // Ид всех модулей

    public $menu = []; // Меню

    /**
     * Магический метод получения аттрибута
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case 'parentModulesIds':
                $this->parentModulesIds = [];
                $module = Yii::$app->controller->module;
                do {
                    if ($module != null) {
                        $this->parentModulesIds[] = $module->id;
                    }
                } while (null !== ($module = $module->module));
                break;

            default:
        }

        return ((property_exists($this, $name)) ? $this->$name : null);
    }

    /**
     * Добавление авторизации
     *
     * @param array $params
     * @return void
     */
    public function addAuthorisation($params = [])
    {
        if (!isset($params['separator'])) { $params['separator'] = true; }
        if (!isset($params['register'])) { $params['register'] = true; }
        if (!isset($params['login'])) { $params['login'] = true; }
        if (!isset($params['logout'])) { $params['logout'] = true; }

        if (count($this->menu) && $params['separator']) { $this->menu[] = ['label' => '|', 'url' => false]; }

        if (Yii::$app->user->isGuest) {
            if ($params['register']) { $this->menu[] = ['label' => 'Регистрация', 'url' => ['/site/signup']]; }
            if ($params['login']) { $this->menu[] = ['label' => 'Вход', 'url' => ['/site/login']]; }
        } else {
            if ($params['logout']) {
                $this->menu[] =
                    '<li class="nav-item">'
                    . Html::beginForm(['/site/logout'], 'post') . Html::submitButton('Выход (' . Yii::$app->user->identity->username . ')', ['class' => 'btn nav-link']) . Html::endForm()
                    . '</li>';
            }
        }
    }
}
