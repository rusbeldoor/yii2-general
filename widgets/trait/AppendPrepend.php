<?php

namespace rusbeldoor\yii2General\widgets\trait;

use rusbeldoor\yii2General\helpers\HtmlHelper;
use rusbeldoor\yii2General\helpers\ArrayHelper;

/** ... */
trait AppendPrepend
{
    /** Получением всего содержимого */
    protected function getAddonContent(string $type): string
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
        return $out;
    }

    /** Получение одного элемента содержимого */
    protected static function renderAddonItem(array $config): string
    {
        $content = ArrayHelper::getValue($config, 'content', '');
        $options = ArrayHelper::getValue($config, 'options', []);
        $asButton = ArrayHelper::getValue($config, 'asButton', false);
        if ($asButton) { return $content; }
        HtmlHelper::addCssClass($options, 'input-group-text');
        return HtmlHelper::tag('span', $content, $options);
    }
}