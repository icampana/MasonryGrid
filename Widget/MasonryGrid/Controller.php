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

		$data['widgetId'] = $widgetId;
        $data['items'] = $items;
		
		// If it has not been configured yet, sets some default values
		if (empty($data['options'])){
			$data['options'] = array(
					'gutter' => 10,
					'columnWidth' => 320,
					'isFitWidth' => true
				);
		}

        return parent::generateHtml($revisionId, $widgetId, $data, $skin);
    }
    
    public function dataForJs($revisionId, $widgetId, $data, $skin)
    {
        $data['widgetId'] = $widgetId;
        
        return $data;
    }
    
    public function post($widgetId, $data)
    {
		$data = empty($data['options']) ?  array() : $data['options'];
		
        $form = new \Ip\Form();
        
        $form->setEnvironment(\Ip\Form::ENVIRONMENT_ADMIN);

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'columnWidth',
                    'label' => __('Column Width', 'MasonryGrid'),
                    'value' => empty($data['columnWidth']) ? '320' : $data['columnWidth']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Text(
                array(
                    'name' => 'gutter',
                    'label' => __('Gutter', 'MasonryGrid'),
                    'value' => empty($data['gutter']) ? '10' : $data['gutter']
                )
            )
        );

        $form->addField(new \Ip\Form\Field\Checkbox(
                array(
                    'name' => 'isFitWidth',
                    'label' => __('Fits to Width', 'MasonryGrid'),
                    'value' => empty($data['isFitWidth']) ? 0 : $data['isFitWidth']
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

