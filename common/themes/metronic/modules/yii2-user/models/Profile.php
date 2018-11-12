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

class Profile extends BaseProfile
{
    public $avatar;

    public function rules()
    {
        $rules = parent::rules();
        $rules[] = [['avatar','avatar_path','avatar_base_url'], 'safe'];
        $rules[] = [['profile_type_id'], 'safe'];
        return $rules;
    }

    public function behaviors()
    {
        return [
            'avatar-profile' => [
                'class' => UploadBehavior::className(),
                'attribute' => 'avatar',
                'pathAttribute' => 'avatar_path',
                'baseUrlAttribute' => 'avatar_base_url'
            ]
        ];
    }

    public function attributeLabels()
    {
        $labels = parent::attributeLabels();
        $labels['avatar'] = 'รูปประจำตัว';
        $labels['profile_type_id'] = 'ประเภทผู้ใช้งาน';
        return $labels;
    }

    public function getAvatar($default = '/imgs/default-avatar.png')
    {
        $cache = Yii::$app->cache;
        $key = 'avatar'.$this->user_id;
        $avatar = $cache->get($key);
        if($this->avatar_path && $avatar != false){
            return $avatar;
        }else{
            $path = $this->avatar_base_url . '/' . $this->avatar_path;
            if($this->avatar_path){
                $cache->set($key, $path, 60 * 60 * 1);
            }
            return $this->avatar_path
                ? Yii::getAlias($path)
                : $default;
        }
    }
     public function getProfileType()
    {
        return $this->hasOne(TbProfileType::className(), ['profile_type_id' => 'profile_type_id']);
    }
}