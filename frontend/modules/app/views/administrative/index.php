<?php
/* @var $this yii\web\View */

use kartik\icons\Icon;
use metronic\widgets\datepicker\DatePicker;
use yii\helpers\Html;
use metronic\widgets\Table;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\form\ActiveForm;
use metronic\fullcalendar\Fullcalendar;
use metronic\assets\Qtip2Asset;
use frontend\assets\SocketIOAsset;
use metronic\assets\ToastrAsset;

Qtip2Asset::register($this);
SocketIOAsset::register($this);
ToastrAsset::register($this);

$this->title = 'ฝ่ายบริหาร';
$this->params['breadcrumbs'][] = $this->title;

$formatter = Yii::$app->formatter;
$today = $formatter->asDate('now', 'php:d/m/') . ($formatter->asDate('now', 'php:Y') + 543);
?>
    <style>
        .portlet.light .dataTables_wrapper .dt-buttons {
            margin-top: auto;
            margin-right: 8px;
        }

        .dataTables_length {
            padding-right: 5px;
            float: left;
        }

        .dt-buttons {
            float: left !important;
        }

        .dataTables_filter {
            float: right !important;
        }
        .fc-basic-view .fc-body .fc-row {
            min-height: 100px;
        }
    </style>
    <div class="row">
        <div class="col-md-12 ">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light">
                <div class="portlet-title tabbable-line">
                    <div class="caption">
                        <?= Icon::show('user-o font-black') ?>
                        <span class="caption-subject bold font-black uppercase"> <?= Html::encode($this->title) ?> </span>
                        <span class="caption-helper">

                </span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab1" data-toggle="tab" aria-expanded="true">
                                <?= Icon::show('car') . ' ' . Html::encode('ตารางคิวรถวันนี้') ?>
                                <span class="label label-sm label-success" id="count-tab1">0</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#tab2" data-toggle="tab" aria-expanded="false">
                                <?= Icon::show('calendar') . ' ' . Html::encode('ประวัติรายการ') ?>
                                <span class="label label-sm label-success" id="count-tab2">0</span>
                            </a>
                        </li>
                    </ul>
                    <div class="actions">
                        <?php /* Html::a(Icon::show('plus').' Add','javascript:;',[
                        'class' => 'btn btn-circle blue btn-outline'
                ]); */ ?>
                    </div>
                </div>
                <div class="portlet-body">

                    <div class="tab-content">
                        <div class="tab-pane active" id="tab1">
                            <?php
                            echo Table::widget([
                                'tableOptions' => ['class' => 'table table-striped table-hover table-bordered', 'id' => 'tb-car-today'],
                                'beforeHeader' => [
                                    [
                                        'columns' => [
                                            ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                            ['content' => 'ปลายทาง', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => Icon::show('calendar') . 'วันที่', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => Icon::show('clock-o') . 'เวลาออก', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => Icon::show('user') . 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => Icon::show('phone') . 'เบอร์โทร', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => '<i class="icon-speech"></i> หมายเหตุ', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;white-space: nowrap;']],
                                        ],
                                    ],
                                ],
                                'afterHeader' => [
                                    [
                                        'columns' => [
                                            ['content' => '', 'options' => ['style' => 'text-align: center;', 'colspan' => 4]],
                                            ['content' => 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => '', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                            ['content' => '', 'options' => ['style' => 'text-align: center;', 'colspan' => 2]],
                                        ],
                                    ],
                                ],
                                'datatableOptions' => [
                                    "clientOptions" => [
                                        "dom" => "<'row'<'col-sm-6'l B><'col-sm-6'f>><'row'<'col-xs-12 col-sm-12 col-md-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                                        "ajax" => [
                                            "url" => Url::base(true) . "/app/administrative/data-today",
                                            "type" => "GET",
                                            "complete" => new JsExpression('function(jqXHR, textStatus) {
                                                var table = $(\'#tb-car-today\').DataTable();
                                                table.buttons(0).processing( false );
                                                $(table.buttons(0)[0].node).button("reset");
                                            }'),
                                        ],
                                        "deferRender" => true,
                                        "responsive" => true,
                                        "autoWidth" => false,
                                        "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                        "language" => [
                                            "zeroRecords" => "ไม่พบข้อมูล",
                                            "loadingRecords" => "กำลังโหลดข้อมูล...",
                                            "lengthMenu" => "_MENU_",
                                            "sSearch" => "ค้นหา: _INPUT_"
                                        ],
                                        "pageLength" => 10,
                                        "columns" => [
                                            ["data" => "index", "className" => "text-center"],
                                            ["data" => "destination"],
                                            ["data" => "destination_date", "className" => "text-center", "type" => "date-uk"],
                                            ["data" => "destination_time", "className" => "text-center"],
                                            ["data" => "uname","orderable" => false],
                                            ["data" => "tel", "className" => "text-center","orderable" => false],
                                            ["data" => "parking_slot_number", "className" => "text-center", "orderable" => false],
                                            ["data" => "status_name", "className" => "text-center", "orderable" => false],
                                            ["data" => "comment"],
                                            ["data" => "actions", "className" => "text-center dt-head-nowrap nowrap", "orderable" => false],
                                        ],
                                        "drawCallback" => new JsExpression('function ( settings ) {
                                            var api = this.api();
                                            var count  = api.data().count();
                                            $("#count-tab1").html(count);
                                            api.initDeleteConfirm();
                                            /*api.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
                                                var data = this.data();
                                                if(data.status_id == 3){
                                                    $(this.node()).addClass("success");
                                                }
                                                if(data.status_id == 4){
                                                    $(this.node()).addClass("info");
                                                }
                                            });*/
                                            api.initSelect2();
                                        }'),
                                        "initComplete" => new JsExpression('
                                            function(settings, json) {
                                                var api = this.api();
                                                api.initColumnIndex();
                                            }
                                        '),
                                        "buttons" => [
                                            [
                                                "text" => Icon::show('file-excel-o') . 'Excel',
                                                "extend" => "excel",
                                                "init" => new JsExpression('function ( dt, node, config ) {
                                                    $(node).removeClass("dt-button")
                                                    .addClass("btn btn-outline green-jungle");
                                                }'),
                                            ],
                                            [
                                                "text" => Icon::show('file-pdf-o') . 'PDF',
                                                "action" => new JsExpression('function ( e, dt, node, config ) {
                                                    window.open("/app/administrative/report-pdf");
                                                }'),
                                                "init" => new JsExpression('function ( dt, node, config ) {
                                                    $(node).removeClass("dt-button")
                                                    .addClass("btn btn-outline blue");
                                                }'),
                                            ],
                                            [
                                                "text" => Icon::show('refresh') . 'Reload',
                                                "action" => new JsExpression('function ( e, dt, node, config ) {
                                                    this.processing( true );
                                                    $(node).button(\'loading\');
                                                    dt.ajax.reload();
                                                }'),
                                                "init" => new JsExpression('function ( dt, node, config ) {
                                                    $(node).removeClass("dt-button")
                                                    .addClass("btn btn-outline red");
                                                }'),
                                            ],
                                            [
                                                "text" => Icon::show('plus') . 'เพิ่มรายการ',
                                                "action" => new JsExpression('function ( e, dt, node, config ) {
                                                
                                                }'),
                                                "init" => new JsExpression('function ( dt, node, config ) {
                                                    $(node).removeClass("dt-button")
                                                    .addClass("btn btn-outline green")
                                                    .attr("role", "modal-remote")
                                                    .attr("href", "/app/administrative/create");
                                                }'),
                                                "tag" => "a"
                                            ],
                                        ],
                                        "select2" => [4, 6, 7]
                                    ],
                                    'clientEvents' => [
                                        'error.dt' => 'function ( e, settings, techNote, message ){
                                        e.preventDefault();
                                        swal({title: \'Error...!\',html: \'<small>\'+message+\'</small>\',type: \'error\',});
                                    }'
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a href="#tab_1_1" data-toggle="tab"><i class="fa fa-list-alt"></i> ตาราง </a>
                                </li>
                                <li>
                                    <a href="#tab_1_2" data-toggle="tab"><i class="fa fa-calendar"></i> ปฏิทิน </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="tab_1_1">
                                    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'history-form']); ?>
                                    <div class="form-group">
                                        <?= Html::activeLabel($model, 'from_date', ['label' => 'วันที่', 'class' => 'col-sm-4 control-label']) ?>
                                        <div class="col-sm-4">
                                            <?php
                                            echo $form->field($model, 'from_date', ['showLabels' => false])->widget(DatePicker::classname(), [
                                                'options' => [
                                                    'placeholder' => 'Start date',
                                                    'readonly' => true,
                                                    'value' => $today
                                                ],
                                                'options2' => [
                                                    'placeholder' => 'End date',
                                                    'readonly' => true,
                                                    'value' => $today
                                                ],
                                                'attribute' => 'from_date',
                                                'attribute2' => 'to_date',
                                                'pluginOptions' => [
                                                    'autoclose' => true,
                                                    'format' => 'dd/mm/yyyy',
                                                    'language' => 'th',
                                                    'todayHighlight' => true,
                                                    'todayBtn' => true,
                                                ],
                                                'separator' => 'ถึงวันที่',
                                                'type' => DatePicker::TYPE_RANGE,
                                            ]);
                                            ?>
                                        </div>
                                        <div class="col-sm-4">
                                            <?= Html::submitButton('แสดงข้อมูล', ['class' => 'btn btn-primary']) ?>
                                        </div>
                                    </div>
                                    <?php ActiveForm::end(); ?>
                                    <?php
                                    echo Table::widget([
                                        'tableOptions' => ['class' => 'table table-striped table-hover table-bordered', 'id' => 'tb-history'],
                                        'beforeHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                                    ['content' => 'ปลายทาง', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => Icon::show('calendar') . 'วันที่', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => Icon::show('clock-o') . 'เวลา', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => Icon::show('user') . 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                                     ['content' => Icon::show('phone') . 'เบอร์โทร', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => '<i class="icon-speech"></i> หมายเหตุ', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'afterHeader' => [
                                            [
                                                'columns' => [
                                                    ['content' => '', 'options' => ['style' => 'text-align: center;', 'colspan' => 4]],
                                                    ['content' => 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => '', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                                    ['content' => '', 'options' => ['style' => 'text-align: center;']],
                                                ],
                                            ],
                                        ],
                                        'datatableOptions' => [
                                            "clientOptions" => [
                                                "dom" => "<'row'<'col-sm-6'l B><'col-sm-6'f>><'row'<'col-xs-12 col-sm-12 col-md-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                                                "deferRender" => true,
                                                "responsive" => true,
                                                "autoWidth" => false,
                                                "lengthMenu" => [[10, 25, 50, -1], [10, 25, 50, "All"]],
                                                "language" => [
                                                    "zeroRecords" => "ไม่พบข้อมูล",
                                                    "loadingRecords" => "กำลังโหลดข้อมูล...",
                                                    "lengthMenu" => "_MENU_",
                                                    "sSearch" => "ค้นหา: _INPUT_"
                                                ],
                                                "pageLength" => 10,
                                                "columns" => [
                                                    ["data" => "index", "className" => "text-center"],
                                                    ["data" => "destination"],
                                                    ["data" => "destination_date", "className" => "text-center", "type" => "date-uk"],
                                                    ["data" => "destination_time", "className" => "text-center"],
                                                    ["data" => "uname", "orderable" => false],
                                                    ["data" => "tel", "className" => "text-center","orderable" => false],
                                                    ["data" => "parking_slot_number", "className" => "text-center", "orderable" => false, "title" => "ช่องจอด"],
                                                    ["data" => "status_name", "className" => "text-center", "orderable" => false, "title" => "สถานะ"],
                                                    ["data" => "comment"],
                                                ],
                                                "drawCallback" => new JsExpression('function ( settings ) {
                                                    var api = this.api();
                                                    var count  = api.data().count();
                                                    $("#count-tab2").html(count);
                                                }'),
                                                "initComplete" => new JsExpression('
                                                    function(settings, json) {
                                                        var api = this.api();
                                                        api.initColumnIndex();
                                                    }
                                                '),
                                                "buttons" => [
                                                    [
                                                        "text" => Icon::show('file-excel-o text-success') . 'Excel',
                                                        "extend" => "excel",
                                                        "init" => new JsExpression('function ( dt, node, config ) {
                                                            $(node).removeClass("dt-button")
                                                            .addClass("btn btn-outline green-jungle");
                                                        }'),
                                                    ],
                                                   [
                                                        "text" => Icon::show('file-pdf-o') . 'PDF',
                                                        "action" => new JsExpression('function ( e, dt, node, config ) {
                                                            window.open("/app/administrative/report-history-pdf?from_date="+$("#tbdestination-from_date").val()+"&to_date="+$("#tbdestination-to_date").val());
                                                        }'),
                                                        "init" => new JsExpression('function ( dt, node, config ) {
                                                            $(node).removeClass("dt-button")
                                                            .addClass("btn btn-outline blue");
                                                        }'),
                                                    ],
                                                    [
                                                        "text" => Icon::show('refresh') . 'Reload',
                                                        "action" => new JsExpression('function ( e, dt, node, config ) {
                                                            this.processing( true );
                                                            onLoadHistory();
                                                        }'),
                                                        "init" => new JsExpression('function ( dt, node, config ) {
                                                            $(node).removeClass("dt-button")
                                                            .addClass("btn btn-outline red");
                                                        }'),
                                                    ],
                                                ],
                                                "select2" => [4, 6, 7],
                                                "order" => [[2, 'asc'], [3, 'asc']]
                                            ],
                                            'clientEvents' => [
                                                'error.dt' => 'function ( e, settings, techNote, message ){
                                                    e.preventDefault();
                                                    swal({title: \'Error...!\',html: \'<small>\'+message+\'</small>\',type: \'error\',});
                                                }'
                                            ],
                                        ],
                                    ]);
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="tab_1_2">
                                    <?= Fullcalendar::widget([
                                        'options' => [
                                            'id' => 'calendar',
                                            'language' => 'th',
                                        ],
                                        'header' => [
                                            'left' => 'prev,next today',
                                            'center' => 'title',
                                            'right' => 'month,basicWeek,agendaDay,listMonth'
                                        ],
                                        'clientOptions' => [
                                            'locale' => 'th',
                                            'selectable' => true,
                                            'defaultView' => 'month',
                                            'slotLabelFormat' => 'HH:mm',
                                            'timeFormat' => 'HH:mm',
                                            'eventRender' => new JsExpression("
                                                function(event, element) {
                                                    element.qtip({
                                                        content: event.description,
                                                        position: {
                                                            target: 'mouse',
                                                            adjust: {
                                                                scroll: true,
                                                                resize: true
                                                            }
                                                        },
                                                        style: {
                                                            classes: 'qtip-bootstrap qtip-shadow'
                                                        }
                                                    });
                                                }
                                            "),
                                        ],
                                        'events' => Url::to(['/app/administrative/calendar-events']),
                                    ]);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
echo $this->render('modal');

// register js
$this->registerJs(<<<JS
var \$form = $('#history-form');
\$form.on('beforeSubmit', function() {
    onLoadHistory();
    return false;
});

function onLoadHistory(){
    var data = \$form.serialize();
    var \$btn = $('#history-form button[type="submit"]');
    $(\$btn).button('loading');
    $.ajax({
        url: '/app/administrative/data-history',
        type: \$form.attr('method'),
        data: data,
        success: function (data) {
            \$btn.button('reset');
            dt_tbhistory.rows().remove().draw();
            dt_tbhistory.rows.add(data).draw();
            dt_tbhistory.buttons(0).processing( false );
            dt_tbhistory.initSelect2();
        },
        error: function(jqXHR, errMsg) {
            \$btn.button('reset');
            swal({
                type: 'error',
                title: 'Oops...',
                text: errMsg,
            });
        }
    });
}

// socket event
$(function() {
    socket.on('on-create', function(res){
        dt_tbcartoday.ajax.reload();
    }).on('on-update', function(res){
        dt_tbcartoday.ajax.reload();
    }).on('on-confirm', function(res){
        toastr.success(res.data.uname, 'มีการยืนยันรายการ!', {
            "timeOut": 7000,
            "positionClass": "toast-top-right",
            "progressBar": true,
            "closeButton": true,
        });
        dt_tbcartoday.ajax.reload();
    }).on('on-confirm-exit', function(res){
        toastr.success(res.data.uname, 'มีการยืนยันออกรถ!', {
            "timeOut": 7000,
            "positionClass": "toast-top-right",
            "progressBar": true,
            "closeButton": true,
        });
        dt_tbcartoday.ajax.reload();
    });
});

// ready load
onLoadHistory();
JS
);
$this->registerJsFile(
    '@web/js/socket-client-api.js',
    ['depends' => [\yii\web\JqueryAsset::className(), SocketIOAsset::className()]]
);
?>