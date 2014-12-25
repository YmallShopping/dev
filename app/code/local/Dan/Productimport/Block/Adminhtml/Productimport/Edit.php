<?php

class Dan_Productimport_Block_Adminhtml_Productimport_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'productimport';
        $this->_controller = 'adminhtml_productimport';
        
        $this->_updateButton('save', 'label', Mage::helper('productimport')->__('Save Profile'));
        $this->_updateButton('delete', 'label', Mage::helper('productimport')->__('Delete Profile'));
		
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_addButton('import_products', array(
            'label'     => Mage::helper('adminhtml')->__('Update Product Attibutes Value'),
            'onclick'   => 'confirmSetLocation(\''.Mage::helper('catalog')->__('Are you sure you want to proceed?').'\', \''.$this->getImportProductsUrl().'\')',
            'class'     => 'update',
        ), -110);

        $this->_addButton('render_products', array(
            'label'     => Mage::helper('adminhtml')->__('Render Csv'),
            'onclick'   => 'confirmSetLocation(\''.Mage::helper('catalog')->__('Are you sure you want to proceed?').'\', \''.$this->getRenderProducts().'\')',
            'class'     => 'render',
        ), -120);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productimport_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productimport_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productimport_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productimport_data') && Mage::registry('productimport_data')->getId() ) {
            return Mage::helper('productimport')->__("Edit Profile '%s'", $this->htmlEscape(Mage::registry('productimport_data')->getTitle()));
        } else {
            return Mage::helper('productimport')->__('Add Profile');
        }
    }

    public function getImportProductsUrl()
    {
        return $this->getUrl('*/*/updateProductAttributes', array('_current'=>true));
    }

    public function getRenderProducts()
    {
        return $this->getUrl('*/*/renderProductInfo', array('_current'=>true));
    }
}