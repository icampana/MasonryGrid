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


class Event
{
    public static function ipBeforeController()
    {
		// Add elements that are necessary only in administration state
        if (ipIsManagementState()) {
            ipAddCss('assets/masonryGrid.css');
        }
		
		// Add Stylesheet
		ipAddCss('assets/masonryGridFront.css');
		
		// Add Javascript
		ipAddJs('assets/imagesloaded.pkgd.min.js');
		ipAddJs('assets/masonry.pkgd.min.js');
		ipAddJs('assets/masonryGrid.js');
    }
}
