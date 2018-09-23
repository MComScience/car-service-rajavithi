<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/9/2561
 * Time: 8:54
 */
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\icons\Icon;
?>
<?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL, 'id' => 'form-slot']); ?>
<div class="form-group">
    <?= Html::activeLabel($model,'parking_slot_number',['class' => 'col-sm-2 control-label']) ?>
    <div class="col-sm-8">
        <?= $form->field($model,'parking_slot_number',['showLabels' => false])->textInput([
            'placeholder' => 'ช่องจอด',
        ]) ?>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-10 text-right">
        <?= Html::button(Icon::show('close').' Close',['class' => 'btn btn-default','data-dismiss' => 'modal']) ?>
        <?= Html::submitButton(Icon::show('save').' Save',['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs(<<<JS
\$form = $('#form-slot');
\$form.on('beforeSubmit', function() {
    var data = \$form.serialize();
    var table = $('#tb-slot').DataTable();
    var \$btn = $('#form-slot button[type="submit"]');
    $(\$btn).button('loading');
    $.ajax({
        url: \$form.attr('action'),
        type: \$form.attr('method'),
        data: data,
        success: function (response) {
            // Implement successful
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
                $(\$form).trigger("reset");
            } else {
                $.each(response.validate, function(key, val) {
                    $(\$form).yiiActiveForm('updateAttribute', key, [val]);
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
    return false; // prevent default submit
});
JS
);
?>
