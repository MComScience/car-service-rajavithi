<?php

use yii\helpers\Html;
use kartik\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'layout' => '{items}',
    'caption' => $caption,
    'captionOptions' => [
        'style' => 'text-align:center;font-weight: bold;font-size:20px;',
     ],
    'columns' => [
        [
            'class' => '\kartik\grid\SerialColumn',
            'headerOptions' => [
               'style' => 'text-align:center',
            ],
            'contentOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'ปลายทาง',
            'attribute' => 'destination',
            'headerOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'พนักงานขับรถ',
            'attribute' => 'uname',
            'headerOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'วันที่เดินทาง',
            'attribute' => 'destination_date',
            'headerOptions' => [
               'style' => 'text-align:center',
            ],
            'contentOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'เวลารถออก',
            'attribute' => 'destination_time',
            'format' => ['date', 'php:H:i'],
            'headerOptions' => [
               'style' => 'text-align:center',
            ],
            'contentOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'ช่องจอดรถ',
            'attribute' => 'parking_slot_number',
            'headerOptions' => [
               'style' => 'text-align:center',
            ],
            'contentOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'สถานะ',
            'attribute' => 'status_name',
            'headerOptions' => [
               'style' => 'text-align:center',
            ],
            'contentOptions' => [
               'style' => 'text-align:center',
            ]
        ],
        [
            'header' => 'หมายเหตุ',
            'attribute' => 'comment',
            'headerOptions' => [
               'style' => 'text-align:center',
            ]
        ],
    ]
]);
?>
