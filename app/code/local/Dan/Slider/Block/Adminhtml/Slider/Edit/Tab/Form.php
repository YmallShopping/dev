<?php

class Dan_Slider_Block_Adminhtml_Slider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slider_form', array('legend'=>Mage::helper('slider')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('image', 'image', array(
          'label'     => Mage::helper('slider')->__('Slider Image'),
          'required'  => false,
          'name'      => 'image',
	  ));
	 
      $fieldset->addField('url', 'text', array(
          'label'     => Mage::helper('slider')->__('Slider Url'),
          'required'  => false,
          'name'      => 'url',
      ));	

      $fieldset->addField('position', 'text', array(
          'label'     => Mage::helper('slider')->__('Position'),
          'required'  => false,
          'name'      => 'position',
      ));	  
    
      $fieldset->addField('slider_effect', 'select', array(
          'label'     => Mage::helper('slider')->__('Slide Effect'),
          'name'      => 'slider_effect',
          'values'    => array(
              array(
                  'value'     => 'fade',
                  'label'     => Mage::helper('slider')->__('Fade'),
              ),
              array(
                  'value'     => 'boxfade',
                  'label'     => Mage::helper('slider')->__('Fade Boxes'),
              ),
              array(
                  'value'     => 'boxslide',
                  'label'     => Mage::helper('slider')->__('Slide Boxes'),
              ),
              array(
                  'value'     => 'slideup',
                  'label'     => Mage::helper('slider')->__('Slide To Top'),
              ),
              array(
                  'value'     => 'slidedown',
                  'label'     => Mage::helper('slider')->__('Slide To Bottom '),
              ),
              array(
                  'value'     => 'zoomout',
                  'label'     => Mage::helper('slider')->__('ZoomOut'),
              ),
              array(
                  'value'     => 'zoomin',
                  'label'     => Mage::helper('slider')->__('ZoomIn'),
              ),
              array(
                  'value'     => 'fadetoleftfadefromright',
                  'label'     => Mage::helper('slider')->__('Fade To Left and Fade From Right'),
              ),
              array(
                  'value'     => 'fadetorightfadefromleft',
                  'label'     => Mage::helper('slider')->__('Fade To Right and Fade From Left'),
              ),
              array(
                  'value'     => 'fadetotopfadefrombottom',
                  'label'     => Mage::helper('slider')->__('Fade To Top and Fade From Bottom'),
              ),
              array(
                  'value'     => 'fadetobottomfadefromtop',
                  'label'     => Mage::helper('slider')->__('Fade To Bottom and Fade From Top'),
              ),
          ),
      )); 		

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slider')->__('Disabled'),
              ),
          ),
      ));	  
     
      if ( Mage::getSingleton('adminhtml/session')->getSliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
          Mage::getSingleton('adminhtml/session')->setSliderData(null);
      } elseif ( Mage::registry('slider_data') ) {
          $form->setValues(Mage::registry('slider_data')->getData());
      }
      return parent::_prepareForm();
  }
}