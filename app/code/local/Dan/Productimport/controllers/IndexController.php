<?php
class Dan_Productimport_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/productimport?id=15 
    	 *  or
    	 * http://site.com/productimport/id/15 	
    	 */
    	/* 
		$productimport_id = $this->getRequest()->getParam('id');

  		if($productimport_id != null && $productimport_id != '')	{
			$productimport = Mage::getModel('productimport/productimport')->load($productimport_id)->getData();
		} else {
			$productimport = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($productimport == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$productimportTable = $resource->getTableName('productimport');
			
			$select = $read->select()
			   ->from($productimportTable,array('productimport_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$productimport = $read->fetchRow($select);
		}
		Mage::register('productimport', $productimport);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}