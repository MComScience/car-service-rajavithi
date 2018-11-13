<?php

/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 23:16
 */

namespace metronic\user\models;

use trntv\filekit\behaviors\UploadBehavior;
use Yii;
use dektrium\user\models\Profile as BaseProfile;
use frontend\modules\app\models\TbProfileType;

class Profile extends BaseProfile {

    public $avatar;

    public function rules() {
        $rules = parent::rules();
        $rules[] = [['avatar', 'avatar_path', 'avatar_base_url'], 'safe'];
        $rules[] = [['profile_type_id'], 'safe'];
        $rules[] = ['tel', 'string', 'length' => 10];
        $rules[] = [[
        'first_name', 'last_name'
            ], 'string', 'max' => 255];
        $rules[] = ['prefix_id', 'integer'];
        return $rules;
    }

    public function behaviors() {
        return [
            'avatar-profile' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'avatar',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
            ]
        ];
    }

    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['avatar'] = 'รูปประจำตัว';
        $labels['profile_type_id'] = 'ประเภทผู้ใช้งาน';
        $labels['tel'] = 'เบอร์โทร';
        $labels['first_name'] = 'ชื่อ';
        $labels['last_name'] = 'นามสกุล';
        $labels['prefix_id'] = 'คำนำหน้า';
        return $labels;
    }

    public function getAvatar($default = '/imgs/default-avatar.png') {
        $cache = Yii::$app->cache;
        $key = 'avatar' . $this->user_id;
        $avatar = $cache->get($key);
        if ($this->avatar_path && $avatar != false) {
            return $avatar;
        } else {
            $path = $this->avatar_base_url . '/' . $this->avatar_path;
            if ($this->avatar_path) {
                $cache->set($key, $path, 60 * 60 * 1);
            }
            return $this->avatar_path ? Yii::getAlias($path) : $default;
        }
    }

    public function getProfileType() {
        return $this->hasOne(TbProfileType::className(), ['profile_type_id' => 'profile_type_id']);
    }

    public function getPrefix() {
        return $this->hasOne(TbPrefix::className(), ['prefix_id' => 'prefix_id']);
    }
    
    public function getFullname(){
        $prefix = $this->prefix;
        return (!empty($prefix) ? $prefix->prefix_name : '').$this->first_name.' '.$this->last_name;
    }

}
