<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 22/9/2561
 * Time: 20:53
 */
use common\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\Html;
?>
<?php
$this->beginContent('@metronic/views/layouts/base.php', [
    'class' => 'page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-md'
]);
?>

    <!-- BEGIN CONTENT -->
    <div class="content">
        <!-- BEGIN CONTENT BODY -->
        <?= Alert::widget() ?>
        <?= $content ?>
        <!-- END CONTENT BODY -->
    </div>
    <!-- END CONTENT -->
<?php $this->endContent(); ?>