<?php

class Dan_Productimport_Block_Adminhtml_Productimport_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

  public function __construct()
  {
      parent::__construct();
      $this->setId('productimport_tabs');
      $this->setDestElementId('edit_form');
      $this->setTitle(Mage::helper('productimport')->__('Profile Information'));
  }

  protected function _beforeToHtml()
  {
      $this->addTab('form_section', array(
          'label'     => Mage::helper('productimport')->__('Profile Information'),
          'title'     => Mage::helper('productimport')->__('Profile Information'),
          'content'   => $this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tab_form')->toHtml(),
      ));
      $_data = Mage::registry('productimport_data')->getData();
      if(isset($_data['filename']) && $_data['filename']!==''){
        $this->addTab('csv_info', array(
            'label'     => Mage::helper('productimport')->__('CSV Rules'),
            'title'     => Mage::helper('productimport')->__('CSV Rules'),
            'content'   => $this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tab_csv')->toHtml(),
        )); 
        $this->addTab('import', array(
            'label'     => Mage::helper('productimport')->__('Import Action'),
            'title'     => Mage::helper('productimport')->__('Import Action'),
            'content'   => $this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_tab_import')->toHtml(),
        ));
      }
      return parent::_beforeToHtml();
  }
}