<?php

namespace rusbeldoor\yii2General\widgets;

use yii\helpers\html;
use rusbeldoor\yii2General\helpers\ArrayHelper;

trait AppendPrepend
{
    /**
     * Parses and returns addon content.
     *
     * @param string $type the addon type `prepend` or `append`. If any other value is set, it will default to `prepend`
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
        $pos = $type === (('append') ? 'append' : 'prepend');
        return Html::tag('div', $out, ['class' => "input-group-{$pos}"]);
    }

    /**
     * Renders an addon item based on its configuration
     *
     * @param array $config the addon item configuration
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