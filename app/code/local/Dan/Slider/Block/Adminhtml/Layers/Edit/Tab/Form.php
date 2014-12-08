<?php

class Dan_Slider_Block_Adminhtml_layers_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('layers_form', array('legend'=>Mage::helper('slider')->__('Caption')));

          $field = $fieldset->addField('caption_name', 'text', array(
              'label'     => Mage::helper('slider')->__('Name'),
              'name'      => 'caption_name',
              'class'     => 'required-entry',
              'required'  => true,
          )); 

          $field = $fieldset->addField('text', 'textarea', array(
              'label'     => Mage::helper('slider')->__('Text'),
              'name'      => 'text',
              'class'     => 'required-entry',
              'required'  => true,
          )); 

          $_sliders = Mage::getModel('slider/slider')->getCollection();
          $_slidersVals = array();
          foreach ($_sliders as $_slide) {
            $_slidersVals[] = array('value'=>$_slide->getId(),'label'=>$_slide->getTitle());
          }
          $field = $fieldset->addField('slider_id', 'select', array(
              'label'     => Mage::helper('slider')->__('Select the Slider in which the Caption to appear'),
              'name'      => 'slider_id',
              'values'    => $_slidersVals,
              'class'     => 'required-entry',
              'required'  => true,
          )); 
                 
          $field = $fieldset->addField('layer_animation', 'select', array(
              'label'     => Mage::helper('slider')->__('Caption Animation'),
              'name'      => 'layer_animation',
              'values'    => array(
                array(
                    'value'     => 'sft',
                    'label'     => Mage::helper('slider')->__('Short From Top'),
                ),
                array(
                    'value'     => 'fade',
                    'label'     => Mage::helper('slider')->__('Fade'),
                ),
                array(
                    'value'     => 'sfl',
                    'label'     => Mage::helper('slider')->__('Short From Left'),
                ),
                array(
                    'value'     => 'skewfromleft',
                    'label'     => Mage::helper('slider')->__('Skew From Left'),
                ),
                array(
                    'value'     => 'lft',
                    'label'     => Mage::helper('slider')->__('Long from Top'),
                ),
                array(
                    'value'     => 'lfl',
                    'label'     => Mage::helper('slider')->__('Long from Left'),
                ),
                array(
                    'value'     => 'sfr',
                    'label'     => Mage::helper('slider')->__('Short From Right'),
                ),
                array(
                    'value'     => 'skewfromright',
                    'label'     => Mage::helper('slider')->__('Skew From Right'),
                ),
                array(
                    'value'     => 'sfb',
                    'label'     => Mage::helper('slider')->__('Short From Bottom'),
                ),
                array(
                    'value'     => 'lfb',
                    'label'     => Mage::helper('slider')->__('Long from Bottom'),
                ),
                array(
                    'value'     => 'randomrotate',
                    'label'     => Mage::helper('slider')->__('Random Rotate'),
                ),
                array(
                    'value'     => 'lfr',
                    'label'     => Mage::helper('slider')->__('Long from Right'),
                ),
            ),
          )); 
          
          $field = $fieldset->addField('data_x', 'text', array(
              'label'     => Mage::helper('slider')->__('Data X'),
              'name'      => 'data_x',
              'class'     => 'required-entry',
              'required'  => true,
              'note'      => 'Possible Values are "left", "center", "right", or any Value between -2500  and 2500.
If left/center/right is set, the caption will be siple aligned to the position.  Any other "number" will simple set the left position in px of tha caption.',
          )); 
          
          $field = $fieldset->addField('data_y', 'text', array(
              'label'     => Mage::helper('slider')->__('Data Y'),
              'name'      => 'data_y',
              'class'     => 'required-entry',
              'required'  => true,
              'note'      => 'Possible Values are "top", "center", "bottom", or any Value between -2500  and 2500. 
If top/center/bottom is set, the caption will be siple aligned to the position.  Any other "number" will simple set the top position in px of tha caption.',
          )); 
          
          $field = $fieldset->addField('data_start', 'text', array(
              'label'     => Mage::helper('slider')->__('Data Start'),
              'name'      => 'data_start',
              'class'     => 'required-entry',
              'required'  => true,
              'note'      => 'The speed in milliseconds of the transition to move the Caption in the Slide at the defined  timepoint.',
          )); 
          
          $field = $fieldset->addField('data_speed', 'text', array(
              'label'     => Mage::helper('slider')->__('Data Speed'),
              'name'      => 'data_speed',
              'class'     => 'required-entry',
              'required'  => true,
              'note'      => 'The timepoint in millisecond when/at the Caption should move in to the slide.',
          )); 

          $field = $fieldset->addField('data_easing', 'select', array(
              'label'     => Mage::helper('slider')->__('Data Easing'),
              'name'      => 'data_easing',
              'values'    => array(
                array(
                    'value'     => 'easeOutBack',
                    'label'     => Mage::helper('slider')->__('easeOutBack'),
                ),
                array(
                    'value'     => 'easeInQuad',
                    'label'     => Mage::helper('slider')->__('easeInQuad'),
                ),
                array(
                    'value'     => 'easeOutQuad',
                    'label'     => Mage::helper('slider')->__('easeOutQuad'),
                ),
                array(
                    'value'     => 'easeInCubic',
                    'label'     => Mage::helper('slider')->__('easeInCubic'),
                ),
                array(
                    'value'     => 'easeOutCubic',
                    'label'     => Mage::helper('slider')->__('easeOutCubic'),
                ),
                array(
                    'value'     => 'easeInOutCubic',
                    'label'     => Mage::helper('slider')->__('easeInOutCubic'),
                ),
                array(
                    'value'     => 'easeInQuart',
                    'label'     => Mage::helper('slider')->__('easeInQuart'),
                ),
                array(
                    'value'     => 'easeOutQuart',
                    'label'     => Mage::helper('slider')->__('easeOutQuart'),
                ),
                array(
                    'value'     => 'easeInOutQuart',
                    'label'     => Mage::helper('slider')->__('easeInOutQuart'),
                ),
                array(
                    'value'     => 'easeInQuint',
                    'label'     => Mage::helper('slider')->__('easeInQuint'),
                ),
                array(
                    'value'     => 'easeOutQuint',
                    'label'     => Mage::helper('slider')->__('easeOutQuint'),
                ),
                array(
                    'value'     => 'easeInOutQuint',
                    'label'     => Mage::helper('slider')->__('easeInOutQuint'),
                ),
                array(
                    'value'     => 'easeInSine',
                    'label'     => Mage::helper('slider')->__('easeInSine'),
                ),
                array(
                    'value'     => 'easeOutSine',
                    'label'     => Mage::helper('slider')->__('easeOutSine'),
                ),
                array(
                    'value'     => 'easeInOutSine',
                    'label'     => Mage::helper('slider')->__('easeInOutSine'),
                ),
                array(
                    'value'     => 'easeInExpo',
                    'label'     => Mage::helper('slider')->__('easeInExpo'),
                ),
                array(
                    'value'     => 'easeOutExpo',
                    'label'     => Mage::helper('slider')->__('easeOutExpo'),
                ),
                array(
                    'value'     => 'easeInOutExpo',
                    'label'     => Mage::helper('slider')->__('easeInOutExpo'),
                ),
                array(
                    'value'     => 'easeInCirc',
                    'label'     => Mage::helper('slider')->__('easeInCirc'),
                ),
                array(
                    'value'     => 'easeOutCirc',
                    'label'     => Mage::helper('slider')->__('easeOutCirc'),
                ),
                array(
                    'value'     => 'easeInOutCirc',
                    'label'     => Mage::helper('slider')->__('easeInOutCirc'),
                ),
                array(
                    'value'     => 'easeInElastic',
                    'label'     => Mage::helper('slider')->__('easeInElastic'),
                ),
                array(
                    'value'     => 'easeOutElastic',
                    'label'     => Mage::helper('slider')->__('easeOutElastic'),
                ),
                array(
                    'value'     => 'easeInOutElastic',
                    'label'     => Mage::helper('slider')->__('easeInOutElastic'),
                ),
                array(
                    'value'     => 'easeInBack',
                    'label'     => Mage::helper('slider')->__('easeInBack'),
                ),
                array(
                    'value'     => 'easeInOutBack',
                    'label'     => Mage::helper('slider')->__('easeInOutBack'),
                ),
                array(
                    'value'     => 'easeInBounce',
                    'label'     => Mage::helper('slider')->__('easeInBounce'),
                ),
                array(
                    'value'     => 'easeOutBounce',
                    'label'     => Mage::helper('slider')->__('easeOutBounce'),
                ),
                array(
                    'value'     => 'easeInOutBounce',
                    'label'     => Mage::helper('slider')->__('easeInOutBounce'),
                ),
            ),
            'note'      => 'The Easing Art how the caption is moved in to the slide.',
          )); 

          $field = $fieldset->addField('style', 'textarea', array(
              'label'     => Mage::helper('slider')->__('Css Style for Caption'),
              'name'      => 'style',
              'note'      => 'If you want to style the text. Example : font-size:20px; color:red; . NOTE : It supports only css code.',
          )); 

      
     
      if ( Mage::getSingleton('adminhtml/session')->getLayersData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getLayersData());
          Mage::getSingleton('adminhtml/session')->setLayersData(null);
      } elseif ( Mage::registry('layers_data') ) {
          $form->setValues(Mage::registry('layers_data')->getData());
      }
      return parent::_prepareForm();
  }
}