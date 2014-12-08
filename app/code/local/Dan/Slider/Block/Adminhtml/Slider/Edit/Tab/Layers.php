<?php

class Dan_Slider_Block_Adminhtml_Slider_Edit_Tab_Layers extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('slider_layers', array('legend'=>Mage::helper('slider')->__('Caption')));
     
      $_layesNr = Mage::getModel('slider/slider')->load($this->getRequest()->getParam('id'))->getNrLayers();

      if($_layesNr == 0){
        $field = $fieldset->addField('no_layer', 'text', array(
            'label'     => Mage::helper('slider')->__('Title'),
            'name'      => 'no_layer',
        ));       
        $field->setRenderer($this->getLayout()->createBlock('slider/adminhtml_slider_edit_tab_renderer_nolayers'));
      } else {

        for($i=1;$i<=$_layesNr;$i++){
          $field = $fieldset->addField('caption_title_'.$i, 'text', array(
              'label'     => Mage::helper('slider')->__('Caption %s',$i),
          ));        
          $field->setRenderer($this->getLayout()->createBlock('slider/adminhtml_slider_edit_tab_renderer_captionname'));

          $field = $fieldset->addField('caption_text_'.$i, 'textarea', array(
              'label'     => Mage::helper('slider')->__('Text'),
              'name'      => 'caption_text_',
          )); 
                 
          $field = $fieldset->addField('layer_animation_'.$i, 'select', array(
              'label'     => Mage::helper('slider')->__('Caption Animation'),
              'name'      => 'layer_animation_',
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
          
          $field = $fieldset->addField('data_x_'.$i, 'text', array(
              'label'     => Mage::helper('slider')->__('Data X'),
              'name'      => 'data_x_',
          )); 
          
          $field = $fieldset->addField('data_y_'.$i, 'text', array(
              'label'     => Mage::helper('slider')->__('Data Y'),
              'name'      => 'data_y_',
          )); 
          
          $field = $fieldset->addField('data_start_'.$i, 'text', array(
              'label'     => Mage::helper('slider')->__('Data Start'),
              'name'      => 'data_start_',
          )); 
          
          $field = $fieldset->addField('data_speed_'.$i, 'text', array(
              'label'     => Mage::helper('slider')->__('Data Speed'),
              'name'      => 'data_speed_',
          )); 

          $field = $fieldset->addField('data_easing_'.$i, 'select', array(
              'label'     => Mage::helper('slider')->__('Data Easing'),
              'name'      => 'data_easing_',
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

          )); 

          $field = $fieldset->addField('style_'.$i, 'textarea', array(
              'label'     => Mage::helper('slider')->__('Css Style for Caption'),
              'name'      => 'style_',
          )); 

        }
      }
      
     
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