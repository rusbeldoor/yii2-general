<?php

namespace rusbeldoor\yii2General\helpers;

/**
 * ...
 */
class Bootstrap4Helper
{
    const SIZE_EXTRA_SMALL = '';
    const SIZE_SMALL = 'sm';
    const SIZE_MEDIUM = 'md';
    const SIZE_LARGE = 'lg';
    const SIZE_EXTRA_LARGE = 'xl';

    /**
     * @param string $size
     * @return string
     */
    public static function col($size)
    { return 'col-' . (($size != self::SIZE_EXTRA_SMALL) ? $size . '-' : ''); }
}