<?php

namespace rusbeldoor\yii2General\modules\platform\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use rusbeldoor\yii2General\models\Platform;

/**
 * PlatformSearch represents the model behind the search form of `rusbeldoor\yii2General\models\Platform`.
 */
class PlatformSearch extends Platform
{
    /** {@inheritdoc} */
    public function rules(): array
    { return [
        [['id'], 'integer'],
        [['alias', 'name'], 'safe'],
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
        $query = Platform::find();

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
        ]);

        $query
            ->andFilterWhere(['like', 'alias', $this->alias])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}