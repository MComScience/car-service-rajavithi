<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/9/2561
 * Time: 20:26
 */

use yii\helpers\Html;
use kartik\form\ActiveForm;
use metronic\widgets\dynamicform\DynamicFormWidget;
use kartik\icons\Icon;
use metronic\widgets\datepicker\DatePicker;
use kartik\widgets\TimePicker;
use kartik\widgets\Typeahead;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use metronic\user\models\Profile;
use frontend\modules\app\models\TbParkingSlot;
use yii\web\View;
use yii\helpers\Json;

$action = Yii::$app->controller->action->id;
$formatter = Yii::$app->formatter;
$today = $formatter->asDate('now', 'php:d/m/') . ($formatter->asDate('now', 'php:Y') + 543);
$this->registerJs('var today = ' . Json::encode($today) . ';', View::POS_HEAD);
$this->registerJs('var action = ' . Json::encode($action) . ';', View::POS_HEAD);
?>
<style>
    .modal-dialog {
        width: 90%;
    }

    .padding-v-md {
        margin-bottom: 5px;
    }

    .line-dashed {
        background-color: transparent;
        border-bottom: 1px dashed #dee5e7 !important;
    }

    .form-group {
        margin-bottom: 5px;
    }

    .swal2-container {
        z-index: 11000 !important;
    }
