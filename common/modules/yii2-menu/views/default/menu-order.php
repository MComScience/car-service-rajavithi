<?php

use metronic\widgets\nestable\Nestable;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\Pjax;
use metronic\widgets\Modal;
use metronic\assets\BootboxAsset;
use metronic\widgets\datatables\DataTablesAsset;
use metronic\assets\ToastrAsset;
use kartik\icons\Icon;
use metronic\widgets\Table;

DataTablesAsset::register($this);
BootboxAsset::register($this);
ToastrAsset::register($this);

$this->title = "Mange Menu";
$this->params['breadcrumbs'][] = $this->title;
?>
    <style>
        .h-bg-navy-blue {
            background: #34495e;
        }
    </style>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sort Menu</h3>
                </div>
                <div class="panel-body">
                    <?php echo Html::button(Icon::show('save') . 'Save', ['class' => 'btn btn-success on-save-order']); ?>
                    <?php Pjax::begin(['id' => 'index-pjax']); ?>
                    <?php
                    echo Nestable::widget([
                        'type' => Nestable::TYPE_WITH_HANDLE,
                        //'query' => common\modules\user\models\Profile::find(),
                        'modelOptions' => [
                            'name' => 'name'
                        ],
                        'pluginEvents' => [
                            'change' => 'function(e) {
                                
                            }',
                            'dropCallback' => 'function(e) {
                                console.log(this);
                            }'
                        ],
                        'clientOptions' => [
                            'maxDepth' => 3,
                        ],
                        'items' => $items,
                        'options' => ['class' => 'dd', 'id' => 'nestable2'],
                        'handleLabel' => true,
                        'collapseAll' => true
                    ]);
                    ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Menu</h3>
                </div>
                <div class="panel-body">
                    <?php
                    echo Table::widget([
                        'tableOptions' => ['class' => 'table table-hover table-bordered', 'id' => 'tb-menu'],
                        'beforeHeader' => [
                            [
                                'columns' => [
                                    ['content' => '#', 'options' => ['style' => 'text-align: center;width: 35px;']],
                                    ['content' => 'ชื่อเมนู', 'options' => ['style' => 'text-align: center;']],
                                    ['content' => 'หมวดเมนู', 'options' => ['style' => 'text-align: center;']],
                                    ['content' => 'ภายใต้เมนู', 'options' => ['style' => 'text-align: center;']],
                                    ['content' => 'เรียง', 'options' => ['style' => 'text-align: center;']],
                                    ['content' => 'สถานะ', 'options' => ['style' => 'text-align: center;']],
                                    ['content' => 'ดำเนินการ', 'options' => ['style' => 'text-align: center;white-space: nowrap;']],
                                ],
                            ],
                        ],
                        'datatableOptions' => [
                            "clientOptions" => [
                                "dom" => "<'row'<'col-sm-6'f><'col-sm-6'l>><'row'<'col-xs-12 col-sm-12 col-md-12'tr>><'row'<'col-sm-6'i><'col-sm-6'p>>",
                                "ajax" => [
                                    "url" => Url::base(true) . "/menu/default/dt-data",
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
                                    "sSearch" => "_INPUT_ " . Html::a(Icon::show('plus') . ' Add Menu', ['create'], ['class' => 'btn btn-success', 'role' => 'modal-remote'])
                                ],
                                "pageLength" => 10,
                                "columns" => [
                                    ["data" => null, "defaultContent" => "", "className" => "text-center", "render" => new JsExpression ('function ( data, type, row, meta ) {
                                        return (meta.row + 1);
                                    }')],
                                    ["data" => "title"],
                                    ["data" => "cat_title", "className" => "text-center"],
                                    ["data" => "parent"],
                                    ["data" => "sort"],
                                    ["data" => "status"],
                                    ["data" => "actions", "className" => "text-center dt-head-nowrap nowrap", "orderable" => false],
                                ],
                                "drawCallback" => new JsExpression('
                                    function ( settings ) {
                                        var api = this.api();
                                        //api.initDeleteConfirm();
                                    }
                                '),
                                "initComplete" => new JsExpression('
                                    function(settings, json) {
                                        var api = this.api();
                                        //api.initSelect2();
                                        api.initColumnIndex();
                                        //api.rowGrouping();
                                    }
                                '),
                                "select2" => [2, 3, 4],
                                "rowGroup" => [
                                    "column" => 2,
                                    "rowOptions" => [
                                        "class" => "danger"
                                    ],
                                ]
                            ],
                            'clientEvents' => [
                                'error.dt' => 'function ( e, settings, techNote, message ){
                                    e.preventDefault();
                                    swal({title: \'Error...!\',html: \'<small>\'+message+\'</small>\',type: \'error\',});
                                }'
                            ]
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "footer" => "",
    'options' => ['class' => 'modal modal-danger', 'tabindex' => false,],
    'size' => 'modal-lg',
]);

Modal::end();
#Register JS
$this->registerJs(<<<JS

dt = {
    delete: function(key){
        bootbox.confirm({
            message: "คุณมั่นใจว่าต้องการลบข้อมูลนี้?",
            callback: function (result) {
                if(result){
                    $.ajax({
                        type: "POST",
                        url: '/menu/default/delete-menu',
                        data: {id: key},
                        success: function(data, textStatus ,jqXHR ){
                            dt_tbmenu.ajax.reload();
                            bootbox.alert(data);
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            bootbox.alert(errorThrown);
                        },
                    });
                }
            }
        });
    }
};
$("#index-pjax").on("pjax:success", function() {
    dt_tbmenu.ajax.reload();
});
$('button.on-save-order').on('click',function(e){
    e.preventDefault();
    var items = $('#nestable2').nestable('serialize');
    $.ajax({
        type: "POST",
        url: '/menu/default/save-menusort',
        data: {items: items},
        success: function(data, textStatus ,jqXHR ){
            bootbox.alert("Change Saved!");
        },
        error: function(jqXHR, textStatus, errorThrown){
            bootbox.alert(errorThrown);
        },
    });
});
JS
);
$this->registerJsFile(
    '@web/js/dataTables.api.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>