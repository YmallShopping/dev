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

class Belvg_Facebook_Block_Wishlist_Item_Column_Share extends Mage_Wishlist_Block_Customer_Wishlist_Item_Column
{

    /**
     * Checks whether column should be shown in table
     *
     * @return bool
     */
    public function isEnabled()
    {
        return Mage::helper('facebook')->isActiveWishlist();
    }

    /**
     * Share URL for item from wishlist
     *
     * @return string
     */
    public function getShareItemUrl()
    {
        $_product = Mage::getModel('catalog/product')->load($this->getItem()->getProductId());
        /* @var $_product Mage_Catalog_Model_Product */

        $title = $_product->getName();
        $url = $_product->getProductUrl();
        $image_url = $this->helper('catalog/image')->init($_product, 'thumbnail');
        $description = $this->helper('facebook')->getWishlistDescription($title);

        return $this->helper('facebook')->getShareUrl($title, $url, $image_url, $description);
    }
}
