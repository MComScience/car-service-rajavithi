<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/9/2561
 * Time: 15:28
 */
namespace frontend\modules\app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\modules\app\models\TbDestination;
use common\components\DateConvert;

/**
 * TbDestinationSearch represents the model behind the search form of `frontend\modules\app\models\TbDestination`.
 */
class TbDestinationSearch extends TbDestination
{
    public $name;
    public $from_date;
    public $to_date;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destination_id', 'user_id', 'parking_slot_id', 'status_id', 'created_by', 'updated_by'], 'integer'],
            [['destination', 'destination_date', 'destination_time', 'created_at', 'updated_at', 'confirm_at', 'comment','name','from_date','to_date'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels['name'] = 'พนักงานขับรถ';

        return $attributeLabels;
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

        $query = TbDestination::find()->orderBy([
            'destination_date' => SORT_ASC,
            'user_id' => SORT_ASC,
        ]);

        //$query->joinWith(['profile']);


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
            'destination' => $this->destination,
            'user_id' => $this->user_id,
            'comment' => $this->comment,
        ]);

        $query
            //->orFilterWhere(['like', 'profile.name', $this->name])
            //->orFilterWhere(['like', 'tb_parking_slot.parking_slot_number', $this->parking_slot_id])
            ->andFilterWhere(['like', 'parking_slot_id', $this->parking_slot_id])
            ->andFilterWhere(['like', 'destination_time', $this->destination_time]);
        if (isset($params['TbDestinationSearch']['from_date']) && isset($params['TbDestinationSearch']['to_date'])){
            $from_date = DateConvert::convertToDb($params['TbDestinationSearch']['from_date']);
            $to_date = DateConvert::convertToDb($params['TbDestinationSearch']['to_date']);
            $query->andFilterWhere(['between','destination_date',$from_date,$to_date]);
        }
        if (isset($this->destination_date)){
            $query->andFilterWhere([
                'destination_date' => DateConvert::convertToDb($this->destination_date)
            ]);
        }
        return $dataProvider;
    }
}