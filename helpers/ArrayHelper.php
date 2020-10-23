<?php
namespace rusbeldoor\yii2General\helpers;

class ArrayHelper extends \yii\helpers\ArrayHelper
{
    /**
     * Массив по полю
     *
     * @param $array array
     * @param string $field
     * @return array
     */
    public static function arrayByField($array, $field)
    {
        if (!is_array($array)) { return []; }

        $result = [];
        foreach ($array as $item) {
            $key = ((is_object($item)) ? $item->$field : $item[$field]);
            $result[$key] = $item;
        }
        return $result;
    }
}