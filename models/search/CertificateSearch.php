<?php

namespace usesgraphcrt\certificate\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use usesgraphcrt\certificate\models\Certificate;

/**
 * CertificateCertificateSearch represents the model behind the search form of `app\models\CertificateCertificate`.
 */
class CertificateSearch extends Certificate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'owner_id','target_user'], 'integer'],
            [['code', 'type', 'created_at', 'date_elapsed', 'status','employment'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
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
        $query = Certificate::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'date_elapsed' => $this->date_elapsed,
            'owner_id' => $this->owner_id,
            'target_user' => $this->target_user,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'employment', $this->employment])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
