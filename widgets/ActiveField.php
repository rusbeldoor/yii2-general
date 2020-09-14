<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\html;

/**
 * ...
 */
class ActiveField extends \yii\bootstrap4\ActiveField
{
    /**
     * ...
     */
    public function radioButtonsList($items)
    {
        parent::radioList($items, [
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
        ]);
        return $this;
    }

    /**
     * ...
     */
    public function numberYesNo()
    { return self::radioButtonsList([1 => 'Да', 0 => 'Нет']); }

    /**
     * ...
     */
    public function stringNumberYesNo()
    { return self::radioButtonsList(['1' => 'Да', '0' => 'Нет']); }

    /**
     * ...
     */
    public function booleanYesNo()
    { return self::radioButtonsList([true => 'Да', false => 'Нет']); }

    /**
     * ...
     */
    public function searchArchive()
    { return self::radioButtonsList(['' => 'Не важно', 1 => 'Да', 0 => 'Нет']); }
}
