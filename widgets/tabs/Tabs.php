<?php

namespace rusbeldoor\yii2General\widgets\tabs;

use yii\bootstrap4;

/**
 * Tabs
 */
class Tabs extends \yii\bootstrap4\Tabs
{
    /**
     * @var boolean возможность при перезагрузки страницы попадать на тот же таб (так же при нажатии на кнопку 'назад' или 'вперед'
     * НЕ РЕАЛИЗОВАНО
     */
    public $enableStickyTabs;
}
