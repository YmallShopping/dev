<?php
class Dan_Slider_Block_Adminhtml_Layers extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_layers';
    $this->_blockGroup = 'slider';
    $this->_headerText = Mage::helper('slider')->__('Layers Manager');
    $this->_addButtonLabel = Mage::helper('slider')->__('Add Layer');
    parent::__construct();
  }
}