<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/9/2561
 * Time: 12:24
 */
use yii\helpers\Html;
use kartik\icons\Icon;
?>
<div class="mt-comments">
    <div class="mt-comment">
        <div class="mt-comment-img">
            <img src="<?= Yii::getAlias('@web').'/imgs/default-avatar.png' ?>" style="height: 45px;width: 45px;">
        </div>
        <div class="mt-comment-body">
            <div class="mt-comment-info">
                <span class="mt-comment-author">
                    <?= $model['uname'] ?>
                </span>
                <span class="mt-comment-date">
                    <i class="icon-clock"></i>
                    <?= $model['destination_date'] ?>
                    <?= Yii::$app->formatter->asDate($model['destination_time'],'php:H:i') ?> น.
                </span>
            </div>
            <div class="mt-comment-text">ปลายทาง: <?= $model['destination'] ?></div>
            <div class="mt-comment-text">ช่องจอด: <?= $model['parking_slot_number'] ?></div>
            <div class="mt-comment-details">
                <?php if ($model['status_id'] == 2): ?>
                    <span class="mt-comment-status mt-comment-status-waiting">
                        <?= Icon::show('hourglass-half fa-2x').' '.$model['status_name'] ?>
                    </span>
                <?php endif; ?>
                <?php if ($model['status_id'] == 3): ?>
                    <span class="mt-comment-status mt-comment-status-approved">
                        <?= Icon::show('check fa-2x').' '.$model['status_name'] ?>
                    </span>
                <?php endif; ?>
                <?php if ($model['status_id'] == 4): ?>
                    <span class="mt-comment-status mt-comment-status-rejected">
                        <?= Icon::show('car fa-2x').' '.$model['status_name'] ?>
                    </span>
                <?php endif; ?>
                <ul class="mt-comment-actions">
                    <li style="padding: 5px 5px;">
                        <div class="mt-action-buttons ">
                            <?php if ($model['status_id'] == 2): ?>
                            <?= Html::a(Icon::show('check').' ยืนยัน',['/app/administrative/confirm', 'id' => $model['destination_id']],['class' => 'btn btn-circle green btn-outline uppercase on-confirm','style' => 'width:160px;']) ?>
                            <?php endif; ?>
                            <?php if ($model['status_id'] == 3): ?>
                                <?= Html::a(Icon::show('car').' ออกรถ',['/app/administrative/confirm-exit', 'id' => $model['destination_id']],['class' => 'btn btn-circle blue btn-outline uppercase on-confirm-exit','style' => 'width:160px;']) ?>
                            <?php endif; ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
