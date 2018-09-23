<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_autocomplete".
 *
 * @property int $autocomplete_id
 * @property string $destination_name ปลายทาง
 */
class TbAutocomplete extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_autocomplete';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destination_name'], 'required'],
            [['destination_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'autocomplete_id' => 'Autocomplete ID',
            'destination_name' => 'ปลายทาง',
        ];
    }
}
