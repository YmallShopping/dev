<?php

class Dan_Slider_Model_Observer extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('slider/slider');
    }

    public function loginRedirect()
    {
        $_controller = Mage::app()->getRequest()->getControllerName();
        $_redirectPages = array('account');
        $_excludePages = array('account');
        $_storeCode = Mage::app()->getStore()->getCode();
        $_admin = Mage::app()->getStore()->getCode();

        if(!Mage::helper('customer')->isLoggedIn() && in_array($_controller, $_redirectPages) && $_admin!='admin' && $_storeCode!='mall'){
            if(strrpos(Mage::app()->getRequest()->getRequestUri(),'forgotpassword') === false){
                Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/',array('_store'=>'mall')));
            } else {
                Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/forgotpassword',array('_store'=>'mall')));
            }
            
        }

    	if(Mage::helper('customer')->isLoggedIn() && in_array($_controller, $_redirectPages) && $_admin!='admin' && $_storeCode!='mall'){
            if(strrpos(Mage::app()->getRequest()->getRequestUri(),'forgotpassword') === false){
                Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/',array('_store'=>'mall')));
            } else {
                Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/forgotpassword',array('_store'=>'mall')));
            }
    		
    	}
    }

}