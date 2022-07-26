<?php

namespace rusbeldoor\yii2General\widgets;

/**
 * ...
 */
class Range extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        //$this->container['class'][] = 'row';
        //$this->labelOptions['class'][] = 'col-2';
        //if ($this->required) { $this->labelOptions['class'][] = 'has-star'; }
        //$this->widgetContainer['class'][] = 'col-10';
        //$this->separator = '<i class="fas fa-long-arrow-alt-left"></i>&nbsp;<i class="fas fa-long-arrow-alt-right"></i>';
    }

    /**
     * Renders the field range widget.
     * @throws InvalidConfigException
     * @throws Exception
     */
    protected function renderWidget()
    {
        echo '123';
        /*
        HtmlHelper::addCssClass($this->options, 'kv-field-range');
        HtmlHelper::addCssClass($this->container, 'kv-field-range-container');
        $isBs4 = $this->isBs4();
        $style = ['labelCss' => 'col-sm-3', 'inputCss' => 'col-sm-9'];
        if ($this->_isHorizontalForm) {
            $style = $this->form->getFormLayoutStyle();
            HtmlHelper::addCssClass($this->labelOptions, $style['labelCss']);
            HtmlHelper::addCssClass($this->widgetContainer, $style['inputCss']);
        }
        if ($this->type === self::INPUT_DATE) {
            $widget = $this->getDatePicker();
        } else {
            $css = ['form-group'];
            if ($isBs4 && $this->_isHorizontalForm) { $css[] = 'row'; }
            if ($this->required) { $css[] = 'required'; }
            HtmlHelper::addCssClass($this->container, $css);
            HtmlHelper::addCssClass($this->options, 'input-group');
            $tag = ArrayHelper::remove($this->separatorOptions, 'tag', 'span');
            $sep = HtmlHelper::tag($tag, $this->separator, $this->separatorOptions);
            if ($isBs4) {
                $sep = HtmlHelper::tag('div', $sep, ['class' => 'input-group-append kv-separator-container']);
            }
            $getInput = isset($this->form) ? 'getFormInput' : 'getInput';
            $widget = HtmlHelper::tag('div', $this->$getInput(1) . $sep . $this->$getInput(2), $this->options);
        }
        $widget = HtmlHelper::tag('div', $widget, $this->widgetContainer);
        $css = 'help-block';
        if ($this->isBs4()) {
            $css .= ' text-danger';
        }
        $preError = '';
        $errorCss = ['kv-field-range-error'];
        if ($this->_isHorizontalForm) {
            $errorCss[] = $style['inputCss'];
            HtmlHelper::addCssClass($this->errorContainer, $errorCss);
            $preError = HtmlHelper::tag('div', '', ['class' => $style['labelCss']]);
        }
        $error = $preError . HtmlHelper::tag('div', '<div class="' . $css . '"></div>', $this->errorContainer);
        $replaceTokens = [
            '{label}' => HtmlHelper::label($this->label, null, $this->labelOptions),
            '{widget}' => $widget,
            '{error}' => $error,
        ];
        echo HtmlHelper::tag('div', strtr($this->template, $replaceTokens), $this->container);
        */
    }
}
