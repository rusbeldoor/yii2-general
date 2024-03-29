<?php

namespace rusbeldoor\yii2General\modules\cron\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use rusbeldoor\yii2General\models\Cron;

/**
 * CronSearch represents the model behind the search form of `rusbeldoor\yii2General\models\Cron`.
 */
class CronSearch extends Cron
{
    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['id', 'max_duration', 'restart', 'kill_process', 'active'], 'integer'],
        [['alias', 'description', 'status'], 'safe'],
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
        $query = Cron::find();

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
            'max_duration' => $this->max_duration,
            'restart' => $this->restart,
            'kill_process' => $this->kill_process,
            'active' => $this->active,
        ]);

        $query
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}