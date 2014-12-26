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

class Belvg_Facebook_Block_Like_Meta extends Belvg_Facebook_Block_Init
{

    /**
     * Get current product
     *
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Check if like option is enabled
     *
     * @return boolean
     */
    public function isActive()
    {
        return ($this->helper('facebook')->isActiveLike() && $this->getProduct());
    }

    /**
     * Get current product name
     *
     * @return string
     */
    public function getProductName()
    {
        return $this->escapeHtml($this->getProduct()->getName());
    }

    /**
     * Get current product name
     *
     * @return string
     */
    public function getProductDescription()
    {
        return $this->escapeHtml($this->stripTags($this->getProduct()->getShortDescription()));
    }

    /**
     * Get current product thumbnail
     *
     * @return string
     */
    public function getProductImage()
    {
        return $this->helper('catalog/image')->init($this->getProduct(), 'thumbnail');
    }

    /**
     * Get current product URL
     *
     * @return string
     */
    public function getProductUrl()
    {
        return $this->getProduct()->getProductUrl();
    }

}