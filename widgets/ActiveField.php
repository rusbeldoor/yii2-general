<?php

namespace rusbeldoor\yii2General\widgets;

use yii\base\InvalidConfigException;
use rusbeldoor\yii2General\helpers\HtmlHelper;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * ...
 */
class ActiveField extends \yii\bootstrap5\ActiveField
{
    use AppendPrepend;

    /**
     * @var array
     * prepend (array) the prepend addon configuration
     *  content (string|array) the prepend addon content
     *  asButton (boolean) whether the addon is a button or button group. Defaults to false.
     *  options (array) the HTML attributes to be added to the container.
     * append (array) the append addon configuration
     *  content (string|array) the append addon content
     *  asButton(boolean) whether the addon is a button or button group. Defaults to false.
     *  options (array) the HTML attributes to be added to the container.
     * groupOptions (array) HTML options for the input group
     * contentBefore (string) content placed before addon
     * contentAfter (string) content placed after addon
     */
    public $addon = [];

    /**
     * @inheritdoc
     * @throws InvalidConfigException
     */
    public function render($content = null): string
    {
        $this->buildTemplate();
        return parent::render($content);
    }

    /**
     * Builds the final template based on the bootstrap form type, display settings for label, error, and hint, and
     * content before and after label, input, error, and hint.
     * @throws InvalidConfigException
     */
    protected function buildTemplate()
    {
        $newInput = $this->generateAddon();
        $config = [
            '{input}' => $newInput,
        ];
        $this->template = strtr($this->template, $config);
    }

    /**
     * Generates the addon markup
     *
     * @return string
     * @throws InvalidConfigException
     */
    protected function generateAddon()
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

