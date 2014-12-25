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

class Belvg_Facebook_Block_Comments extends Mage_Core_Block_Template
{

    protected $_product = NULL;

    /**
     * Get current product
     *
     * @return Mage_Catalog_Model_Product
     */
    function getProduct()
    {
        if (!$this->_product) {
            $this->_product = Mage::registry('product');
        }

        return $this->_product;
    }

    /**
     * Check if comments option is enabled
     *
     * @return boolen
     */
    public function isActiveComments()
    {
        return $this->helper('facebook')->isActiveComments();
    }

    /**
     * Get the number of visible comments
     *
     * @return int
     */
    public function getCommentsPosts()
    {
        return $this->helper('facebook')->getCommentsPosts();
    }

    /**
     * The width of the comments plugin, in pixels.
     *
     * @return int
     */
    public function getCommentsWidth()
    {
        return Mage::helper('facebook')->getCommentsWidth();
    }

    /**
     * The color scheme of the сщььутеы plugin.
     *
     * @return string
     */
    public function getCommentsColor()
    {
        return Mage::helper('facebook')->getCommentsColor();
    }
}
