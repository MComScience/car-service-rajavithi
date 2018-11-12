<?php

namespace frontend\modules\app\models;

use Yii;

/**
 * This is the model class for table "tb_profile_type".
 *
 * @property int $profile_type_id รหัสประเภทผู้ใช้งาน
 * @property string $profile_type_name ชื่อประเภทผู้ใช้งาน
 */
class TbProfileType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_profile_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['profile_type_name'], 'required'],
            [['profile_type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'profile_type_id' => 'Profile Type ID',
            'profile_type_name' => 'Profile Type Name',
        ];
    }
}
