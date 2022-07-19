<?php

namespace rusbeldoor\yii2General\components;

/**
 * Контроллер
 */
class Controller extends \yii\console\Controller
{
    /**
     * Добавление хлебной крошки
     *
     * @param string $label
     * @param array $url
     * @return void
     */
    public function addBreadcrumb(string $label, array $url)
    {
        $this->view->params['breadcrumbs'][] = ['label' => $label, 'url' => $url];
    }
}
