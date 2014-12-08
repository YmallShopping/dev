<?php

class Dan_Productimport_Block_Adminhtml_Productimport_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('productimport_form', array('legend'=>Mage::helper('productimport')->__('Profile information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('productimport')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      $_data = Mage::registry('productimport_data')->getData();

      if(isset($_data['filename']) && $_data['filename']!==''){
        $fieldset->addField('filename', 'file', array(
            'label'     => Mage::helper('productimport')->__('CSV File Replace'),
            'required'  => false,
            'name'      => 'filename',
            'note'      => 'A CSV file is allready availabe. To replace it, just upload a new one and click "Save and Continue Edit". After you can continue with the import.',
        ));       
      } else {
        $fieldset->addField('filename', 'file', array(
            'label'     => Mage::helper('productimport')->__('CSV File Upload'),
            'required'  => false,
            'name'      => 'filename',
            'note'      => 'Once a CSV file is uploaded the rest of the settings will appear! Upload the file and then click "Save and Continue Edit". After, you can continue setting up the import.',
        ));        
      }

		
      if(isset($_data['filename']) && $_data['filename']!==''){

        $fieldset->addField('import_type', 'select', array(
            'label'     => Mage::helper('productimport')->__('Import Type'),
            'name'      => 'import_type',
            'class'     => 'required-entry',
            'required'  => true,
            'values'    => array(
                array(
                    'value'     => '',
                    'label'     => Mage::helper('productimport')->__('Select an Import Type'),
                ),

                array(
                    'value'     => 0,
                    'label'     => Mage::helper('productimport')->__('Import New and Update existing products'),
                ),

                array(
                    'value'     => 1,
                    'label'     => Mage::helper('productimport')->__('Only Update existing products'),
                ),

                array(
                    'value'     => 2,
                    'label'     => Mage::helper('productimport')->__('Only Import new products'),
                ),

                array(
                    'value'     => 3,
                    'label'     => Mage::helper('productimport')->__('Delete existing products that match the csv sku\'s'),
                ),
            ),
        ));    

        $_websiteCollection = Mage::getModel('core/website')->getCollection();
        $_websites = array();
        foreach ($_websiteCollection as $_website) {
          $_websites[] = array('value'=>$_website->getId(), 'label'=>$_website->getName());
        }

        if (!Mage::app()->isSingleStoreMode()) {
            $field = $fieldset->addField('store', 'multiselect', array(
                'name'      => 'store[]',
                'label'     => Mage::helper('cms')->__('Select the store in which the products will be uploaded.'),
                'title'     => Mage::helper('cms')->__('Select the store in which the products will be uploaded.'),
                'required'  => true,
                'values'    => $_websites,
            ));
        }
      }
     
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('productimport')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('productimport')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('productimport')->__('Disabled'),
              ),
          ),
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