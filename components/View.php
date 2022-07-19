<?php

namespace rusbeldoor\yii2General\components;

/**
 * ...
 */
class View extends \yii\web\View
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
        $this->params['breadcrumbs'][] = ['label' => $label, 'url' => $url];
    }
}
