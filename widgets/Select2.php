<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\Html;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * ...
 */
class Select2 extends \kartik\select2\select2
{
    /**
     * ...
     */
    protected function renderToggleAll()
    {
        parent::renderToggleAll();

        $buttonsCount = 1;
        if (ArrayHelper::getValue($this->pluginOptions, 'multiple', false)) {
            $buttonsCount = 3;

            echo
                Html::button(
                    '<i class="fas fa-check"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-light buttonCheckAllSelect',
                        'data-select-id' => '1',
                        'disabled' => false,
                    ]
                )
                . '&nbsp;'
                . Html::button(
                    '<i class="fas fa-retweet"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-light buttonReverseSelect',
                        'data-select-id' => '2',
                        'disabled' => false,
                    ]
                )
                . '&nbsp;';
        }

        $this->pluginOptions['width'] = 'calc(100% - ' . ($buttonsCount * 42) . 'px)';
        echo Html::button(
            '<i class="fas fa-wind"></i>',
            [
                'type'=> 'button',
                'class' => 'btn btn-light buttonResetSelect',
                'data-select-id' => '3',
                'disabled' => false,
            ]
        );
    }
}
