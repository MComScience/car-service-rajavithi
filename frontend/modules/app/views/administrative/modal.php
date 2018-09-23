<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/9/2561
 * Time: 19:53
 */
use metronic\widgets\Modal;

Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",
    'options' => ['tabindex' => false],
    'size' => 'modal-lg',
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);

Modal::end();
?>