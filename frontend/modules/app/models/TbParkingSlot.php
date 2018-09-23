<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_parking_slot".
 *
 * @property int $parking_slot_id รหัสช่องจอด
 * @property string $parking_slot_number ช่องจอด
 */
class TbParkingSlot extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_parking_slot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parking_slot_number'], 'required'],
            [['parking_slot_number'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'parking_slot_id' => 'รหัสช่องจอด',
            'parking_slot_number' => 'ช่องจอด',
        ];
    }
}
