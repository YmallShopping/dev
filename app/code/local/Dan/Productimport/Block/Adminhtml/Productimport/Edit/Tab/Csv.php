<?php

class Dan_Productimport_Block_Adminhtml_Productimport_Edit_Tab_Csv extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);

      $_data = Mage::registry('productimport_data')->getData();
      $_collection = Mage::getModel('productimport/productimport')->getCsvCollection($_data['filename']);

      $fieldset = $form->addFieldset('productimport_form', array('legend'=>Mage::helper('productimport')->__('CSV information - %s products in CSV',count($_collection))));    

      foreach ($_collection as $key => $value) {
        foreach ($value as $keyItem => $item) {
          if($keyItem){
              $fieldset->addField(Mage::getModel('productimport/productimport')->formatForId($keyItem), 'select', array(
                  'label'     => Mage::helper('productimport')->__($keyItem),
                  'name'      => Mage::getModel('productimport/productimport')->formatForId($keyItem),
                  'values'    => array(
                      array(
                          'value'     => 1,
                          'label'     => Mage::helper('productimport')->__('Use Value in Import'),
                      ),

                      array(
                          'value'     => 2,
                          'label'     => Mage::helper('productimport')->__('Don\'t Use Value in Import'),
                      ),
                  ),
              ));   
          }
        }
        break;
      }

      $fieldset->addField('rules', 'textarea', array(
          'name'      => 'rules',
          'label'     => Mage::helper('productimport')->__('Rules JSON code'),
          'title'     => Mage::helper('productimport')->__('Rules JSON code'),
          'wysiwyg'   => false,
          'disabled' => true,
          'readonly' => true,
      ));

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