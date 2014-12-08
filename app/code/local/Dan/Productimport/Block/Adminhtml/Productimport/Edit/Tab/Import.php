<?php

class Dan_Productimport_Block_Adminhtml_Productimport_Edit_Tab_Import extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $_data = Mage::registry('productimport_data')->getData();
      $_collection = Mage::getModel('productimport/productimport')->getCsvCollection($_data['filename']);

      $fieldset = $form->addFieldset('productimport_form', array('legend'=>Mage::helper('productimport')->__('Import Action - %s products in CSV',count($_collection))));  

      $field = $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('productimport')->__('Run Ajax Import'),
          'name'      => 'title',
      ));
      $field->setRenderer($this->getLayout()->createBlock('productimport/adminhtml_productimport_edit_renderer_import'));

      if ( Mage::getSingleton('adminhtml/session')->getProductimportData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getProductimportData());
          Mage::getSingleton('adminhtml/session')->setProductimportData(null);
      } elseif ( Mage::registry('productimport_data') ) {
          $form->setValues(Mage::registry('productimport_data')->getData());
      }
      return parent::_prepareForm();
  }
}