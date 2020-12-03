<?php

namespace rusbeldoor\yii2General\widgets;

use yii;
use yii\helpers\Html;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * ...
 */
class Select2 extends \kartik\select2\select2
{
    /**
     *
     */
    public function init()
    {
        parent::init();

        Yii::$app->getView()->registerJs(
'$(document).ready(function() {
    $(document).on(\'click\', \'.select2ButtonReset\', function() {
        $(\'#\' + $(this).data(\'select-id\')).val(null).trigger(\'change\');
    });
    $(document).on(\'click\', \'.select2ButtonAll\', function() {
        alert(\'Не реализовано.\');
    });
    $(document).on(\'click\', \'.select2ButtonReverse\', function() {
        alert(\'Не реализовано.\');
    });
});'
        );
    }

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
                        'class' => 'btn btn-light select2Button select2ButtonReverse',
                        'data-select-id' => $this->options['id'],
                        'disabled' => false,
                    ]
                )
                . Html::button(
                    '<i class="fas fa-check"></i>',
                    [
                        'type'=> 'button',
                        'class' => 'btn btn-light select2Button select2ButtonAll',
                        'data-select-id' => $this->options['id'],
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
                    'class' => 'btn btn-light select2Button select2ButtonReset',
                    'data-select-id' => $this->options['id'],
                    'disabled' => false,
                ]
            );

        parent::renderToggleAll();

        echo $buttonsHtml;
    }
}
