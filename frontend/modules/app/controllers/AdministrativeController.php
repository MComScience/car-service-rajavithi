<?php

namespace frontend\modules\app\controllers;

use frontend\modules\app\models\TbAutocomplete;
use kartik\icons\Icon;
use metronic\widgets\tablecolumn\ActionTable;
use metronic\widgets\tablecolumn\ColumnData;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\web\NotFoundHttpException;
use frontend\modules\app\models\TbDestination;
use common\models\MultipleModel;
use common\components\DateConvert;
use metronic\fullcalendar\models\Event;
use yii\helpers\ArrayHelper;

class AdministrativeController extends \yii\web\Controller
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
                        'actions' => ['data-user-event-today', 'confirm', 'confirm-exit'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new TbDestination();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $request = \Yii::$app->request;
        $models = [new TbDestination()];
        $title = 'บันทึกรายการ';
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('_form', [
                        'models' => (empty($models)) ? [new TbDestination()] : $models
                    ]),
                    'footer' => '',
                ];
            } elseif ($request->post()) {
                $models = MultipleModel::createMultiple(TbDestination::classname(), $models, 'destination_id');
                MultipleModel::loadMultiple($models, $request->post());

                // validate models
                $valid = MultipleModel::validateMultiple($models);

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = true) {
                            foreach ($models as $model) {
                                $model->status_id = 2; //รอยืนยัน
                                if (!($flag = $model->save())) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $modelAuto = TbAutocomplete::findOne(['destination_name' => $model['destination']]);
                                if (!$modelAuto) {
                                    $modelAuto = new TbAutocomplete();
                                    $modelAuto->destination_name = $model['destination'];
                                    $modelAuto->save();
                                }
                            }
                        }
                        if ($flag) {
                            $messages = [];
                            foreach ($models as $model) {
                                $msg = Url::base(true) .
                                    Url::to(['/app/car/user-confirm', 'id' => $model['destination_id']]) .
                                    ' แจ้ง ' . $model->profile->name .
                                    ' เวลาเดินรถ ' . Yii::$app->formatter->asDate($model['destination_time'],'php:H:i') .' น.'.
                                    ' ไป ' .$model['destination'].
                                    ' กรุณายืนยันเพื่อรับทราบ!';
                                $messages[] = $msg;
                            }
                            foreach ($messages as $message) {
                                $this->sendLineNotify($message);
                            }
                            $transaction->commit();

                            return [
                                'success' => true,
                                'models' => $models
                            ];
                        } else {
                            return [
                                'success' => false,
                                'validate' => ActiveForm::validateMultiple($models)
                            ];
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'success' => false,
                        'validate' => ActiveForm::validateMultiple($models)
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'validate' => ActiveForm::validateMultiple($models)
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $request = \Yii::$app->request;
        $models = TbDestination::find()->where(['destination_id' => $id])->all();
        $title = 'แก้ไขรายการ';
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return [
                    'title' => $title,
                    'content' => $this->renderAjax('_form', [
                        'models' => (empty($models)) ? [new TbDestination()] : $models
                    ]),
                    'footer' => '',
                ];
            } elseif ($request->post()) {
                $models = MultipleModel::createMultiple(TbDestination::classname(), $models, 'destination_id');
                MultipleModel::loadMultiple($models, $request->post());

                // validate models
                $valid = MultipleModel::validateMultiple($models);

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if ($flag = true) {
                            foreach ($models as $model) {
                                $model->status_id = 2; //รอยืนยัน
                                if (!($flag = $model->save(false))) {
                                    $transaction->rollBack();
                                    break;
                                }
                                $modelAuto = TbAutocomplete::findOne(['destination_name' => $model['destination']]);
                                if (!$modelAuto) {
                                    $modelAuto = new TbAutocomplete();
                                    $modelAuto->destination_name = $model['destination'];
                                    $modelAuto->save();
                                }
                            }
                        }
                        if ($flag) {
                            $transaction->commit();
                            return [
                                'success' => true,
                                'models' => $models
                            ];
                        } else {
                            return [
                                'success' => false,
                                'validate' => ActiveForm::validateMultiple($models)
                            ];
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                } else {
                    return [
                        'success' => false,
                        'validate' => ActiveForm::validateMultiple($models)
                    ];
                }
            } else {
                return [
                    'status' => false,
                    'validate' => ActiveForm::validateMultiple($models)
                ];
            }
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionDestinationList($q = null)
    {
        $query = new Query;

        $query->select('destination_name')
            ->from('tb_autocomplete')
            ->where('destination_name LIKE "%' . $q . '%"')
            ->orderBy('destination_name');
        $command = $query->createCommand();
        $data = $command->queryAll();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['destination_name']];
        }
        echo Json::encode($out);
    }

    public function actionDataToday()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = (new \yii\db\Query())
                ->select([
                    'tb_destination.destination_id',
                    'tb_destination.destination',
                    '`profile`.`name` as uname',
                    'DATE_FORMAT(DATE_ADD(tb_destination.destination_date, INTERVAL 543 YEAR),\'%d/%m/%Y\') as destination_date',
                    'tb_destination.destination_time',
                    'tb_parking_slot.parking_slot_number',
                    'tb_status.status_name',
                    'tb_destination.status_id',
                    'tb_destination.`comment`'
                ])
                ->from('tb_destination')
                ->where(['tb_destination.destination_date' => Yii::$app->formatter->asDate('now', 'php:Y-m-d')])
                ->innerJoin('`profile`', '`profile`.user_id = tb_destination.user_id')
                ->innerJoin('tb_parking_slot', 'tb_parking_slot.parking_slot_id = tb_destination.parking_slot_id')
                ->innerJoin('tb_status', 'tb_status.status_id = tb_destination.status_id')
                ->orderBy(['tb_destination.destination_time' => SORT_ASC])
                ->all();

            $dataProvider = new ArrayDataProvider([
                'allModels' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'destination_id',
            ]);
            $columns = Yii::createObject([
                'class' => ColumnData::className(),
                'dataProvider' => $dataProvider,
                'formatter' => Yii::$app->formatter,
                'columns' => [
                    [
                        'attribute' => 'destination_id',
                    ],
                    [
                        'attribute' => 'destination',
                    ],
                    [
                        'attribute' => 'uname',
                    ],
                    [
                        'attribute' => 'destination_date',
                    ],
                    [
                        'attribute' => 'destination_time',
                        'format' => ['date', 'php:H:i'],
                    ],
                    [
                        'attribute' => 'parking_slot_number',
                    ],
                    [
                        'attribute' => 'comment',
                    ],
                    [
                        'attribute' => 'status_id',
                    ],
                    [
                        'attribute' => 'status_name',
                        'value' => function ($model, $key, $index) {
                            return $this->getBadgeStatus($model['status_id'], $model['status_name']);
                        },
                        'format' => 'raw',
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
                                return Url::to(['/app/administrative/update', 'id' => $key]);
                            }
                            if ($action == 'delete') {
                                return Url::to(['/app/administrative/delete', 'id' => $key]);
                            }
                        },
                        'visibleButtons' => [
                            'update' => function ($model, $key, $index) {
                                return !ArrayHelper::isIn($model['status_id'], [3, 4, 5]);
                            },
                            'delete' => function ($model, $key, $index) {
                                return !ArrayHelper::isIn($model['status_id'], [3, 4, 5]);
                            },
                        ],
                    ],
                ],
            ]);
            return ['data' => $columns->renderDataColumns()];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function getBadgeStatus($status, $name)
    {
        if ($status == 1 || $status == 2) {
            return Html::tag('span', $name, ['class' => 'label label-sm label-warning', 'style' => 'font-size: 1em;']);
        } elseif ($status == 3) {
            return Html::tag('span', $name, ['class' => 'label label-sm label-success', 'style' => 'font-size: 1em;']);
        } elseif ($status == 4) {
            return Html::tag('span', $name, ['class' => 'label label-sm label-info', 'style' => 'font-size: 1em;']);
        } elseif ($status == 5) {
            return Html::tag('span', $name, ['class' => 'label label-sm label-danger', 'style' => 'font-size: 1em;']);
        } else {
            return $name;
        }
    }

    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $this->findModel($id)->delete();
        return 'Deleted!';
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

    public function actionCheckDuplicate()
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = TbDestination::findOne([
                'destination_date' => DateConvert::convertToDb($request->post('destination_date')),
                'destination_time' => $request->post('destination_time') != null ? $request->post('destination_time') . ':00' : null,
                'parking_slot_id' => $request->post('parking_slot_id')
            ]);
            if ($model) {
                return [
                    'duplicate' => true,
                    'model' => $model,
                ];
            } else {
                return [
                    'duplicate' => false,
                ];
            }
        }
    }

    public function actionDataHistory()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = $request->post('TbDestination');
            $from_date = empty($data['from_date']) ? null : DateConvert::convertToDb($data['from_date']);
            $to_date = empty($data['to_date']) ? null : DateConvert::convertToDb($data['to_date']);
            $query = (new \yii\db\Query())
                ->select([
                    'tb_destination.destination_id',
                    'tb_destination.destination',
                    '`profile`.`name` as uname',
                    'DATE_FORMAT(DATE_ADD(tb_destination.destination_date, INTERVAL 543 YEAR),\'%d/%m/%Y\') as destination_date',
                    'tb_destination.destination_time',
                    'tb_parking_slot.parking_slot_number',
                    'tb_status.status_name',
                    'tb_destination.status_id',
                    'tb_destination.`comment`'
                ])
                ->from('tb_destination')
                ->where(['between', 'tb_destination.destination_date', $from_date, $to_date])
                ->innerJoin('`profile`', '`profile`.user_id = tb_destination.user_id')
                ->innerJoin('tb_parking_slot', 'tb_parking_slot.parking_slot_id = tb_destination.parking_slot_id')
                ->innerJoin('tb_status', 'tb_status.status_id = tb_destination.status_id')
                ->orderBy(['tb_destination.destination_date' => SORT_ASC])
                ->all();

            $dataProvider = new ArrayDataProvider([
                'allModels' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'destination_id',
            ]);
            $columns = Yii::createObject([
                'class' => ColumnData::className(),
                'dataProvider' => $dataProvider,
                'formatter' => Yii::$app->formatter,
                'columns' => [
                    [
                        'attribute' => 'destination_id',
                    ],
                    [
                        'attribute' => 'destination',
                    ],
                    [
                        'attribute' => 'uname',
                    ],
                    [
                        'attribute' => 'destination_date',
                    ],
                    [
                        'attribute' => 'destination_time',
                        'format' => ['date', 'php:H:i'],
                    ],
                    [
                        'attribute' => 'parking_slot_number',
                    ],
                    [
                        'attribute' => 'comment',
                    ],
                    [
                        'attribute' => 'status_name',
                        'value' => function ($model, $key, $index) {
                            return $this->getBadgeStatus($model['status_id'], $model['status_name']);
                        },
                        'format' => 'raw',
                    ],
                ],
            ]);
            return $columns->renderDataColumns();
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCalendarEvents($start, $end)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $formatter = Yii::$app->formatter;
        $start = $formatter->asDate($start, 'php:Y-m-d');
        $end = $formatter->asDate($end, 'php:Y-m-d');
        $query = (new \yii\db\Query())
            ->select([
                'tb_destination.destination_id',
                'tb_destination.destination',
                '`profile`.`name` as uname',
                'tb_destination.destination_date',
                'tb_destination.destination_time',
                'tb_parking_slot.parking_slot_number',
                'tb_status.status_name',
                'tb_destination.status_id',
                'tb_destination.`comment`'
            ])
            ->from('tb_destination')
            ->where(['between', 'tb_destination.destination_date', $start, $end])
            ->innerJoin('`profile`', '`profile`.user_id = tb_destination.user_id')
            ->innerJoin('tb_parking_slot', 'tb_parking_slot.parking_slot_id = tb_destination.parking_slot_id')
            ->innerJoin('tb_status', 'tb_status.status_id = tb_destination.status_id')
            ->orderBy(['tb_destination.destination_date' => SORT_ASC])
            ->all();
        $events = [];
        foreach ($query as $model) {
            $event = new Event();
            $event->setAttributes([
                'id' => $model['destination_id'],
                'title' => 'ปลายทาง : ' . $model['destination'] . ' พนักงานขับรถ : ' . $model['uname'],
                'description' => '<p style="margin-bottom: 0px;margin-top: 0px;">เวลา : '.Yii::$app->formatter->asDate($model['destination_time'],'php:H:i').'</p>'.'ปลายทาง : ' . $model['destination'] . ' <p style="margin-bottom: 0px;margin-top: 0px;"> พนักงานขับรถ : ' . $model['uname'] . '</p>',
                'start' => date('Y-m-d\TH:i:s\Z', strtotime($model['destination_date'] . ' ' . $model['destination_time'])),
                'end' => date('Y-m-d\TH:i:s\Z', strtotime($model['destination_date'] . ' ' . $model['destination_time'])),
            ]);
            $events[] = $event;
        }
        return $events;
    }

    public function actionDataUserEventToday()
    {
        $request = \Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $query = (new \yii\db\Query())
                ->select([
                    'tb_destination.destination_id',
                    'tb_destination.destination',
                    '`profile`.`name` as uname',
                    'DATE_FORMAT(DATE_ADD(tb_destination.destination_date, INTERVAL 543 YEAR),\'%d/%m/%Y\') as destination_date',
                    'tb_destination.destination_time',
                    'tb_parking_slot.parking_slot_number',
                    'tb_status.status_name',
                    'tb_destination.status_id',
                    'tb_destination.`comment`'
                ])
                ->from('tb_destination')
                ->where([
                    'tb_destination.destination_date' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                    'tb_destination.status_id' => [2, 3, 4],
                ])
                ->innerJoin('`profile`', '`profile`.user_id = tb_destination.user_id')
                ->innerJoin('tb_parking_slot', 'tb_parking_slot.parking_slot_id = tb_destination.parking_slot_id')
                ->innerJoin('tb_status', 'tb_status.status_id = tb_destination.status_id')
                ->orderBy(['tb_destination.destination_time' => SORT_ASC])
                ->all();

            $dataProvider = new ArrayDataProvider([
                'allModels' => $query,
                'pagination' => [
                    'pageSize' => false,
                ],
                'key' => 'destination_id',
            ]);
            $columns = Yii::createObject([
                'class' => ColumnData::className(),
                'dataProvider' => $dataProvider,
                'formatter' => Yii::$app->formatter,
                'columns' => [
                    [
                        'attribute' => 'destination_id',
                    ],
                    [
                        'attribute' => 'destination',
                    ],
                    [
                        'attribute' => 'uname',
                    ],
                    [
                        'attribute' => 'destination_date',
                    ],
                    [
                        'attribute' => 'destination_time',
                        'format' => ['date', 'php:H:i'],
                    ],
                    [
                        'attribute' => 'parking_slot_number',
                    ],
                    [
                        'attribute' => 'status_id',
                    ],
                    [
                        'attribute' => 'comment',
                    ],
                    [
                        'attribute' => 'status_name',
                        'value' => function ($model, $key, $index) {
                            return $this->getBadgeStatus($model['status_id'], $model['status_name']);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'template',
                        'value' => function($model, $key, $index){
                            return $this->renderAjax('_template',['model' => $model]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'class' => ActionTable::className(),
                        'template' => '{confirm} {exit}',
                        'buttons' => [
                            'confirm' => function ($url, $model, $key) {
                                return Html::a(Icon::show('check') . ' ยืนยัน', $url, [
                                    'class' => 'btn btn-circle btn-outline btn-lg blue on-confirm',
                                    'title' => 'ยืนยัน'
                                ]);
                            },
                            'exit' => function ($url, $model, $key) {
                                return Html::a(Icon::show('car') . ' ออกรถ', $url, [
                                    'class' => 'btn btn-circle btn-outline btn-lg green on-confirm-exit',
                                    'title' => 'ออกรถ'
                                ]);
                            },
                        ],
                        'urlCreator' => function ($action, $model, $key, $index) {
                            if ($action == 'confirm') {
                                return Url::to(['/app/administrative/confirm', 'id' => $key]);
                            }
                            if ($action == 'exit') {
                                return Url::to(['/app/administrative/confirm-exit', 'id' => $key]);
                            }
                        },
                        'visibleButtons' => [
                            'confirm' => function ($model, $key, $index) {
                                return !ArrayHelper::isIn($model['status_id'], [1, 3, 4, 5]);
                            },
                            'exit' => function ($model, $key, $index) {
                                return !ArrayHelper::isIn($model['status_id'], [1, 2, 4, 5]);
                            },
                        ],
                    ],
                ],
            ]);
            return ['data' => $columns->renderDataColumns()];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfirm($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $model->status_id = 3;
            $model->confirm_at = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
            if (!$model->save()) {
                throw new HttpException(422, Json::encode($model->errors));
            }
            return [
                'data' => $request->post('data'),
                'model' => $model,
            ];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionConfirmExit($id)
    {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $model->status_id = 4;
            if (!$model->save()) {
                throw new HttpException(422, Json::encode($model->errors));
            }
            return [
                'data' => $request->post('data'),
                'model' => $model,
            ];
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function sendLineNotify($message)
    {
        $line_api = 'https://notify-api.line.me/api/notify';
        $line_token = 'NVDni6LR0c5Kjwc2zVgsjZMgG9FpH39EJTvOu7KqXvB';

        $queryData = ['message' => $message];
        $queryData = http_build_query($queryData, '', '&');
        $headerOptions = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                    . "Authorization: Bearer " . $line_token . "\r\n"
                    . "Content-Length: " . strlen($queryData) . "\r\n",
                'content' => $queryData
            ]
        ];
        $context = stream_context_create($headerOptions);
        $result = file_get_contents($line_api, FALSE, $context);
        $res = Json::encode($result);
        return $res;
    }


}
