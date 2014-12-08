<?php
class Dan_Productimport_Block_Adminhtml_Productimport extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_productimport';
    $this->_blockGroup = 'productimport';
    $this->_headerText = Mage::helper('productimport')->__('Import Manager');
    $this->_addButtonLabel = Mage::helper('productimport')->__('Add Import Profile');
    parent::__construct();
  }
}