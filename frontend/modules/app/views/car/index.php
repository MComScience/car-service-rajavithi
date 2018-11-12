<?php
/* @var $this yii\web\View */

use frontend\assets\SocketIOAsset;
use kartik\icons\Icon;
use metronic\assets\ToastrAsset;
use metronic\widgets\Table;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\web\View;

SocketIOAsset::register($this);
ToastrAsset::register($this);

$this->title  = 'แผนกรถยนต์';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
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
    .mt-comments .mt-comment .mt-comment-body .mt-comment-details .mt-comment-actions {
        display: block;
    }
    .mt-comment-date {
        font-size: 1.3em;
    }
    .mt-action-dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        background-color: red;
        border-radius: 50%!important;
        margin-left: 5px;
        margin-right: 5px;
    }
    .mt-comment-status-waiting {
        color: #F1C40F;
    }
    table#tb-event-today tbody tr td {
        border-top: 1px solid #fff;
        border-bottom: 1.2px dashed #ddd;
    }
</style>
<div class="row">
    <div class="col-md-12 ">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title tabbable-line">
                <div class="caption">
                    <?= Icon::show('car') ?>
                    <span class="caption-subject bold uppercase"> <?= Html::encode($this->title) ?> </span>
                    <span class="caption-helper">

                    </span>
                </div>
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab1" data-toggle="tab" aria-expanded="true">
                            <?= Html::encode('รายการวันนี้') ?>
                            <span class="label label-sm label-success" id="count-tab1">0</span>
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
                        <div class="row">
                            <div class="col-md-5 col-md-offset-4">
                                <div class="md-radio-inline">
                                    <div class="md-radio has-warning">
                                        <input type="radio" id="radio1" name="radio-search" class="md-radiobtn" value="รอยืนยัน">
                                        <label for="radio1">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> รอยืนยัน </label>
                                    </div>
                                    <div class="md-radio has-info">
                                        <input type="radio" id="radio2" name="radio-search" class="md-radiobtn" value="ยืนยันแล้ว">
                                        <label for="radio2">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> ยืนยันแล้ว </label>
                                    </div>
                                    <div class="md-radio has-success">
                                        <input type="radio" id="radio3" name="radio-search" class="md-radiobtn" value="ออกแล้ว">
                                        <label for="radio3">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span> ออกแล้ว </label>
                                    </div>
                                    <button class="btn btn-sm red btn-outline on-clear-search"><i class="fa fa-repeat"></i>Reset</button>
                                </div>
                            </div>
                        </div>
                        <?php
                        echo Table::widget([
                            'tableOptions' => ['class' => 'table', 'id' => 'tb-event-today'],
                            'beforeHeader' => [
                                [
                                    'columns' => [
                                        ['content' => '<span>รายการวันนี้</span><span class="pull-right">เวลา</span>'],
                                    ],
                                ]
                            ],
                            /*'beforeHeader' => [
                                [
                                    'columns' => [
                                        ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                        ['content' => 'ปลายทาง', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => Icon::show('calendar') . 'วันที่', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => Icon::show('clock-o') . 'เวลาออก', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => Icon::show('user') . 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => '<i class="icon-speech"></i> หมายเหตุ', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;white-space: nowrap;']],
                                    ],
                                ],
                            ],*/
                            /*'afterHeader' => [
                                [
                                    'columns' => [
                                        ['content' => '', 'options' => ['style' => 'text-align: center;', 'colspan' => 4]],
                                        ['content' => 'พนักงานขับรถ', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                        ['content' => '', 'options' => ['style' => 'text-align: center;', 'colspan' => 2]],
                                    ],
                                ],
                            ],*/
                            'datatableOptions' => [
                                "clientOptions" => [
                                    "dom" => "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-xs-12 col-sm-12 col-md-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                                    "ajax" => [
                                        "url" => Url::base(true) . "/app/administrative/data-user-event-today",
                                        "type" => "GET",
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
                                    "pageLength" => -1,
                                    "ordering" => false,
                                    "columns" => [
                                        ["data" => "template","orderable" => false],
                                        /*["data" => "destination"],
                                        ["data" => "destination_date", "className" => "text-center", "type" => "date-uk"],
                                        ["data" => "destination_time", "className" => "text-center"],
                                        ["data" => "uname", "orderable" => false],
                                        ["data" => "parking_slot_number", "className" => "text-center", "orderable" => false],
                                        ["data" => "status_name", "className" => "text-center", "orderable" => false],
                                        ["data" => "comment"],
                                        ["data" => "actions", "className" => "text-center dt-head-nowrap nowrap", "orderable" => false],*/
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
                                    }'),
                                    "initComplete" => new JsExpression('
                                        function(settings, json) {
                                            var api = this.api();
                                            //api.initSelect2();
                                            //api.initColumnIndex();
                                        }
                                    '),
                                    /*
                                    "buttons" => [
                                        [
                                            "text" => Icon::show('refresh') . 'Reload',
                                            "action" => new JsExpression('function ( e, dt, node, config ) {
                                                this.processing( true );
                                                $(node).button(\'loading\');
                                                dt.ajax.reload();
                                            }'),
                                            "init" => new JsExpression('function ( dt, node, config ) {
                                                $(node).removeClass("dt-button")
                                                .addClass("btn btn-outline green");
                                            }'),
                                        ],
                                        [
                                            "text" => Icon::show('file-excel-o') . 'Excel',
                                            "extend" => "excel",
                                            "init" => new JsExpression('function ( dt, node, config ) {
                                                $(node).removeClass("dt-button")
                                                .addClass("btn btn-outline green");
                                            }'),
                                        ],
                                    ],*/
                                    "select2" => [4, 5, 6],
                                    /*"columnDefs" => [
                                        [ "visible" => false, "targets" => [6,7] ]
                                    ]*/
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
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/js/socket-client-api.js',
    ['depends' => [\yii\web\JqueryAsset::className(), SocketIOAsset::className()]]
);

$this->registerJs(<<<JS
socket.on('on-create', function(res){
    toastr.warning(res.length + ' รายการ', 'รายการใหม่!', {
        "timeOut": 7000,
        "positionClass": "toast-top-right",
        "progressBar": true,
        "closeButton": true,
    });
    dt_tbeventtoday.ajax.reload();
}).on('on-update', function(res){
    dt_tbeventtoday.ajax.reload();
}).on('on-confirm', function(res){
    dt_tbeventtoday.ajax.reload();
}).on('on-confirm-exit', function(res){
    dt_tbeventtoday.ajax.reload();
});

$('#tb-event-today tbody').on('click', 'tr td a', function (event) {
    event.preventDefault();
    var tr = $(this).closest("tr"),
        url = $(this).attr("href");
    if (tr.hasClass("child") && typeof dt_tbeventtoday.row(tr).data() === "undefined") {
        tr = $(this).closest("tr").prev();
    }
    var key = tr.data("key");
    var data = dt_tbeventtoday.row(tr).data();
    
    if ($(this).hasClass("on-confirm")) {
        swal({
            title: 'ยืนยันรายการ?',
            text: '',
            html: '<p>'+data.uname+'</p>' + '<small class="text-danger" style="font-size: 13px;">กด Enter เพื่อยืนยัน / กด Esc เพื่อยกเลิก</small>',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        method: "POST",
                        url: baseUrl + url,
                        dataType: "json",
                        data: {
                            data: data, //Data in column Datatable
                        },
                        success: function (response) {
                            dt_tbeventtoday.ajax.reload();
                            socket.emit('on-confirm', response); //sending data
                            resolve();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal({
                                type: 'error',
                                title: textStatus,
                                text: errorThrown,
                            });
                        }
                    });
                });
            },
        }).then((result) => {
            if (result.value) { //Confirm
                swal({
                    type: 'success',
                    title: 'ยืนยันรายการสำเร็จแล้ว!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }else if ($(this).hasClass("on-confirm-exit")) {
        swal({
            title: 'ยืนยันออกรถ?',
            text: '',
            html: '<p>'+data.uname+'</p>' + '<small class="text-danger" style="font-size: 13px;">กด Enter เพื่อยืนยัน / กด Esc เพื่อยกเลิก</small>',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            allowOutsideClick: false,
            showLoaderOnConfirm: true,
            preConfirm: function () {
                return new Promise(function (resolve, reject) {
                    $.ajax({
                        method: "POST",
                        url: baseUrl + url,
                        dataType: "json",
                        data: {
                            data: data, //Data in column Datatable
                        },
                        success: function (response) {
                            dt_tbeventtoday.ajax.reload();
                            socket.emit('on-confirm-exit', response); //sending data
                            resolve();
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal({
                                type: 'error',
                                title: textStatus,
                                text: errorThrown,
                            });
                        }
                    });
                });
            },
        }).then((result) => {
            if (result.value) { //Confirm
                swal({
                    type: 'success',
                    title: 'ยืนยันออกรถสำเร็จแล้ว!',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }
});

$('input[name="radio-search"]').on('click',function(e) {
    dt_tbeventtoday.columns( 0 ).search( $(this).val() ).draw();
});
$('button.on-clear-search').on('click',function(e) {
    dt_tbeventtoday.columns( 0 ).search( '' ).draw();
    $('input[name="radio-search"]').prop('checked', false);
});
JS
);
?>