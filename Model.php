<?php
/**
 * @package   ImpressPages
 */


/**
 * User: icampana
 * Date: 3/3/15
 * Time: 00:00 AM
 */

namespace Plugin\MasonryGrid;


class Model {

    public static function widgetItems($widgetId, $visibleOnly = true)
    {
        $params = array(
            'widgetId' => $widgetId
        );
        if ($visibleOnly) {
            $params['isVisible'] = 1;
        }
        return ipDb()->selectAll(Config::TABLE_NAME, '*', $params, ' ORDER BY `itemOrder` asc');
    }



    public static function addItem($data)
    {
        ipDb()->insert(Config::TABLE_NAME, $data);
    }

    public static function removeWidgetItems($widgetId)
    {
        return ipDb()->delete(Config::TABLE_NAME, array('widgetId' => $widgetId));
    }

}
