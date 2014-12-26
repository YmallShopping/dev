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

/**
 * Sales order items converter
 */
class Belvg_Facebook_Model_Converter extends Mage_Sales_Model_Convert_Order
{

    /**
     * Convert sals order items to quote items
     *
     * @param Mage_Sales_Model_Order $order
     * @return array
     */
    public function toQuoteItems(Mage_Sales_Model_Order $order)
    {
        $order_items = $order->getAllVisibleItems();

        $quote = $this->toQuote($order);
        /* @var $quote Mage_Sales_Model_Quote */


        foreach ($order_items as $item) {
            /* @var $item Mage_Sales_Model_Order_Item */

            $quote_item = $this->itemToQuoteItem($item)
                    ->setProduct($item->getProduct())
                    ->setQty($item->getQtyOrdered());
            /* @var $quote_item Mage_Sales_Model_Quote_Item */

            $quote->addItem($quote_item);
        }

        return $quote->getAllVisibleItems();
    }

}
