<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\html;

use rusbeldoor\yii2General\common\helpers\ArrayHelper;

/**
 * ...
 */
class ActiveField extends \yii\bootstrap4\ActiveField
{
    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function searchTextInput($options = [])
    {
        $options = ArrayHelper::merge(
            [
                'placeholder' => 'Не важно',
            ],
            $options
        );
        return self::textInput($options);
    }

    /**
     * ...
     *
     * @param $items array
     * @param $options array
     * @return ActiveField
     */
    public function radioButtonsList($items, $options = [])
    {
        $options = ArrayHelper::merge(
            [
                'class' => 'btn-group',
                'data-toggle' => 'buttons',
                'unselect' => null,
                'item' => function ($index, $label, $name, $checked, $value) {
                    return
                        '<label class="btn btn-secondary' . ($checked ? ' active' : '') . '">'
                        . Html::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn'])
                        . ' '
                        . $label
                        . '</label>';
                },
            ],
            $options
        );
        return self::radioList($items, $options);
    }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function numberYesNo($options = [])
    { return self::radioButtonsList(['1' => 'Да', '0' => 'Нет'], $options); }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function searchNumberYesNo($options = [])
    { return self::radioButtonsList(['' => 'Не важно', '1' => 'Да', '0' => 'Нет'], $options); }
}
