<?php

namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
class Range extends Widget
{
    /**
     * Renders the field range widget.
     * @throws InvalidConfigException
     * @throws Exception
     */
    protected function renderWidget()
    {
        Html::addCssClass($this->options, 'kv-field-range');
        Html::addCssClass($this->container, 'kv-field-range-container');
        $isBs4 = $this->isBs4();
        $style = ['labelCss' => 'col-sm-3', 'inputCss' => 'col-sm-9'];
        if ($this->_isHorizontalForm) {
            $style = $this->form->getFormLayoutStyle();
            Html::addCssClass($this->labelOptions, $style['labelCss']);
            Html::addCssClass($this->widgetContainer, $style['inputCss']);
        }
        if ($this->type === self::INPUT_DATE) {
            $widget = $this->getDatePicker();
        } else {
            $css = 'form-group';
            if ($isBs4 && $this->_isHorizontalForm) {
                $css = [$css, 'row'];
            }
            Html::addCssClass($this->container, $css);
            Html::addCssClass($this->options, 'input-group');
            $tag = ArrayHelper::remove($this->separatorOptions, 'tag', 'span');
            $sep = Html::tag($tag, $this->separator, $this->separatorOptions);
            if ($isBs4) {
                $sep = Html::tag('div', $sep, ['class' => 'input-group-append kv-separator-container']);
            }
            $getInput = isset($this->form) ? 'getFormInput' : 'getInput';
            $widget = Html::tag('div', $this->$getInput(1) . $sep . $this->$getInput(2), $this->options);
        }
        $widget = Html::tag('div', $widget, $this->widgetContainer);
        $css = 'help-block';
        if ($this->isBs4()) {
            $css .= ' text-danger';
        }
        $preError = '';
        $errorCss = ['kv-field-range-error'];
        if ($this->_isHorizontalForm) {
            $errorCss[] = $style['inputCss'];
            Html::addCssClass($this->errorContainer, $errorCss);
            $preError = Html::tag('div', '', ['class' => $style['labelCss']]);
        }
        $error = $preError . Html::tag('div', '<div class="' . $css . '"></div>', $this->errorContainer);
        $replaceTokens = [
            '{label}' => Html::label($this->label, null, $this->labelOptions),
            '{widget}' => $widget,
            '{error}' => $error,
        ];
        echo Html::tag('div', strtr($this->template, $replaceTokens), $this->container);
    }
}
