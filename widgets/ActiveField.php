<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\html;

use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * ...
 */
class ActiveField extends \kartik\form\ActiveField
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
            ['placeholder' => 'Не важно'],
            $options
        );
        return self::textInput($options);
    }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function numberInputAppendSeconds($options = [])
    {
        $this->addon['append'] = ['content' => 'сек.'];
        return self::input('number', $options);
    }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function searchNumberInputAppendSeconds($options = [])
    {
        $options = ArrayHelper::merge(
            ['placeholder' => 'Не важно'],
            $options
        );
        return self::numberInputAppendSeconds($options);
    }

    /**
     * ...
     *
     * @param $items array
     * @param $options array
     * @return ActiveField
     *
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

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function dateTimePicker($options = [])
    {
        $this->addon['prepend'] = ['content' => '<i class="fas fa-calendar-alt"></i>'];
        return $this->widget(
            'kartik\daterange\DateRangePicker',
            ArrayHelper::merge(
                [
                    'convertFormat' => true,
                    'readonly' => true,
                    'pluginOptions' => [
                        'timePicker24Hour' => true,
                        'showDropdowns' => true,
                    ],
                ],
                $options
            )
        );
    }

    /**
     * ...
     *
     * @return ActiveField
     */
    public function dateTime()
    {
        $this->addon['groupOptions'] = ['class' => 'widthDateTime'];
        return self::dateTimePicker([
            'pluginOptions' => [
                'timePicker' => true,
                'timePickerIncrement' => 5,
                'locale' => ['format' => 'H:i d.m.Y'],
                'singleDatePicker' => true,
            ]
        ]);
    }

    /**
     * ...
     *
     * @return ActiveField
     */
    public function date()
    {
        $this->addon['groupOptions'] = ['class' => 'widthDate'];
        return self::dateTimePicker([
            'pluginOptions' => [
                'autoApply' => true,
                'locale' => ['format' => 'd.m.Y'],
                'singleDatePicker' => true,
            ]
        ]);
    }

    /**
     * ...
     *
     * @param $elems array
     * @param $options array
     * @return ActiveField
     */
    public function select($elems, $options = [])
    {
        return $this->widget(
            'rusbeldoor\yii2General\widgets\select2',
            ArrayHelper::merge(
                [
                    'data' => $elems,
                    'options' => ['placeholder' => 'Select a state ...'],
                    'pluginOptions' => [
                        'allowClear' => true, // Кнопка "крестик" очистки выбора
                    ],
                ],
                $options
            )
        );
    }

    /**
     * ...
     *
     * @param $elems array
     * @param $options array
     * @return ActiveField
     */
    public function multipleSelect($elems, $options = [])
    {
        return self::select($elems,
            ArrayHelper::merge(
                [
                    'pluginOptions' => [
                        'multiple' => true,
                    ],
                ],
                $options
            )
        );
    }

    /**
     * ...
     *
     * @param $options array
     * @return ActiveField
     */
    public function masked($options = [])
    { return $this->widget('\yii\widgets\MaskedInput', $options); }
}
