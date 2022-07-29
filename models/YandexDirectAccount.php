<?php

namespace rusbeldoor\yii2General\models;

/**
 * Yandex_direct_account (ActiveRecord)
 *
 * @property $id int
 * @property $name string
 * @property $url string
 * @property $login string
 * @property $token string
 */
class YandexDirectAccount extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    { return 'yandex_direct_account'; }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['name', 'url', 'login', 'token'], 'required'],
        [['name', 'login', 'token'], 'string', 'max' => 64],
        [['url'], 'string', 'max' => 96],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'name' => 'Название',
        'url' => 'Адрес',
        'login' => 'Логин',
        'token' => 'Токен',
    ]; }

    /**
     * {@inheritdoc}
     *
     * @return YandexDirectAccountQuery the active query used by this AR class.
     */
    public static function find()
    { return new YandexDirectAccountQuery(get_called_class()); }

    /**
     * Перед удалением
     *
     * @return bool
     */
    public function beforeDelete()
    {
        // if (true) { $this->addError('id', 'Элемент #' . $this->id . ' не может быть удалён.'); }

        return !$this->hasErrors() && parent::beforeDelete();
    }
}