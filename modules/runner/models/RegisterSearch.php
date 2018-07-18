<?php

namespace ext\modules\runner\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RegisterSearch extends Register
{
    /**
     * {@inheritdoc}
     */
    public $fullName;
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'birthday', 'id_card', 'phone', 'email', 'club', 'emergency_name', 'emergency_phone', 'type_register', 'type_run', 'size_shirts', 'slip', 'address', 'house_no', 'soi', 'street', 'district', 'amphoe', 'province', 'zipcode', 'created_at', 'updated_at','fullName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Register::find()->where(['register_id'=>null]);

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
            'register_id' => $this->register_id,
            'sex' => $this->sex,
            'birthday' => $this->birthday,
            'status' => $this->status,
            'delivery_status' => $this->delivery_status,
            'send_status' => $this->send_status,
            'type_group' => $this->type_group,
        ]);
//        $query->andWhere('firstname LIKE "%' . $this->fullName . '%" ' .
//            'OR lastname LIKE "%' . $this->fullName . '%"'
//        );

        $query->andFilterWhere(['ilike', 'firstname', $this->firstname])
            ->andFilterWhere(['ilike', 'lastname', $this->lastname])
            ->andFilterWhere(['ilike', 'id_card', $this->id_card])
            ->andFilterWhere(['ilike', 'phone', $this->phone])
            ->andFilterWhere(['ilike', 'emergency_phone', $this->emergency_phone])
            ->andFilterWhere(['ilike', 'type_register', $this->type_register])
            ->andFilterWhere(['ilike', 'type_run', $this->type_run])
            ->andFilterWhere(['ilike', 'size_shirts', $this->size_shirts]);

        return $dataProvider;
    }
}
