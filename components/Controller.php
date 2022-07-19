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
     * @param ?array $url
     * @return void
     */
    public function addBreadcrumb(string $label, array $url = null)
    {
        $array = ['label' => $label];
        if ($url !== null) { $array['url'] = $url; }
        $this->view->params['breadcrumbs'][] = $array;
    }
}
