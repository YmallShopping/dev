<?php
class Dan_Slider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_slider';
    $this->_blockGroup = 'slider';
    $this->_headerText = Mage::helper('slider')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('slider')->__('Add Item');
    parent::__construct();
  }
}