<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 21:16
 */

use yii\helpers\Html;
use frontend\assets\AppAsset;
use metronic\assets\MetronicAssest;

// register scripts
AppAsset::register($this);
MetronicAssest::register($this);
// register metatag
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'โปรแกรมบริหารรถยนต์',
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => Yii::$app->name,
]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'MComScience',
]);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <link rel="shortcut icon" type="image/x-icon" href="<?= \Yii::getAlias('@web') ?>/imgs/favicon.ico"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?php echo Html::encode(!empty($this->title) ? strtoupper($this->title) . ' | ' . Yii::$app->name : Yii::$app->name); ?></title>
        <?php $this->head() ?>
    </head>
    <body class="<?= $class ?>">
    <?php $this->beginBody() ?>
    <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>