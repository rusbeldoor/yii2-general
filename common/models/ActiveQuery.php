<?php

namespace rusbeldoor\yii2General\common\models;

use yii;

/**
 * Common ActiveQuery
 */
class ActiveQuery extends \yii\db\ActiveQuery
{
    /**
     * Архивный
     *
     * return ActiveQuery
     */
    public function archive()
    { return $this->andWhere("archive=1"); }

    /**
     * Не архивный
     *
     * return ActiveQuery
     */
    public function notArchive()
    { return $this->andWhere("archive=0"); }
}
