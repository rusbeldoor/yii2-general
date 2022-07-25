<?php

namespace rusbeldoor\yii2General\widgets\grid;

use Yii;
use yii\bootstrap5\Html;

/**
 * ...
 */
class ActionColumn extends \yii\grid\ActionColumn
{
    // Атрибуты тега th
    public $headerOptions = ['class' => 'actionColumnHeader'];
    // Атрибуты тега td
    public $contentOptions = ['class' => 'actionColumn'];
    // Атрибуты тега button
    public $buttonOptions = ['class' => 'actionColumnButton'];

    // Шаблон вывода
    public $template = '{view}&nbsp;&nbsp;{update}&nbsp;&nbsp;{delete}';

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'far fa-eye');
        $this->initDefaultButton('update', 'fas fa-pencil-alt');
        $this->initDefaultButton('delete', 'far fa-trash-alt', [
            'data-confirm' => Yii::t('yii', 'Вы уверены, что хотите удалить этот элемент?'),
            'data-method' => 'post',
        ]);
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && (strpos($this->template, '{' . $name . '}') !== false)) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'Просмотр');
                        $class = 'colorView';
                        break;

                    case 'update':
                        $title = Yii::t('yii', 'Изменить');
                        $class = 'colorEdit';
                        break;

                    case 'delete':
                        $title = Yii::t('yii', 'Удалить');
                        $class = 'colorRemove';
                        break;

                    default: $title = ucfirst($name);
                }
                $options = array_merge([
                    'title' => $title,
                ], $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('i', '', ['class' => $iconName . ' ' . $class]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