    /**
     * Текстовое поле для поиска
     *
     * @param array $options
     * @return ActiveField
     */
    public function searchTextInput($options = [])
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::textInput($options);
    }

    /**
     * Числовое поле
     *
     * @param array $options
     * @return ActiveField
     */
    public function numberInput($options = [])
    { return self::input('number', $options); }

    /**
     * Числовое поле для поиска
     *
     * @param array $options
     * @return ActiveField
     */
    public function searchNumberInput($options = [])
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInput($options);
    }

    /**
     * Числовое поле с статичным текстом после
     *
     * @param array $options
     * @param string|null $append
     * @return ActiveField
     */
    public function numberInputAppend($options = [], $append = null)
    {
        if (is_string($append)) { $this->addon['append'] = ['content' => $append]; }
        return self::input('number', $options);
    }

    /**
     * Числовое поле с статичным текстом после "шт."
     *
     * @param array $options
     * @return ActiveField
     */
    public function numberInputAppendCount($options = [])
    { return self::numberInputAppend($options, 'шт.'); }

    /**
     * Числовое поле с статичным текстом после "шт." для поиска
     *
     * @param array $options
     * @return ActiveField
     */
    public function searchNumberInputAppendCount($options = [])
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInputAppendCount($options);
    }

    /**
     * Числовое поле с статичным текстом после "сек."
     *
     * @param array $options
     * @return ActiveField
     */
    public function numberInputAppendSeconds($options = [])
    { return self::numberInputAppend($options, 'сек.'); }

    /**
     * Числовое поле с статичным текстом после "сек." для поиска
     *
     * @param array $options
     * @return ActiveField
     */
    public function searchNumberInputAppendSeconds($options = [])
    {
        $options = ArrayHelper::merge(['placeholder' => 'Не важно'], $options);
        return self::numberInputAppendSeconds($options);
    }

    /*** Радиогруппа кнопок ***/

    /**
     * Радиогруппа кнопок
     *
     * @param array $items
     * @param array $options
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
                    return HtmlHelper::button(
                        HtmlHelper::radio($name, $checked, ['value' => $value]) . '&nbsp;&nbsp;' . $label,
                        ['class' => 'btn btn-light' . (($checked) ? ' active' : '')]
                    );
//                    return
//                        '<label class="btn btn-light' . (($checked) ? ' active' : '') . '">'
//                            . HtmlHelper::radio($name, $checked, ['value' => $value, 'class' => 'project-status-btn'])
//                            . ' '
//                            . $label
//                        . '</label>';
                },
            ],
            $options
        );
        return self::radioList($items, $options);
    }

    /**
     * Радоигруппа кнопок Да/Нет с значениме в виде числа
     *
     * @param array $options
     * @return ActiveField
     */
    public function numberYesNo($options = [])
    { return self::radioButtonsList(['1' => 'Да', '0' => 'Нет'], $options); }

    /**
     * Радоигруппа кнопок Не важно/Да/Нет с значениме в виде числа для поиска
     *
     * @param array $options
     * @return ActiveField
     */
    public function searchNumberYesNo($options = [])
    { return self::radioButtonsList(['' => 'Не важно', '1' => 'Да', '0' => 'Нет'], $options); }

    /*** Дата и время ***/

    /**
     * Общий выбор даты и времени
     *
     * @param array $options
     * @return ActiveField
     */
    private function dateTimePicker($options = [])
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
     * Выюор даты и времени
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
     * Выбор даты
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

    /*** Выпадающий список ***/

    /**
     * Выпадающие список
     *
     * @param array $elems
     * @param array $options
     * @return ActiveField
     */
    public function select($elems, $options = [])
    {
        $options = ArrayHelper::merge(['data' => $elems, 'pluginOptions' => ['allowClear' => true]], $options);
        return $this->widget('rusbeldoor\yii2General\widgets\select2', $options);
    }

    /**
     * Выпадающий список для поиска
     *
     * @param array $elems
     * @param array $options
     * @return ActiveField
     */
    public function searchSelect($elems, $options = [])
    {
        $options = ArrayHelper::merge(['options' => ['placeholder' => 'Не важно']], $options);
        return self::select($elems, $options);
    }

    /**
     * Выпадающий список с множественным выбором
     *
     * @param array $elems
     * @param array $options
     * @return ActiveField
     */
    public function multipleSelect($elems, $options = [])
    {
        $options = ArrayHelper::merge(['pluginOptions' => ['multiple' => true]], $options);
        return self::select($elems, $options);
    }

    /**
     * Выпадающий список с множественным выбором для поиска
     *
     * @param array $elems
     * @param array $options
     * @return ActiveField
     */
    public function searchMultipleSelect($elems, $options = [])
    {
        $options = ArrayHelper::merge(['pluginOptions' => ['multiple' => true]], $options);
        return self::searchSelect($elems, $options);
    }

    /*** Маска для ввода ***/

    /**
     * Поле для ввода с маской
     *
     * @param array $options
     * @return ActiveField
     */
    public function masked($options = [])
    { return $this->widget('\yii\widgets\MaskedInput', $options); }

    /**
     * Поле для ввода с маской алиаса
     *
     * @param array $options
     * @return ActiveField
     */
    public function maskedAlias($options = [])
    {
        if (!isset($options['maxLength'])) { $options['maxLength'] = 16; }
        if (!isset($options['greedy'])) { $options['greedy'] = false; }

        return self::masked([
            'mask' => 'z',
            'definitions' => ['z' => ['validator' =>  '^[a-zA-z0-9\-]+']],
            'clientOptions' => ['repeat' => $options['maxLength'], 'greedy' => $options['greedy']]
        ]);
    }

    /*** Алиас ***/

    /**
     * Алиас
     *
     * @param array $options
     * @return ActiveField
     */
    public function alias($options = [])
    {
        if (!isset($options['maxLength'])) { $options['maxLength'] = 16; }
        if (!isset($options['maskedOptions'])) { $options['maskedOptions'] = []; }
        if (!isset($options['maskedOptions']['maxLength'])) { $options['maskedOptions']['maxLength'] = $options['maxLength']; }

        return self::textInput($options)->maskedAlias($options['maskedOptions']);
    }
}