</style>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'dynamic-form']); ?>
<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
    'widgetBody' => '.container-items', // required: css class selector
    'widgetItem' => '.item', // required: css class
    'limit' => 10, // the maximum times, an element can be added (default 999)
    'min' => 0, // 0 or 1 (default 1)
    'insertButton' => '.add-item', // css class
    'deleteButton' => '.remove-item', // css class
    'model' => $models[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'destination',
        'user_id',
        'destination_date',
        'destination_time',
        'parking_slot_id',
        'comment',
    ],
]); ?>
<div class="portlet light">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="icon-speech font-red-sunglo"></i>
            <span class="caption-subject bold uppercase"> รายการ</span>
            <?php if ($action == 'create'): ?>
                <span class="caption-helper">หมายเหตุ! บันทึกได้มากสุดทีละ 10 รายการ</span>
            <?php endif; ?>
        </div>
        <div class="actions">
            <?php if ($action == 'create'): ?>
                <a href="javascript:;" class="btn btn-success add-item">
                    <i class="fa fa-plus"></i> เพิ่มรายการ
                </a>
            <?php endif; ?>
        </div>
    </div>
    <div class="portlet-body">
        <div class="container-items">
            <?php foreach ($models as $i => $model): ?>
                <div class="item"><!-- widgetItem -->
                    <div>
                        <?php if ($action == 'create'): ?>
                            <?= Html::tag('span', 'รายการที่ : ' . ($i + 1), ['class' => 'panel-title-item']); ?>

                            <div style="float: right;">
                                <?= Html::button(Icon::show('minus'), ['class' => 'remove-item btn btn-danger btn-xs']); ?>
                                <?= Html::button(Icon::show('plus'), ['class' => 'add-item btn btn-success btn-xs']); ?>
                            </div>
                        <?php endif; ?>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-body">
                        <?php
                        // necessary for update action.
                        if (!$model->isNewRecord) {
                            echo Html::activeHiddenInput($model, "[{$i}]destination_id");
                        }
                        ?>
                        <div class="form-group">
                            <?= Html::activeLabel($model, "[{$i}]destination_date", ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-4">
                                <?= $form->field($model, "[{$i}]destination_date", ['showLabels' => false])->widget(DatePicker::classname(), [
                                    'options' => [
                                        'placeholder' => 'วันที่...',
                                        'value' => $model->isNewRecord ? $formatter->asDate('now', 'php:d/m/') . ($formatter->asDate('now', 'php:Y') + 543) : $model['destination_date'],
                                    ],
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd/mm/yyyy',
                                        'language' => 'th',
                                        'todayHighlight' => true,
                                        'todayBtn' => true,
                                    ],
                                    'pluginEvents' => [
                                        'changeDate' => "function(e) {
                                            checkDuplicate(e);
                                        }",
                                    ],
                                ]); ?>
                            </div>

                            <?= Html::activeLabel($model, "[{$i}]destination_time", ['class' => 'col-sm-1 control-label']) ?>
                            <div class="col-sm-4">
                                <?= $form->field($model, "[{$i}]destination_time", ['showLabels' => false])->widget(TimePicker::classname(), [
                                    'options' => [
                                        'placeholder' => 'เวลา...',
                                    ],
                                    'readonly' => true,
                                    'pluginOptions' => [
                                        'showSeconds' => false,
                                        'showMeridian' => false,
                                        'minuteStep' => 10,
                                        'secondStep' => 5,
                                        //'defaultTime' => false,
                                    ],
                                    'pluginEvents' => [
                                        "update" => "function(e) {
                                            checkDuplicate(e);
                                        }",
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, "[{$i}]destination", ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-9">
                                <?= $form->field($model, "[{$i}]destination", ['showLabels' => false])->widget(Typeahead::classname(), [
                                    'options' => [
                                        'placeholder' => 'ปลายทาง...',
                                    ],
                                    'scrollable' => true,
                                    'pluginOptions' => ['highlight' => true, 'minLength' => 3],
                                    'dataset' => [
                                        [
                                            'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                            'display' => 'value',
                                            'prefetch' => Url::base(true) . '/app/administrative/destination-list',
                                            'remote' => [
                                                'url' => Url::to(['/app/administrative/destination-list']) . '?q=%QUERY',
                                                'wildcard' => '%QUERY'
                                            ]
                                        ]
                                    ]
                                ]); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <?= Html::activeLabel($model, "[{$i}]user_id", ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-9">
                                <?= $form->field($model, "[{$i}]user_id", ['showLabels' => false])->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(Profile::find()->asArray()->all(), 'user_id', 'name'),
                                    'options' => [
                                        'placeholder' => 'พนักงานขับรถ...',
                                    ],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($model, "[{$i}]parking_slot_id", ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-4">
                                <?= $form->field($model, "[{$i}]parking_slot_id", ['showLabels' => false])->widget(Select2::classname(), [
                                    'data' => ArrayHelper::map(TbParkingSlot::find()->asArray()->all(), 'parking_slot_id', 'parking_slot_number'),
                                    'options' => [
                                        'placeholder' => 'ช่องจอด...',
                                    ],
                                    'theme' => Select2::THEME_BOOTSTRAP,
                                    'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                    'pluginEvents' => [
                                        'change' => "function(e) {
                                            checkDuplicate(e);
                                        }"
                                    ]
                                ]); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <?= Html::activeLabel($model, "[{$i}]comment", ['class' => 'col-sm-2 control-label']) ?>
                            <div class="col-sm-9">
                                <?= $form->field($model, "[{$i}]comment", ['showLabels' => false])->textarea([
                                    'placeholder' => 'หมายเหตุ...',
                                    'rows' => 3,
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="padding-v-md">
                        <div class="line line-dashed"></div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
    <div class="form-actions noborder">
        <div class="form-group">
            <div class="col-sm-12 text-right">
                <?= Html::button(Icon::show('close') . ' Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
                <?= Html::submitButton(Icon::show('save') . ' Save', ['class' => 'btn btn-success on-submit', 'data-loading-text' => 'กำลังบันทึก...']) ?>
            </div>
        </div>
    </div>
</div>

<?php DynamicFormWidget::end(); ?>

<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    var indexs = [];
    jQuery(".dynamicform_wrapper .panel-title-item").each(function(index) {
        jQuery(this).html("รายการที่ : " + (index + 1));
        indexs.push(parseInt(index));
    });
    var lastid = Math.max.apply(null, indexs);
    if ($('#tbdestination-'+lastid+'-destination_date').val() == '') {
        $('#tbdestination-'+lastid+'-destination_date').val(today);
    } 
    jQuery('#tbdestination-'+lastid+'-parking_slot_id').on('change', function(e) {
        checkDuplicate(e);
    });
    jQuery('#tbdestination-'+lastid+'-destination_date-kvdate').on('changeDate', function(e) {
        checkDuplicate(e);
    });
    jQuery('#tbdestination-'+lastid+'-destination_time').on('hide.timepicker', function(e) {
        checkDuplicate(e);
    });
    initTypeahead(lastid);
    $('button.on-submit').prop('disabled', false);
});
$(".dynamicform_wrapper").on("afterDelete", function(e) {
    var title = jQuery(".dynamicform_wrapper").find('.panel-title-item');
     if (title.length == 0) {
         $('button.on-submit').prop('disabled', true);
     } 
});

function initTypeahead(id){
    var data = new Bloodhound({
        "datumTokenizer": Bloodhound.tokenizers.obj.whitespace('value'),
        "queryTokenizer": Bloodhound.tokenizers.whitespace,
        "prefetch": {"url": "http://q-car.local:8082/app/administrative/destination-list"},
        "remote": {"url": "/app/administrative/destination-list?q=%QUERY", "wildcard": "%QUERY"}
    });
    kvInitTA('tbdestination-'+id+'-destination', {"highlight":true,"minLength": 2}, [{
        "display": "value",
        "name": "tbdestination_"+id+"_destination_data_1",
        "source": data.ttAdapter()
    }]);
}

var \$form = $('#dynamic-form');
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    var table = $('#tb-car-today').DataTable();
    var \$btn = $('#dynamic-form button[type="submit"]');
    $(\$btn).button('loading');
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: data,
        dataType: 'json',
        success: function (response) {
            \$btn.button('reset');
            if (response.success){
                table.ajax.reload();
                $('#ajaxCrudModal').modal('hide');
                swal({
                    type: 'success',
                    title: 'บันทึกสำเร็จ!',
                    showConfirmButton: false,
                    timer: 2000
                });
                $('#calendar').fullCalendar( 'refetchEvents' );
                if (action == 'create'){
                    socket.emit('on-create', response.models);
                }else{
                   socket.emit('on-update', response.models); 
                }
                $(\$form).trigger("reset");
            } else {
                $.each(response.validate, function(key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
                });
            }
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
    return false; // prevent default submit
});

function checkDuplicate(elm) {
    if (action == 'create'){
        var index = elm.target.id.replace(/[^0-9]/g,'');
        var destination_date = $('#tbdestination-'+index+'-destination_date').val();
        var destination_time = $('#tbdestination-'+index+'-destination_time').val();
        var parking_slot_id = $('#tbdestination-'+index+'-parking_slot_id').val();
        $.ajax({
            url: 'check-duplicate',
            type: 'POST',
            data: {
                destination_date: destination_date,
                destination_time: destination_time,
                parking_slot_id: parking_slot_id,
            },
            dataType: 'json',
            success: function (response) {
                if (response.duplicate){
                    swal({
                        type: 'warning',
                        title: 'ช่องจอดไม่ว่าง!',
                        html: '<p class="text-danger">เนื่องจากมีรายการที่บันทึกช่วงเวลาและช่องจอดเดียวกันอยู่แล้ว...</p> กรุณาเลือกช่องจอดใหม่ หรือ ช่วงเวลาใหม่! ',
                    });
                }
            },
            error: function(jqXHR, errMsg) {
                swal({
                    type: 'error',
                    title: 'Oops...',
                    text: errMsg,
                });
            }
        });   
    }
}
JS
);
?>
