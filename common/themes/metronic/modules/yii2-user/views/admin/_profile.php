<?php
/*
 * This file is part of the Dektrium project
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\modules\app\models\TbProfileType;
use metronic\user\models\TbPrefix;
/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $user
 * @var dektrium\user\models\Profile $profile
 */
?>

<?php $this->beginContent('@dektrium/user/views/admin/update.php', ['user' => $user]) ?>

<?php
$form = ActiveForm::begin([
            'layout' => 'horizontal',
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'fieldConfig' => [
                'horizontalCssClasses' => [
                    'wrapper' => 'col-sm-9',
                ],
            ],
        ]);
?>
<?=
$form->field($profile, 'profile_type_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(TbProfileType::find()->asArray()->all(), 'profile_type_id', 'profile_type_name'),
    'options' => [
        'placeholder' => 'ประเภทผู้ใช้งาน...',
    ],
    'theme' => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?=
$form->field($profile, 'prefix_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(TbPrefix::find()->asArray()->all(), 'prefix_id', 'prefix_name'),
    'options' => [
        'placeholder' => 'คำนำหน้า...',
    ],
    'theme' => Select2::THEME_BOOTSTRAP,
    'pluginOptions' => [
        'allowClear' => true
    ],
]);
?>
<?= $form->field($profile, 'first_name') ?>
<?= $form->field($profile, 'last_name') ?>
<?= $form->field($profile, 'tel')->textInput(['maxLength' => 10]) ?>
<?= $form->field($profile, 'public_email') ?>
<?= $form->field($profile, 'website') ?>
<?= $form->field($profile, 'location') ?>
<?= $form->field($profile, 'gravatar_email') ?>
<?= $form->field($profile, 'bio')->textarea() ?>

<div class="form-group">
    <div class="col-lg-offset-3 col-lg-9">
<?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
</div>

<?php ActiveForm::end(); ?>

<?php $this->endContent() ?>
