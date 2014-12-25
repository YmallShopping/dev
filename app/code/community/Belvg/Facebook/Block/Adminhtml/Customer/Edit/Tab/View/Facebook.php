<?php

/**
 * BelVG LLC.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 *
 * **************************************
 *         MAGENTO EDITION USAGE NOTICE *
 * ***************************************
 * This package designed for Magento COMMUNITY edition
 * BelVG does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * BelVG does not provide extension support in case of
 * incorrect edition usage.
 * **************************************
 *         DISCLAIMER   *
 * ***************************************
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 * ****************************************************
 * @category   Belvg
 * @package    Belvg_Facebook
 * @author Pavel Novitsky <pavel@belvg.com>
 * @copyright  Copyright (c) 2010 - 2014 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

class Belvg_Facebook_Block_Adminhtml_Customer_Edit_Tab_View_Facebook
    extends Mage_Adminhtml_Block_Template
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function getTabLabel()
    {
        return Mage::helper('facebook')->__('Facebook Information');
    }

    public function getTabTitle()
    {
        return Mage::helper('facebook')->__('Facebook Information');
    }

    public function canShowTab()
    {
        if ($this->getCustomer()->getId() && $this->helper('facebook')->isActive()) {
            return TRUE;
        }

        return FALSE;
    }

    public function isHidden()
    {
        return FALSE;
    }

    protected function getCustomer()
    {
        return Mage::registry('current_customer');
    }

    public function hasFbAccount()
    {
        return Mage::getModel('facebook/facebook')->hasFbAccount($this->getCustomer());
    }

}
