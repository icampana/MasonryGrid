<?php

// Put this into Controller.php

namespace Plugin\MasonryGrid\Widget\MasonryGrid;

use \Plugin\MasonryGrid\Model;

class Controller extends \Ip\WidgetController
{
    public function getTitle()
    {
        return __('Masonry Grid', 'MasonryGrid', false);
    }

    public function generateHtml($revisionId, $widgetId, $data, $skin)
    {

        $items = Model::widgetItems($widgetId);
		
		// If it has not been configured yet, sets some default values
		if (empty($data['options'])){
			$data['options'] = array(
					'gutter' => 10,
					'columnWidth' => 320,
					'isFitWidth' => true,
					'isOriginLeft' => true
				);
		}
		
		$image_options = array(
                         'type' => 'width',
                         'width' => ($data['options']['columnWidth'] - 10)
        );

		foreach($items as $key => $item){
			// Clean Up the URL
			$link = '';
			if ($item['url'] != ''){
				$protocol = parse_url($item['url'], PHP_URL_SCHEME);
				$target = '_self';
				$base_url = ipConfig()->baseUrl();
				
				// If it is an absolute URL don't make any transformation
				if ($protocol == 'http' or $protocol=='https'){
					$link = $item['url'];
					
					// If the URL is pointing to another domain, open in a new page.
					if (strpos($link, $base_url) === false){
						$target = '_blank';
					}
				} else {
					// Asume it is a reference to a local page
					$link = ipFileUrl($item['url']);
				}
				$items[$key]['link_target'] = $target;
			}
			$items[$key]['clean_url'] = $link;
			
			// Create Image path
			$items[$key]['image_url'] = ipFileUrl( ipReflection($item['image'], $image_options) );
		}
	
		$data['container_id'] = "masonry_wd_{$widgetId}";
	
		$data['widgetId'] = $widgetId;
		$data['items'] = $items;

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }
    
    public function dataForJs($revisionId, $widgetId, $data, $skin)
    {
        $data['widgetId'] = $widgetId;
        
		return parent::dataForJs($revisionId, $widgetId, $data, $skin);
    }
    
    public function post($widgetId, $data)
    {
		$config_data = empty($data['options']) ?  array() : $data['options'];
		
        $form = new \Ip\Form();
        
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'columnWidth',
                    'label' => __('Column Width', 'MasonryGrid'),
                    'value' => empty($config_data['columnWidth']) ? '320' : $config_data['columnWidth']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'gutter',
                    'label' => __('Gutter', 'MasonryGrid'),
                    'value' => empty($config_data['gutter']) ? '10' : $config_data['gutter']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Checkbox(
                array(
                    'name' => 'isFitWidth',
                    'label' => __('Fits to Width', 'MasonryGrid'),
                    'value' => empty($config_data['isFitWidth']) ? 0 : $config_data['isFitWidth']
                )
            )
        );
		
		$origin_options = array(
								array('left' , __('Left', 'MasonryGrid') ),
								array('right' ,__('Right', 'MasonryGrid') )
								);
		
		$form->addField(new \Ip\Form\Field\Select(
                array(
                    'name' => 'isOriginLeft',
                    'label' => __('From which side starts?', 'MasonryGrid'),
					'values' => $origin_options,
                    'value' => empty($config_data['isOriginLeft']) ? 'left' : $config_data['isOriginLeft']
                )
            )
        );
        
        $popup = ipView('snippet/edit.php', array('form' => $form))->render();
        
        return new \Ip\Response\Json(array(
            'popup' => $popup
        )); 
    }

    /**
     * Duplicate widget action
     *
     * This function is executed after the widget has been duplicated.
     * All widget data is duplicated automatically. This method is used only in case a widget
     * needs to do some maintenance tasks on duplication.
     *
     * @param int $oldId Old widget ID
     * @param int $newId Duplicated widget ID
     * @param array $data Data that has been duplicated from old widget to the new one
     * @return array
     */
    public function duplicate($oldId, $newId, $data)
    {
        $oldItems = Model::widgetItems($oldId, false);
        foreach($oldItems as $item) {
            $item['widgetId'] = $newId;

            unset($item['id']);
            Model::addItem($item);
        }
		
		return $data;
    }


    /**
     * Delete a widget
     *
     * This method is executed before actual deletion of a widget.
     * It is used to remove widget data (e.g., photos, files, additional database records and so on).
     * Standard widget data is being deleted automatically. So you don't need to extend this method
     * if your widget does not upload files or add new records to the database manually.
     * @param int $widgetId Widget ID
     * @param array $data Data that is being stored in the widget
     */
    public function delete($widgetId, $data)
    {
        Model::removeWidgetItems($widgetId);
    }
	
    public function adminHtmlSnippet()
    {
        $form = new \Ip\Form();
        
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        $form->addField(new \Ip\Form\Field\RichText(
                array(
                    'name' => 'description',
                    'label' => __('Description', 'MasonryGrid'),
                    'value' => null
                )
            )
        );

        $form->addField(new \Ip\Form\Field\RepositoryFile(
                array(
                    'name' => 'imagelink',
                    'label' => __( 'Image', 'MasonryGrid'),
                    'fileLimit' => 1,
                    'value' => empty($item['imagelink']) ? null : array($item['imagelink'])
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Url(
                array(
                    'name' => 'pagelink',
                    'label' => __('Page Url', 'MasonryGrid'),
                    'value' => null
                )
            )
        );
        
        return ipView('snippet/edit.php', array('form' => $form))->render();
    }
}

