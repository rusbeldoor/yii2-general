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
        if (ArrayHelper::getValue($this->pluginOptions, 'multiple', false)) {
            $buttonsCount = 3;

            $buttonsHtml .=
                '&nbsp;'
                . Html::button(
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
                );
        }

        $this->pluginOptions['width'] = 'calc(100% - ' . ($buttonsCount * 42) . 'px)';
        $buttonsHtml .=
            '&nbsp;'
            . Html::button(
                '<i class="fas fa-wind"></i>',
                [
                    'type'=> 'button',
                    'class' => 'btn btn-light buttonResetSelect',
                    'data-select-id' => '3',
                    'disabled' => false,
                ]
            );

        parent::renderToggleAll();

        echo $buttonsHtml;
    }
}
