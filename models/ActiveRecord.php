<?php

namespace rusbeldoor\yii2General\models;

use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * Common ActiveRecord
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Проверка на возможность удаления
     * Для реализации необходимо расширить в потомке, иначе удаление всегда будет доступно
     *
     * @return array
     */
    public function checkCanDelete()
    {
        if (false) { return ['result' => false, 'reason' => '']; }
        return ['result' => true];
    }

    /*********************************
     *** *** *** Валидация *** *** ***
     *********************************/

    /**
     * Правило валидации регулярным выражением
     *
     * @param $elems string|array
     * @param $function string
     * @param $options array
     * @return array
     */
    public static function getRule($elems, $function, $options)
    {
        if (!is_array($elems)) { $elems = [$elems]; }
        return ArrayHelper::merge([0 => $elems, 1 => $function], $options);
    }

    /**
     * Правило валидации строки
     *
     * @param $elems string|array
     * @return array
     */
    public static function getRuleString($elems, $options)
    { return self::getRule($elems, 'string', $options); }

    /**
     * Правило валидации регулярным выражением
     *
     * @param $elems string|array
     * @param $pattern string
     * @return array
     */
    public static function getRuleMatch($elems, $pattern)
    { return self::getRule($elems, 'match', ['pattern' => $pattern]); }

    /**
     * Правило валидации алиаса
     *
     * @param $elems string|array
     * @return array
     */
    public static function getRuleMatchAlias($elems)
    { return self::getRuleMatch($elems, '/^[a-z0-9-]+$/'); }

    /**
     * Правило валидации ИНН
     *
     * @param $elems string|array
     * @return array
     */
    public static function getRuleMatchInn($elems)
    { return self::getRuleMatch($elems, '/^[0-9]{12}$/'); }
}
