<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/9/2561
 * Time: 20:50
 */

use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\Html;
use metronic\assets\SweetAlert2Asset;
use yii\web\View;
use yii\widgets\Pjax;
use frontend\assets\SocketIOAsset;
use metronic\assets\ToastrAsset;

SweetAlert2Asset::register($this);
SocketIOAsset::register($this);
ToastrAsset::register($this);

$this->title = 'ยืนยันรายการ';

$this->registerJs('var baseUrl = ' . Json::encode(Url::base(true)) . ';', View::POS_HEAD);
$this->registerJs('var data = ' . Json::encode($data) . ';', View::POS_HEAD);
?>
<style>
    .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        height: 100%;
    }
    .padding-v-md {
        margin-bottom: 5px;
        margin-bottom: 5px;
        width: 50%;
    }

    .line-dashed {
        background-color: transparent;
        border-bottom: 1px dashed #dee5e7 !important;
    }
</style>

<div class="row" style="height: 100%;">
    <div class="col-md-12" style="height: 100%;">
        <div class="mt-widget-3" style="height: 100%;">
            <div class="mt-head bg-green" style="margin-bottom: 0px;height: 100%;">

                <div class="mt-head-icon">
                    <i class="fa fa-car fa-2x"></i>
                </div>
                <div class="mt-head-desc">
                    <h3 class="mt-username">
                        <?= $data['uname']; ?> (<?= $data['tel']; ?>)
                    </h3>
                    <div class="padding-v-md center-block">
                        <div class="line line-dashed"></div>
                    </div>
                    <h4>ปลายทาง / เวลา</h4>
                    <p><i class="fa fa-hand-o-down fa-2x"></i></p>
                    <h4>
                        <?= $model->destination; ?> /
                        <i class="fa fa-clock-o"></i>
                        <?= Yii::$app->formatter->asDate($model['destination_time'], 'php:H:i') ?>
                    </h4>
                    <div class="padding-v-md center-block">
                        <div class="line line-dashed"></div>
                    </div>
                    <h4>ช่องจอด</h4>
                    <h2><?= $data['parking_slot_number'] ?></h2>
                    <div class="padding-v-md center-block">
                        <div class="line line-dashed"></div>
                    </div>
                </div>
                <span class="mt-head-date"> <?= Yii::$app->formatter->asDate('now', 'php:d/m/Y') ?> </span>
                <div class="mt-head-button">
                    <?php Pjax::begin(['id' => 'pjax-confirm']); ?>
                    <?php if ($model['status_id'] == 2): ?>
                    <?= Html::a('ยืนยัน', '#', [
                        'class' => 'btn btn-circle btn-outline white btn-lg on-confirm',
                            'onclick' => 'Metronic.onConfirm(this);',
                            'data-url' => Url::to(['/app/administrative/confirm', 'id' => $model['destination_id']])
                    ]) ?>
                    <?php elseif ($model['status_id'] == 3): ?>
                        <?= Html::a('ออกรถ', '#', [
                            'class' => 'btn btn-circle btn-outline white btn-lg on-confirm-exit',
                            'onclick' => 'Metronic.onConfirmExit(this);',
                            'data-url' => Url::to(['/app/administrative/confirm-exit', 'id' => $model['destination_id']])
                        ]) ?>
                    <?php else: ?>
                        <button type="button" class="btn btn-circle btn-outline white btn-lg">
                            <i class="fa fa-check"></i> ออกแล้ว
                        </button>
                    <?php endif; ?>
                    <?php Pjax::end(); ?>
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

$this->registerJS(<<<JS
Metronic = {
    onConfirm: function(e) {
        var url = $(e).data('url');
        swal({
            title: 'ยืนยันรายการ?',
            text: '',
            html: '<small class="text-danger" style="font-size: 13px;">กด Enter เพื่อยืนยัน / กด Esc เพื่อยกเลิก</small>',
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
                        data: {
                            data: data, //Data in column Datatable
                        },
                        dataType: "json",
                        success: function (response) {
                            //$.pjax.reload({container:'#pjax-confirm'});
                            socket.emit('on-confirm', response); //sending data
                            location.reload();
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
    },
    onConfirmExit: function(e) {
        var url = $(e).data('url');
        swal({
            title: 'ยืนยันออกรถ?',
            text: '',
            html: '<small class="text-danger" style="font-size: 13px;">กด Enter เพื่อยืนยัน / กด Esc เพื่อยกเลิก</small>',
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
                        data: {
                            data: data, //Data in column Datatable
                        },
                        dataType: "json",
                        success: function (response) {
                            //$.pjax.reload({container:'#pjax-confirm'});
                            socket.emit('on-confirm-exit', response); //sending data
                            location.reload();
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
}
socket.on('on-confirm', function(res){
    $.pjax.reload({container:'#pjax-confirm'});
}).on('on-confirm-exit', function(res){
    $.pjax.reload({container:'#pjax-confirm'});
});
JS
);
?>
