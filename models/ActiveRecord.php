<?php

namespace rusbeldoor\yii2General\models;

use rusbeldoor\yii2General\helpers\ArrayHelper;

/**
 * Common ActiveRecord
 */
class ActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * Магический метод получения аттрибута
     *
     * @param $name string
     * @return mixed
     */
    public function __get($name)
    { return ((property_exists($this, $name)) ? $this->$name : parent::__get($name)); }

    /**
     * Список элементов
     *
     * @param $valueFieldName string
     * @param $keyFieldName string
     * @return string
     */
    public static function getList($valueFieldName = 'name', $keyFieldName = 'id')
    { return array_column(self::find()->asArray()->all(), $valueFieldName, $keyFieldName); }

    /**
     * Список не архивных элементов
     *
     * @param $id int|null
     * @param $valueFieldName string
     * @param $keyFieldName string
     * @return string
     */
    public static function getNotArchiveList($id = null, $valueFieldName = 'name', $keyFieldName = 'id')
    { return array_column(self::find()->notArchive()->asArray($id)->all(), $valueFieldName, $keyFieldName); }

    /****************************
     *** *** *** Поля *** *** ***
     ****************************/

    // Описание полей
    public static $fieldsDescriptions = [];

    /**
     * Описание по значению
     *
     * @param $fieldName string
     * @return string
     */
    public function getFieldDescription($fieldName)
    { return static::$fieldsDescriptions[$fieldName][$this->$fieldName]; }

    /********************************
     *** *** *** Проверки *** *** ***
     ********************************/

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
     * @param $message string
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
     * @param $elems string|array
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
     * @param $elems string|array
     * @return array
     */
    public static function getRuleMatchInn($elems)
    { return self::getRuleMatch(
        $elems,
        '/^[0-9]{12}$/'
    ); }
}
