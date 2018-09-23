<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/9/2561
 * Time: 8:33
 */

use metronic\widgets\Table;
use yii\helpers\Html;
use kartik\icons\Icon;
use yii\helpers\Url;
use yii\web\JsExpression;

$this->title = 'ช่องจอด';
$this->params['breadcrumbs'][] = ['label' => 'ตั้งค่า','url' => '#'];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
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
</style>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-cogs"></i>
                    <span class="caption-subject bold uppercase"> <?= $this->title; ?></span>
                    <span class="caption-helper"></span>
                </div>
                <div class="actions">
                    <?= Html::a(Icon::show('plus') . ' เพิ่มรายการ', ['/app/settings/create-slot'], [
                        'class' => 'btn btn-circle btn-outline green',
                        'role' => 'modal-remote',
                        'title' => 'เพิ่มรายการ'
                    ]) ?>
                    <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"
                       data-original-title="" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                echo Table::widget([
                    'tableOptions' => ['class' => 'table table-striped table-hover table-bordered', 'id' => 'tb-slot'],
                    'beforeHeader' => [
                        [
                            'columns' => [
                                ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                ['content' => 'ช่องจอด', 'options' => ['style' => 'text-align: center;']],
                                ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;']],
                            ],
                        ],
                    ],
                    'datatableOptions' => [
                        "clientOptions" => [
                            "dom" => "<'row'<'col-sm-6'l><'col-sm-6'f>><'row'<'col-xs-12 col-sm-12 col-md-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                            "ajax" => [
                                "url" => Url::base(true) . "/app/settings/data-slot",
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
                            "pageLength" => 10,
                            "columns" => [
                                ["data" => "index", "className" => "text-center"],
                                ["data" => "parking_slot_number"],
                                ["data" => "actions", "className" => "text-center dt-head-nowrap nowrap", "orderable" => false],
                            ],
                            "drawCallback" => new JsExpression('function ( settings ) {
                                var api = this.api();
                                api.initDeleteConfirm();
                            }'),
                            "initComplete" => new JsExpression('
                                function(settings, json) {
                                    var api = this.api();
                                    api.initColumnIndex();
                                }
                            '),
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
        <!-- END Portlet PORTLET-->
    </div>
</div>
<?php
echo $this->render('modal');
?>
