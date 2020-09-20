<?php

namespace rusbeldoor\yii2General\widgets\select2;

use yii\helpers\Html;

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

        $multiple = ArrayHelper::getValue($this->pluginOptions, 'multiple', false);

        $width100 = $this->pluginOptions['width'] == '100%';
        if ($multiple) {
            if ($width100) { $this->pluginOptions['width'] = 'calc(100% - ' . (3 * 33.384) . 'px)'; }

            echo
                Html::button(
                    '<i class="fas fa-check"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-default btn-icon buttonCheckAllSelect',
                        'data-select-id' => '1',
                        'disabled' => false,
                    ]
                )
                . '&nbsp;'
                . Html::button(
                    '<i class="fas fa-retweet"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-default btn-icon buttonReverseSelect',
                        'data-select-id' => '2',
                        'disabled' => false,
                    ]
                )
                . '&nbsp;';
        } else {
            if ($width100) { $this->pluginOptions['width'] = 'calc(100% - ' . (1 * 33.384) . 'px)'; }
        }

        echo Html::button(
            '<i class="fas fa-wind"></i>',
            [
                'type'=> 'button',
                'class' => 'btn btn-default btn-icon buttonResetSelect',
                'data-select-id' => '3',
                'disabled' => false,
            ]
        );
    }
}
