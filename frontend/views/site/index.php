<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
use metronic\fullcalendar\Fullcalendar;
use yii\web\JsExpression;
use metronic\assets\Qtip2Asset;

Qtip2Asset::register($this);

$this->title = 'หน้าหลัก';
?>
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN Portlet PORTLET-->
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-calendar font-yellow-casablanca"></i>
                    <span class="caption-subject bold font-yellow-casablanca uppercase"> รายการวันนี้ </span>
                    <span class="caption-helper"></span>
                </div>
            </div>
            <div class="portlet-body">
                <?= Fullcalendar::widget([
                    'options' => [
                        'id' => 'calendar',
                        'language' => 'th',
                    ],
                    'header' => [
                        'left' => 'prev,next today',
                        'center' => 'title',
                        'right' => 'month,basicWeek,agendaDay,listMonth'
                    ],
                    'clientOptions' => [
                        'locale' => 'th',
                        'selectable' => true,
                        'defaultView' => 'agendaDay',
                        'slotLabelFormat' => 'HH:mm',
                        'timeFormat' => 'HH:mm',
                        'eventRender' => new JsExpression("
                            function(event, element) {
                                element.qtip({
                                    content: event.description,
                                    position: {
                                        target: 'mouse',
                                        adjust: {
                                            scroll: true,
                                            resize: true
                                        }
                                    },
                                    style: {
                                        classes: 'qtip-bootstrap qtip-shadow'
                                    }
                                });
                            }
                        "),
                    ],
                    'events' => Url::to(['/app/administrative/calendar-events']),
                ]);
                ?>
            </div>
        </div>
        <!-- END Portlet PORTLET-->
    </div>
</div>
