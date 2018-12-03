<?php

namespace frontend\modules\app\controllers;

use frontend\modules\app\models\TbDestination;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CarController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['index', 'user-confirm','data-led'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [

                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUserConfirm($id)
    {
        $this->layout = 'main-confirm';
        $model = $this->findModel($id);
        $query = (new \yii\db\Query())
            ->select([
                'tb_destination.destination_id',
                'tb_destination.destination',
                'CONCAT(IFNULL(tb_prefix.prefix_name,\'\'),IFNULL(`profile`.first_name,\'\'),\' \',IFNULL(`profile`.last_name,\'\')) AS uname',
                'DATE_FORMAT(DATE_ADD(tb_destination.destination_date, INTERVAL 543 YEAR),\'%d/%m/%Y\') as destination_date',
                'tb_destination.destination_time',
                'tb_parking_slot.parking_slot_number',
                'tb_status.status_name',
                'tb_destination.status_id',
                'tb_destination.`comment`',
                '`profile`.tel'
            ])
            ->from('tb_destination')
            ->where([
                'tb_destination.destination_id' => $id,
                'tb_destination.status_id' => [2, 3, 4],
            ])
            ->innerJoin('`profile`', '`profile`.user_id = tb_destination.user_id')
            ->leftJoin('tb_prefix', 'tb_prefix.prefix_id = `profile`.prefix_id')
            ->innerJoin('tb_parking_slot', 'tb_parking_slot.parking_slot_id = tb_destination.parking_slot_id')
            ->innerJoin('tb_status', 'tb_status.status_id = tb_destination.status_id')
            ->orderBy(['tb_destination.destination_time' => SORT_ASC])
            ->one();
        return $this->render('user-confirm', [
            'model' => $model,
            'data' => $query,
        ]);
    }

    private function findModel($id)
    {
        $model = TbDestination::findOne($id);
        if ($model) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDataLed()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $rows = (new \yii\db\Query())
            ->select([
                'TIME_FORMAT(tb_destination.destination_time,\'%H:%i\') AS led_time',
                'tb_destination.destination as led_destination',
                'CONCAT(IFNULL(tb_prefix.prefix_name,\'\'),IFNULL(`profile`.first_name,\'\'),\' \',IFNULL(`profile`.tel,\'\')) AS led_username'
            ])
            ->from('tb_destination')
            ->innerJoin('`profile`','`profile`.user_id = tb_destination.user_id')
            ->leftJoin('tb_prefix', 'tb_prefix.prefix_id = `profile`.prefix_id')
            ->where('tb_destination.destination_date >= CURRENT_DATE AND tb_destination.destination_time >= CURRENT_TIME')
            ->andWhere(['tb_destination.status_id' => 3])
            ->orderBy([
                'tb_destination.destination_date' => SORT_ASC,
                'tb_destination.destination_time' => SORT_ASC
            ])
            ->limit(3)
            ->all();
        return [
            'data' => $rows,
            'count' => count($rows)
        ];
    }

}
