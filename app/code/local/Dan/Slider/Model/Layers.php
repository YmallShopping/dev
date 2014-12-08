<?php

class Dan_Slider_Model_Layers extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slider/layers');
    }
}