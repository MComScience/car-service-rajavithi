<?php
/* @var $this yii\web\View */

use kartik\grid\GridView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\app\models\TbParkingSlot;
use metronic\user\models\Profile;

$this->title = 'รายงาน';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light ">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-bar-chart font-green-sharp"></i>
                    <span class="caption-subject font-green-sharp bold uppercase"><?= $this->title; ?></span>
                </div>
                <div class="actions">
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                       data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab_1_1" data-toggle="tab" aria-expanded="false">
                            <i class="fa fa-user"></i>
                            รายงานตัวบุคคล
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active in" id="tab_1_1">

                        <?php
                        echo $this->render('_search', ['model' => $searchModel]);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'panel' => [
                                'heading' => false,
                                'type' => 'success',
                                'before' => '',
                                'after' => '',
                                'footer' => ''
                            ],
                            'toolbar' => [
                                '{export}',
                                '{toggleData}'
                            ],
                            'pjax' => true,
                            'export' => [
                                'fontAwesome' => true
                            ],
                            'columns' => [
                                ['class' => '\kartik\grid\SerialColumn'],
                                [
                                    'attribute' => 'user_id',
                                    'value' => function ($model, $key, $index) {
                                        return empty($model->profile->fullname) ? '-' : $model->profile->fullname;
                                    },
                                    'group' => true,
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map((new \yii\db\Query())
                                            ->select(['CONCAT(IFNULL(tb_prefix.prefix_name,\'\'),IFNULL(`profile`.first_name,\'\'),\' \',IFNULL(`profile`.last_name,\'\')) AS uname','`profile`.user_id'])
                                            ->from('`profile`')
                                            ->leftJoin('tb_prefix','tb_prefix.prefix_id = `profile`.prefix_id')
                                            ->where(['`profile`.profile_type_id' => 3])
                                            ->all(), 'user_id', 'uname'),
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'พนักงานขับรถ', 'id' => 'select2-user_id'],
                                    'format' => 'raw'
                                ],
                                'destination',
                                [
                                    'label' => 'วัน',
                                    'attribute' => 'created_at',
                                    'format' => ['date', 'php:l'],
                                    'hAlign' => 'center',
                                ],
                                [
                                    'attribute' => 'destination_date',
                                    'hAlign' => 'center',
                                    'filterType' => GridView::FILTER_DATE,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'format' => 'dd/mm/yyyy',
                                            'todayHighlight' => true,
                                            'language' => 'th',
                                        ]
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'วันที่', 'id' => 'dt-destination_date','autocomplete' => 'off'],
                                ],
                                [
                                    'attribute' => 'destination_time',
                                    'hAlign' => 'center',
                                    'format' => ['date', 'php:H:i']
                                ],
                                [
                                    'attribute' => 'parking_slot_id',
                                    'value' => function ($model, $key, $index) {
                                        return $model->tbParkingSlot->parking_slot_number;
                                    },
                                    'hAlign' => 'center',
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filter' => ArrayHelper::map(TbParkingSlot::find()->asArray()->all(), 'parking_slot_id', 'parking_slot_number'),
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                        'theme' => Select2::THEME_BOOTSTRAP,
                                    ],
                                    'filterInputOptions' => ['placeholder' => 'ช่องจอดรถ', 'id' => 'select2-parking_slot_id'],
                                    'format' => 'raw'
                                ],
                                'comment',
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="tab-pane fade" id="tab_1_2">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>