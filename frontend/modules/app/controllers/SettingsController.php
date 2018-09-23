<?php

namespace frontend\modules\app\controllers;

use kartik\icons\Icon;
use metronic\widgets\tablecolumn\ActionTable;
use metronic\widgets\tablecolumn\ColumnData;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use frontend\modules\app\models\TbParkingSlot;
use yii\widgets\ActiveForm;

class SettingsController extends \yii\web\Controller
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
                    'delete-slot' => ['post']
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSlot()
    {
        return $this->render('slot');
    }

    public function actionDataSlot()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = (new \yii\db\Query())
                ->select([
                    'tb_parking_slot.*'
                ])
                ->from('tb_parking_slot')
                ->all();

            $dataProvider = new ArrayDataProvider([
                'allModels' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'parking_slot_id',
            ]);
            $columns = Yii::createObject([
                'class' => ColumnData::className(),
                'dataProvider' => $dataProvider,
                'formatter' => Yii::$app->formatter,
                'columns' => [
                    [
                        'attribute' => 'parking_slot_id',
                    ],
                    [
                        'attribute' => 'parking_slot_number',
                    ],
                    [
                        'class' => ActionTable::className(),
                        'template' => '{update} {delete}',
                        'updateOptions' => [
                            'title' => 'แก้ไข',
                            'class' => 'btn btn-outline btn-circle btn-sm green',
                            'label' => Icon::show('edit') . ' แก้ไข',
                            'role' => 'modal-remote',
                        ],
                        'deleteOptions' => [
                            'class' => 'btn btn-outline btn-circle red btn-sm blue',
                            'title' => 'ลบ',
                            'label' => Icon::show('trash') . ' ลบ'
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action == 'update') {
                                return Url::to(['/app/settings/update-slot', 'id' => $key]);
                            }
                            if ($action == 'delete') {
                                return Url::to(['/app/settings/delete-slot', 'id' => $key]);
                            }
                        },
                    ],
                ],
            ]);
            return ['data' => $columns->renderDataColumns()];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDeleteSlot($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        TbParkingSlot::findOne($id)->delete();
        return 'Deleted!';
    }

    public function actionCreateSlot()
    {
        $request = Yii::$app->request;
        $model = new TbParkingSlot();
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'บันทึกช่องจอด',
                    'content' => $this->renderAjax('_form_slot',[
                        'model' => $model,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'model' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model),
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdateSlot($id)
    {
        $request = Yii::$app->request;
        $model = TbParkingSlot::findOne($id);
        if (!$model){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => 'แก้ไขช่องจอด',
                    'content' => $this->renderAjax('_form_slot',[
                        'model' => $model,
                    ]),
                    'footer' => '',
                ];
            } elseif ($model->load($request->post()) && $model->save()) {
                return [
                    'success' => true,
                    'model' => $model,
                ];
            } else {
                return [
                    'success' => false,
                    'validate' => ActiveForm::validate($model),
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
