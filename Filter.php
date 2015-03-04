<?php

namespace Plugin\MasonryGrid;

class Filter
{
    public static function ipWidgetManagementMenu($optionsMenu, $widgetRecord)
    {
        // Tile-Widget
        if ($widgetRecord['name'] == 'MasonryGrid')
        {
            $optionsMenu[] = array(
                'title' => __('Settings', 'MasonryGrid', false),
                'attributes' => array(
                    'class' => '_edit ipsWidgetSettings'
                )
            );
        }
        
        return $optionsMenu;
    }
}