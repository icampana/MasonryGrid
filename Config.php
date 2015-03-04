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

/**
 * Class Config
 * @package Plugin\MasonryGrid
 */

class Config
{
    /**
     * Table name to store records
     */
    const TABLE_NAME = 'masonry_grid';

    /**
     * GRID config
     */
    public static function grid()
    {
        $gridConfig = array(
            'title' => 'Masonry Grid Items',
            'table' => Config::TABLE_NAME,
            'sortField' => 'itemOrder',
            'createPosition' => 'top',
            'createFilter' => function($data) {
                $data['widgetId'] = ipRequest()->getQuery('widgetId');
                return $data;
            },
            'fields' => array(
                array(
                    'label' => 'Title',
                    'field' => 'title',
                    'validators' => array('Required')
                ),
                array(
                    'label' => 'Image',
                    'field' => 'image',
                    'type' => 'RepositoryFile',
					'preview' => __CLASS__ . '::imageView',
					'fileLimit' => 1,
					'validators' => array('Required')
                ),
				array(
                    'label' => 'Description',
                    'field' => 'description',
                    'type' => 'RichText',
					'preview' => false,
                ),
				array(
                    'label' => 'Url',
                    'field' => 'url',
					'type' => 'Url',
					'preview' => false
                ),
                array(
                    'label' => 'Visible',
                    'field' => 'isVisible',
                    'type' => 'Checkbox',
                    'defaultValue' => 1
                )
            ),
        );
        return $gridConfig;
    }
	
	public static function imageView($value, $recordData)
    {
		$thumb_options = array('type' => 'fit', 'width' => 100, 'height' => 100);
		$thumbnail = ipFileUrl( ipReflection($value, $thumb_options) );
		
        return "<img src='{$thumbnail}' border='0'/>";
    }

}
