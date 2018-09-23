<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 23/9/2561
 * Time: 15:32
 */

use kartik\widgets\Typeahead;
use metronic\widgets\datepicker\DatePicker;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use frontend\modules\app\models\TbAutocomplete;
use yii\helpers\ArrayHelper;
use metronic\user\models\Profile;
use kartik\widgets\Select2;
use yii\helpers\Url;
?>
<div class="tb-destination-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'autocomplete' => 'off'
        ]
    ]); ?>

    <?php
    echo $form->field($model, 'from_date', ['showLabels' => false])->widget(DatePicker::classname(), [
        'options' => [
            'placeholder' => 'Start date',
            'readonly' => true,
        ],
        'options2' => [
            'placeholder' => 'End date',
            'readonly' => true,
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

    <?php
    //$dataAutocomplete = TbAutocomplete::find()->all();
    echo $form->field($model, 'destination')->widget(Typeahead::classname(), [
        'options' => ['placeholder' => 'ปลายทาง...'],
        'scrollable' => true,
        'pluginOptions' => ['highlight' => true],
        'dataset' => [
            [
                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                'display' => 'value',
                'prefetch' => Url::to(['autocomplete-list']),
                'remote' => [
                    'url' => Url::to(['autocomplete-list']) . '?q=%QUERY',
                    'wildcard' => '%QUERY'
                ]
            ]
        ]
    ]);
    ?>

    <?= $form->field($model, 'user_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Profile::find()->asArray()->all(), 'user_id', 'name'),
        'options' => ['placeholder' => 'พนักงานขับรถ ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
        'theme' => Select2::THEME_BOOTSTRAP,
    ]); ?>

    <?php // echo $form->field($model, 'comment') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Reset', ['index'], ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>