<?php

namespace frontend\modules\app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use frontend\modules\app\models\TbDestination;
use frontend\modules\app\models\TbDestinationSearch;
use yii\data\ActiveDataProvider;

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

}
