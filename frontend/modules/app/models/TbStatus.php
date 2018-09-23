<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_status".
 *
 * @property int $status_id รหัสสถานะ
 * @property string $status_name ชื่อสถานะ
 */
class TbStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status_name'], 'required'],
            [['status_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'รหัสสถานะ',
            'status_name' => 'ชื่อสถานะ',
        ];
    }
}
