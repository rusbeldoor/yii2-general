<?php

namespace rusbeldoor\yii2General\models;

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
}
