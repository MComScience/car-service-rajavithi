<?php

namespace frontend\modules\app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\modules\app\models\TbDestination;
use frontend\modules\app\models\TbDestinationSearch;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Json;

class ReportController extends \yii\web\Controller
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
        $searchModel = new TbDestinationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAutocompleteList($q = null) {
        $query = new Query;
        $query->select('destination_name')
            ->from('tb_autocomplete')
            ->where('destination_name LIKE "%' . $q .'%"')
            ->orderBy('destination_name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['destination_name']];
        }
        echo Json::encode($out);
    }

}
