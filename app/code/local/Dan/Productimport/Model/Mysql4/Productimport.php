<?php

class Dan_Productimport_Model_Mysql4_Productimport extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the productimport_id refers to the key field in your database table.
        $this->_init('productimport/productimport', 'productimport_id');
    }
}