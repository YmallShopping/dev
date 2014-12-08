<?php
class Dan_Slider_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/slider?id=15 
    	 *  or
    	 * http://site.com/slider/id/15 	
    	 */
    	/* 
		$slider_id = $this->getRequest()->getParam('id');

  		if($slider_id != null && $slider_id != '')	{
			$slider = Mage::getModel('slider/slider')->load($slider_id)->getData();
		} else {
			$slider = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($slider == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$sliderTable = $resource->getTableName('slider');
			
			$select = $read->select()
			   ->from($sliderTable,array('slider_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$slider = $read->fetchRow($select);
		}
		Mage::register('slider', $slider);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}