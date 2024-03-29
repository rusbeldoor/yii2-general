<?php

namespace rusbeldoor\yii2General\modules\cron\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use rusbeldoor\yii2General\models\CronLog;

/**
 * CronLogSearch represents the model behind the search form of `rusbeldoor\yii2General\models\CronLog`.
 */
class CronLogSearch extends CronLog
{
    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['id', 'cron_id', 'duration'], 'integer'],
        [['datetime_start', 'datetime_complete', 'pid'], 'safe'],
    ]; }

    /** {@inheritdoc} */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CronLog::find()->orderBy('datetime_start DESC');

        // add conditions that should always apply here
        // ...

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'cron_id' => $this->cron_id,
            'duration' => $this->duration,
            'datetime_start' => $this->datetime_start,
            'datetime_complete' => $this->datetime_complete,
        ]);

        $query->andFilterWhere(['like', 'pid', $this->pid]);

        return $dataProvider;
    }
}