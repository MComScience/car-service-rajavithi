<?php

namespace metronic\user\models;

use Yii;

/**
 * This is the model class for table "tb_prefix".
 *
 * @property int $prefix_id
 * @property string $prefix_name คำนำหน้า
 */
class TbPrefix extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_prefix';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['prefix_name'], 'required'],
            [['prefix_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'prefix_id' => 'Prefix ID',
            'prefix_name' => 'Prefix Name',
        ];
    }
}
