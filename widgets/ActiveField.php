<?php

namespace rusbeldoor\yii2General\widgets;

use rusbeldoor\yii2General\helpers\HtmlHelper;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/** ... */
class ActiveField extends \yii\bootstrap5\ActiveField
{
    use \rusbeldoor\yii2General\widgets\trait\AppendPrepend;

    public $addon = [];

    /** @inheritdoc */
    public function render($content = null): string
    {
        $this->buildTemplate();
        return parent::render($content);
    }

    /** @inheritdoc */
    protected function buildTemplate(): void
    {
        $newInput = $this->generateAddon();
        $config = [
            '{input}' => $newInput,
        ];
        $this->template = strtr($this->template, $config);
    }

    /** @inheritdoc */
    protected function generateAddon(): string
    {
        if (empty($this->addon)) { return '{input}'; }
        $addon = $this->addon;
        $prepend = $this->getAddonContent('prepend');
        $append = $this->getAddonContent('append');
        $content = $prepend . '{input}' . $append;
        $group = ArrayHelper::getValue($addon, 'groupOptions', []);
        HtmlHelper::addCssClass($group, 'input-group');
        $contentBefore = ArrayHelper::getValue($addon, 'contentBefore', '');
        $contentAfter = ArrayHelper::getValue($addon, 'contentAfter', '');
        $content = HtmlHelper::tag('div', $contentBefore . $content . $contentAfter, $group);
        return $content;
    }

    /** Текстовое поле для поиска */
    public function searchTextInput(array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::textInput($options);
    }

    /** Числовое поле */
    public function numberInput(array $options = []): ActiveField
    { return self::input('number', $options); }

    /** Числовое поле для поиска */
    public function searchNumberInput(array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInput($options);
    }

    /** Числовое поле с статичным текстом после */
    public function numberInputAppend(array $options = [], ?string $append = null): ActiveField
    {
        if (is_string($append)) { $this->addon['append'] = ['content' => $append]; }
        return self::input('number', $options);
    }

    /** Числовое поле с статичным текстом после "шт." */
    public function numberInputAppendCount(array $options = []): ActiveField
    { return self::numberInputAppend($options, 'шт.'); }

    /** Числовое поле с статичным текстом после "шт." для поиска */
    public function searchNumberInputAppendCount(array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInputAppendCount($options);
    }

    /** Числовое поле с статичным текстом после "сек." */
    public function numberInputAppendSeconds(array $options = []): ActiveField
    { return self::numberInputAppend($options, 'сек.'); }

    /** Числовое поле с статичным текстом после "сек." для поиска */
    public function searchNumberInputAppendSeconds(array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInputAppendSeconds($options);
    }

    /*** Радиогруппа кнопок ***/

    /** Радиогруппа кнопок */
    public function radioButtonsList(array $items, array $options = []): ActiveField
    {
        $this->options['class']['layout'] = 'mt-3';
        $this->template = '{label}&nbsp;{input}{error}{hint}';

        return self::radioList($items, ArrayHelper::merge(
            [
                'class' => 'btn-group',
                'item' => function (int $index, string $label, string $name, bool $checked, string $value): string
                {
                    $input = HtmlHelper::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn']);
                    $checked = (($checked) ? ' active' : '');
                    return <<< HTML
                        <label class="btn btn-light$checked">
                            $input $label
                        </label>
                    HTML;
                },
            ],
            $options
        ));
    }

    /** Радоигруппа кнопок Да/Нет с значениме в виде числа */
    public function numberYesNo(array $options = []): ActiveField
    { return self::radioButtonsList(['1' => 'Да', '0' => 'Нет'], $options); }

    /** Радоигруппа кнопок Не важно/Да/Нет с значениме в виде числа для поиска */
    public function searchNumberYesNo(array $options = []): ActiveField
    { return self::radioButtonsList(['' => 'Не важно', '1' => 'Да', '0' => 'Нет'], $options); }

    /*** Дата и время ***/

    /** Общий выбор даты и времени */
    private function dateTimePicker(array $options = []): ActiveField
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

    /** Выбор даты и времени */
    public function dateTime(): ActiveField
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

    /** Выбор даты */
    public function date(): ActiveField
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

    /*** Выпадающий список ***/

    /** Выпадающие список */
    public function select(array $elems, array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['data' => $elems, 'pluginOptions' => ['allowClear' => true]], $options);
        return $this->widget('rusbeldoor\yii2General\widgets\select2', $options);
    }

    /** Выпадающий список для поиска */
    public function searchSelect(array $elems, array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['options' => ['placeholder' => 'Не важно']], $options);
        return self::select($elems, $options);
    }

    /** Выпадающий список с множественным выбором */
    public function multipleSelect(array $elems, array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['pluginOptions' => ['multiple' => true]], $options);
        return self::select($elems, $options);
    }

    /** Выпадающий список с множественным выбором для поиска */
    public function searchMultipleSelect(array $elems, array $options = []): ActiveField
    {
        $options = ArrayHelper::merge(['pluginOptions' => ['multiple' => true]], $options);
        return self::searchSelect($elems, $options);
    }

    /*** Маска для ввода ***/

    /** Поле для ввода с маской */
    public function masked(array $options = []): ActiveField
    { return $this->widget('\yii\widgets\MaskedInput', $options); }

    /*** Алиас ***/

    /** Алиас */
    public function alias(array $options = []): ActiveField
    {
        if (!isset($options['maxLength'])) { $options['maxLength'] = 16; }
        if (!isset($options['maskedOptions'])) { $options['maskedOptions'] = []; }
        if (!isset($options['maskedOptions']['maxLength'])) { $options['maskedOptions']['maxLength'] = $options['maxLength']; }

        return self::textInput($options)->maskedAlias($options['maskedOptions']);
    }

    /** Алиас с маской для ввода */
    public function maskedAlias(array $options = []): ActiveField
    {
        if (!isset($options['maxLength'])) { $options['maxLength'] = 16; }
        if (!isset($options['greedy'])) { $options['greedy'] = false; }

        return self::masked([
            'mask' => 'z',
            'definitions' => ['z' => ['validator' =>  '^[a-zA-z0-9\-]+']],
            'clientOptions' => ['repeat' => $options['maxLength'], 'greedy' => $options['greedy']]
        ]);
    }
}