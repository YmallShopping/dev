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

class Belvg_Facebook_Block_Checkout_Success extends Mage_Checkout_Block_Onepage_Review_Info
{
    /**
     * Checks whether block should be shown on the success page
     *
     * @return bool
     */
    public function isActive()
    {
        return Mage::helper('facebook')->isActive() && Mage::helper('facebook')->isActiveOrder();
    }

    /**
     * Get order Items
     *
     * @return Mage_Sales_Model_Resource_Order_Item_Collection
     */
    public function getItems()
    {
        $order_id = Mage::getSingleton('checkout/session')->getLastOrderId();
        $order = Mage::getModel('sales/order')->load($order_id);
        /* @var $order Mage_Sales_Model_Order */

        $converter = Mage::getModel('facebook/converter');
        /* @var $converter Belvg_Facebook_Model_Converter */

        $items = $converter->toQuoteItems($order);
        return $items;
    }
}
