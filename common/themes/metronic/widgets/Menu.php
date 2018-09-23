<?php
/**
 * Created by PhpStorm.
 * User: Tanakorn
 * Date: 21/9/2561
 * Time: 0:08
 */

namespace metronic\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\widgets\Menu as BaseMenu;
use kartik\icons\Icon;
use metronic\menu\models\Menu as BaseModelMenu;

class Menu extends BaseMenu
{
    public $key;

    public $linkTemplate = '<a href="{url}" class="nav-link">{icon}<span class="title">{label}</span></a>';

    public $submenuLinkTemplate = '<a href="{url}" class="nav-link nav-toggle">{icon}<span class="title">{label}</span><span class="arrow"></span></a>';

    public $submenuTemplate = "\n<ul class=\"sub-menu\">\n{items}\n</ul>\n";

    public $labelTemplate = '{label}';

    public function init()
    {
        $session = Yii::$app->session;
        $key = 'menus';
        $this->items = $session->has($key) ? $session->get($key) : false;
        if (Yii::$app->user->isGuest) {
            $session->remove($key);
            $this->items = [];
        } elseif ($this->items === false) {
            $query = BaseModelMenu::find()
                ->innerJoin('menu_category', 'menu.menu_category_id = menu_category.id')
                ->where([
                    'menu_category.title' => Yii::$app->id,
                    'menu.status' => '1',
                ])
                ->orderBy(['sort' => SORT_ASC])
                ->all();
            $models = [];
            $parents = [];
            foreach ($query as $model){
                if ($model['parent_id'] == null) {
                    $models[] = $model;
                }else{
                    $parents[] = $model;
                }
            }
            $parents = $parents ? ArrayHelper::index($parents, null, 'parent_id') : [];
            $menus = $this->getMenus($models, $parents);
            if ($menus && is_array($menus)) {
                $this->items = $menus;
            } else {
                $this->items = [];
            }
            $session->set($key, $this->items);
        }
    }

    protected function renderItems($items)
    {
        $n = count($items);
        $lines = [];
        foreach ($items as $i => $item) {
            $options = array_merge($this->itemOptions, ArrayHelper::getValue($item, 'options', []));
            $tag = ArrayHelper::remove($options, 'tag', 'li');
            $class = [];
            if ($item['active']) {
                $class[] = $this->activeCssClass;
            }
            if ($i === 0 && $this->firstItemCssClass !== null) {
                $class[] = $this->firstItemCssClass;
            }
            if ($i === $n - 1 && $this->lastItemCssClass !== null) {
                $class[] = $this->lastItemCssClass;
            }
            Html::addCssClass($options, $class);
            Html::addCssClass($options, 'nav-item');

            $menu = $this->renderItem($item);
            if (!empty($item['items'])) {
                $submenuTemplate = ArrayHelper::getValue($item, 'submenuTemplate', $this->submenuTemplate);
                $menu .= strtr($submenuTemplate, [
                    '{items}' => $this->renderItems($item['items']),
                ]);
            }
            $lines[] = Html::tag($tag, $menu, $options);
        }

        return implode("\n", $lines);
    }

    protected function renderItem($item)
    {
        if (isset($item['url'])) {
            $template = ArrayHelper::getValue($item, 'template', $this->linkTemplate);
            if (!empty($item['items'])) {
                $template = $this->submenuLinkTemplate;
            }

            return strtr($template, [
                '{url}' => Html::encode(Url::to($item['url'])),
                '{label}' => $item['label'],
                '{icon}' => isset($item['icon']) ? Icon::show($item['icon']) : '',
            ]);
        }

        $template = ArrayHelper::getValue($item, 'template', $this->labelTemplate);

        return strtr($template, [
            '{label}' => $item['label'],
        ]);
    }

    private function getMenus($models, $parents){
        $menus = [];
        foreach ($models as $model){
            $visible = false;
            $auth_items = Json::decode($model->auth_items);
            if (is_array($auth_items) && count($auth_items) > 0) {
                foreach ($auth_items as $item) {
                    if ($visible = Yii::$app->user->can($item)) {
                        break;
                    }
                }
            }
            $menus[] = [
                'label' => $model->title,
                'encode' => false,
                'icon' => $model->icon,
                'url' => ($model->router == '#') ? $model->router : [$model->router],
                'visible' => $visible,
                'items' => isset($parents[$model->id]) ? $this->getMenus($parents[$model->id], $parents) : [],
            ];
        }
        return $menus;
    }
}