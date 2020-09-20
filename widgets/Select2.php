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
        $buttonsCount = 1;
        $buttonsHtml = '';
        if (ArrayHelper::getValue($this->options, 'multiple', false)) {
            $buttonsCount = 3;

            $buttonsHtml .=
                Html::button(
                    '<i class="fas fa-retweet"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-light buttonReverseSelect',
                        'style' => 'width: 46px; margin-left: 5px; float: right;',
                        'data-select-id' => '2',
                        'disabled' => false,
                    ]
                )
                . Html::button(
                    '<i class="fas fa-check"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-light buttonCheckAllSelect',
                        'style' => 'width: 46px; margin-left: 5px; float: right;',
                        'data-select-id' => '1',
                        'disabled' => false,
                    ]
                );
        }

        $this->pluginOptions['width'] = 'calc(100% - ' . ($buttonsCount * (46 + 5)) . 'px)';
        $buttonsHtml .=
            Html::button(
                '<i class="fas fa-wind"></i>',
                [
                    'type'=> 'button',
                    'class' => 'btn btn-light buttonResetSelect',
                    'style' => 'width: 46px; margin-left: 5px; float: right;',
                    'data-select-id' => '3',
                    'disabled' => false,
                ]
            );

        parent::renderToggleAll();

        echo $buttonsHtml;
    }
}
