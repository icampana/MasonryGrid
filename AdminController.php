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


class AdminController
{

    /**
     * MasonryGrid.js ask to provide widget management popup HTML. This controller does this.
     * @return \Ip\Response\Json
     * @throws \Ip\Exception\View
     */
    public function widgetPopupHtml()
    {
        $versionParts = explode('.', \Ip\Application::getVersion());
        if (version_compare(\Ip\Application::getVersion(), '4.2.1') < 0) {
            return new \Ip\Response('This widget can be used on ImpressPages 4.2.1 or later.');
        }

        $widgetId = ipRequest()->getQuery('widgetId');
        $widgetRecord = \Ip\Internal\Content\Model::getWidgetRecord($widgetId);
        $widgetData = $widgetRecord['data'];

        $plugin = ipRoute()->plugin();

        //Render form and popup HTML
        $viewData = array(
            'gridUrl' => ipActionUrl(array('aa' => $plugin . '.grid', 'disableAdminNavbar' => 1, 'widgetId' => $widgetId))
        );
        $popupHtml = ipView('view/editPopup.php', $viewData)->render();
        $data = array(
            'popup' => $popupHtml
        );
        //Return rendered widget management popup HTML in JSON format
        return new \Ip\Response\Json($data);
    }


    /**
     * Check widget's posted data and return data to be stored or errors to be displayed
     */
    public function grid()
    {


        $widgetId = ipRequest()->getQuery('widgetId');

        ipAddCss('assets/masonryManagement.css');
        $config = Config::grid();


        if (!empty($widgetId)) {
            $config['filter'] = ' `widgetId` = ' . (int) $widgetId;
            $config['gatewayData'] = array('widgetId' => $widgetId);
        }
        return ipGridController($config);

    }
}
