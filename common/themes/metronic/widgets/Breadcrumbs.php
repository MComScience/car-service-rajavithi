<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 20/9/2561
 * Time: 22:06
 */
namespace metronic\widgets;

use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs as BaseBreadcrumbs;

class Breadcrumbs extends BaseBreadcrumbs
{
    protected function renderItem($link, $template)
    {
        $encodeLabel = ArrayHelper::remove($link, 'encode', $this->encodeLabels);
        if (array_key_exists('label', $link)) {
            $label = $encodeLabel ? Html::encode($link['label']) : $link['label'];
        } else {
            throw new InvalidConfigException('The "label" element is required for each link.');
        }
        if (isset($link['template'])) {
            $template = $link['template'];
        }
        if (isset($link['url'])) {
            $template = "<li>{link}<i class=\"fa fa-angle-right\"></i></li>\n";
            $options = $link;
            unset($options['template'], $options['label'], $options['url']);
            $link = Html::a($label, $link['url'], $options);
        } else {
            $link = $label;
        }

        return strtr($template, ['{link}' => $link]);
    }
}