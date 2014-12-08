<?php
class Dan_Productimport_Block_Productimport extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getProductimport()     
     { 
        if (!$this->hasData('productimport')) {
            $this->setData('productimport', Mage::registry('productimport'));
        }
        return $this->getData('productimport');
        
    }
}