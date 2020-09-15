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
    { return self::textInput(['placeholder' => 'Не важно']); }

    /**
     * ...
     *
     * @param $items array
     * @param $options array
     * @return ActiveField
     */
    public function radioButtonsList($items, $options = [])
    {
        parent::radioList(
            $items,
            ArrayHelper::merge(
                [
                    'class' => 'btn-group',
                    'data-toggle' => 'buttons',
                    'unselect' => null,
                    'value' => 1,
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
            )
        );
        return $this;
    }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function numberYesNo($options = [])
    { return self::radioButtonsList([1 => 'Да', 0 => 'Нет'], $options); }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function stringNumberYesNo($options = [])
    { return self::radioButtonsList(['1' => 'Да', '0' => 'Нет'], $options); }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function booleanYesNo($options = [])
    { return self::radioButtonsList([true => 'Да', false => 'Нет'], $options); }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function searchStringNumberYesNo($options = [])
    { return self::radioButtonsList(['' => 'Не важно', 1 => 'Да', 0 => 'Нет'], $options); }
}
