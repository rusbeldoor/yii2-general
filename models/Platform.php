<?php

namespace rusbeldoor\yii2General\models;

use Yii;

/**
 * This is the model class for table "platform".
 *
 * @property int $id
 * @property string $alias
 * @property string $name
 */
class Platform extends ActiveRecord
{
    /** {@inheritdoc} */
    public static function tableName()
    {
        return 'platform';
    }

    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['alias', 'name'], 'required'],
        [['alias'], 'string', 'max' => 16],
        [['name'], 'string', 'max' => 32],
        [['alias'], 'unique'],
    ]; }

    /** {@inheritdoc} */
    public function attributeLabels(): array
    { return [
        'id' => 'Ид',
        'alias' => 'Алиас',
        'name' => 'Название',
    ]; }
}
