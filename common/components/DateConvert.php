<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/9/2561
 * Time: 22:47
 */
namespace common\components;

use yii\base\Component;

class DateConvert extends Component
{
    public static function convertToDb($date){
        $result = '';
        if(!empty($date) && $date != '0000-00-00'){
            $arr = explode("/", $date);
            $y = $arr[2] - 543;
            $m = $arr[1];
            $d = $arr[0];
            $result = "$y-$m-$d";
        }
        return $result;
    }

    public static function convertToDisplay($date){
        $result = '';
        if(!empty($date) && $date != '0000-00-00'){
            $arr = explode("-", $date);
            $y = $arr[0] + 543;
            $m = $arr[1];
            $d = $arr[2];
            $result = "$d/$m/$y";
        }
        return $result;
    }
}