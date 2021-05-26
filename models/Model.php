<?php

namespace rusbeldoor\yii2General\models;

/**
 * Common ActiveRecord
 */
class Model extends \yii\base\Model
{
    /**
     * Магический метод получения аттрибута
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    { return ((property_exists($this, $name)) ? $this->$name : parent::__get($name)); }

    /****************************
     *** *** *** Поля *** *** ***
     ****************************/

    // Описание полей
    public static $fieldsDescriptions = [];

    /**
     * Описание по значению
     *
     * @param string $fieldName
     * @return string
     */
    public function getFieldDescription($fieldName)
    { return static::$fieldsDescriptions[$fieldName][$this->$fieldName]; }

    /*********************************
     *** *** *** Валидация *** *** ***
     *********************************/

    /**
     * Правило валидации регулярным выражением
     *
     * @param array|string $elems
     * @param string $function
     * @param array $options
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
     * @param array|string $elems
     * @return array
     */
    public static function getRuleString($elems, $options)
    { return self::getRule($elems, 'string', $options); }

    /**
     * Правило валидации регулярным выражением
     *
     * @param array|string $elems
     * @param string $pattern
     * @param string $message
     * @return array
     */
    public static function getRuleMatch($elems, $pattern, $message = null)
    {
        $options = ['pattern' => $pattern];
        if ($message) { $options['message'] = $message; }
        return self::getRule($elems, 'match', $options);
    }

    /**
     * Правило валидации алиаса
     *
     * @param array|string $elems
     * @return array
     */
    public static function getRuleMatchAlias($elems)
    { return self::getRuleMatch(
        $elems,
        '/^[a-z0-9-]+$/',
        'Допустимы только символы: "a"-"z", "0"-"9" и "-".'
    ); }

    /**
     * Правило валидации ИНН
     *
     * @param array|string $elems
     * @return array
     */
    public static function getRuleMatchInn($elems)
    { return self::getRuleMatch(
        $elems,
        '/^[0-9]{12}$/'
    ); }
}
