<?php

class Dan_Slider_Model_Mysql4_Layers_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slider/layers');
    }
}