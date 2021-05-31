<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\html;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * Trait AppendPrepend
 */
trait AppendPrepend
{
    /**
     * Получением всего содержимого
     *
     * @param string $type
     * @return string
     */
    protected function getAddonContent($type)
    {
        $addon = ArrayHelper::getValue($this->addon, $type, '');
        if (!is_array($addon)) { return $addon; }
        if (isset($addon['content'])) {
            $out = static::renderAddonItem($addon);
        } else {
            $out = '';
            foreach ($addon as $item) {
                if (is_array($item) && isset($item['content'])) {
                    $out .= static::renderAddonItem($item);
                }
            }
        }
        $pos = (($type === 'append') ? 'append' : 'prepend');
        return Html::tag('div', $out, ['class' => "input-group-{$pos}"]);
    }

    /**
     * Получение одного элемента содержимого
     *
     * @param array $config
     * @return string
     */
    protected static function renderAddonItem($config)
    {
        $content = ArrayHelper::getValue($config, 'content', '');
        $options = ArrayHelper::getValue($config, 'options', []);
        $asButton = ArrayHelper::getValue($config, 'asButton', false);
        if ($asButton) { return $content; }
        Html::addCssClass($options, 'input-group-text');
        return Html::tag('span', $content, $options);
    }
}