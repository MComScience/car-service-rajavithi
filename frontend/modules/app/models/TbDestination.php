<?php

namespace frontend\modules\app\models;

use common\components\DateConvert;
use metronic\behaviors\CoreMultiValueBehavior;
use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\behaviors\BlameableBehavior;
use metronic\user\models\Profile;

/**
 * This is the model class for table "tb_destination".
 *
 * @property int $destination_id
 * @property string $destination ปลายทาง
 * @property int $user_id พนักงานขับรถ
 * @property string $destination_date วันที่เดินทาง
 * @property string $destination_time เวลารถออก
 * @property int $parking_slot_id ช่องจอดรถ
 * @property string $status_id สถานะ
 * @property int $created_by ผู้บันทึก
 * @property string $created_at วันที่บันทึก
 * @property int $updated_by แก้ไขโดย
 * @property string $updated_at วันที่แก้ไข
 * @property string $confirm_at เวลายืนยัน
 * @property string $comment หมายเหตุ
 */
class TbDestination extends \yii\db\ActiveRecord
{
    public $from_date;
    public $to_date;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tb_destination';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],

            [
                'class' => BlameableBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_by', 'updated_by'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_by'],
                ],
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['destination_date'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['destination_date'],
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDb($event->sender[$event->data]);
                },
            ],
            [
                'class' => CoreMultiValueBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_AFTER_FIND => ['destination_date'],
                ],
                'value' => function ($event) {
                    return DateConvert::convertToDisplay($event->sender[$event->data]);
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['destination_date', 'destination_time', 'parking_slot_id'], 'unique', 'targetAttribute' => ['destination_date', 'destination_time', 'parking_slot_id']],
            [['destination', 'destination_date', 'destination_time', 'parking_slot_id'], 'required'],
            [['user_id', 'parking_slot_id', 'created_by', 'updated_by', 'status_id'], 'integer'],
            [['destination_date', 'created_at', 'updated_at', 'confirm_at'], 'safe'],
            [['destination', 'comment'], 'string', 'max' => 255],
//            ['destination_time', 'validateTime'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'destination_id' => 'Destination ID',
            'destination' => 'ปลายทาง',
            'user_id' => 'พนักงานขับรถ',
            'destination_date' => 'วันที่เดินทาง',
            'destination_time' => 'เวลารถออก',
            'parking_slot_id' => 'ช่องจอดรถ',
            'status_id' => 'สถานะ',
            'created_by' => 'ผู้บันทึก',
            'created_at' => 'วันที่บันทึก',
            'updated_by' => 'แก้ไขโดย',
            'updated_at' => 'วันที่แก้ไข',
            'confirm_at' => 'เวลายืนยัน',
            'comment' => 'หมายเหตุ',
        ];
    }

    public function getTbStatus()
    {
        return $this->hasOne(TbStatus::className(), ['status_id' => 'status_id']);
    }

    public function getTbParkingSlot()
    {
        return $this->hasOne(TbParkingSlot::className(), ['parking_slot_id' => 'parking_slot_id']);
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'user_id']);
    }

    public function validateTime($attribute, $params, $validator)
    {
        if ($this->$attribute < Yii::$app->formatter->asDate('now','php:H:i:s') && $this->isNewRecord) {
            $this->addError($attribute, 'ไม่สามารถลงเวลาย้อนหลังได้ เวลาปัจจุบัน '.Yii::$app->formatter->asDate('now','php:H:i'));
        }
    }
}
