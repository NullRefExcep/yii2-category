<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2016 NRE
 */


namespace nullref\category\assets;


use yii\web\AssetBundle;

class CategoryTreeAsset extends AssetBundle
{
    public $sourcePath = '@nullref/category/assets/category';
    public $js = [
        'jquery.mjs.nestedSortable.js',
        'tree.js',
    ];
    public $css = [
        'tree.css',
    ];
    public $depends = [
        'yii\jui\JuiAsset',
    ];
}