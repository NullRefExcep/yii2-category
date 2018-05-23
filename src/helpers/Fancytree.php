<?php
/**
 * @author    Dmytro Karpovych
 * @copyright 2018 NRE
 */


namespace nullref\category\helpers;


class Fancytree
{
    public static function getOptions($options = [])
{
    return array_merge([
        'checkbox' => true,
        'titlesTabbable' => true,
        'clickFolderMode' => 1,
        'extensions' => ["glyph", "edit", "wide"],
        'activeVisible' => true,
        'autoCollapse' => true,
        'glyph' => [
            'map' => [
                'doc' => "fa fa-file-o",
                'docOpen' => "fa fa-file",
                'checkbox' => "fa fa-square-o",
                'checkboxSelected' => "fa fa-check-square-o",
                'checkboxUnknown' => "fa fa-share",
                'error' => "fa fa-warning-sign",
                'expanderClosed' => "fa fa-plus-square-o",
                'expanderLazy' => "fa fa-spinner fa-spin",
                'expanderOpen' => "fa fa-minus-square-o",
                'folder' => "fa fa-folder-o",
                'folderOpen' => "fa fa-folder-open-o",
                'loading' => "fa fa-refresh",
            ]
        ],
    ], $options);
}
}