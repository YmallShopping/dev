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

class Belvg_Facebook_Block_Init extends Mage_Core_Block_Template
{

    /**
     * Return applicaton Id
     *
     * @return string
     */
    public function getAppId()
    {
        return Mage::helper('facebook')->getAppId();
    }

    /**
     * Return encoded current URL for after auth redirection
     *
     * @return string
     */
    public function getLoginUrl()
    {
        return Mage::helper('facebook')->getLoginUrl();
    }

    /**
     * Get current FB locale according to the selected store locale
     *
     * @return string
     */
    public function getLocale()
    {
        return Mage::getModel('facebook/locale')->getLocale();
    }

    public function isProductPage()
    {
        $is_product = FALSE;
        if (Mage::registry('current_product')) {
            $is_product = TRUE;
        }

        return $is_product;
    }

    /**
     * Check if like option is enabled
     *
     * @return boolen
     */
    public function isActiveLike()
    {
        return $this->helper('facebook')->isActiveLike();
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

    public function getEventUrl($key)
    {
        $data = array(
                'customer' => (int) Mage::getSingleton('customer/session')->getCustomer()->getId(),
                'product' => (int) Mage::registry('current_product')->getId(),
                'fb_id' => (int) Mage::helper('facebook')->getFbUserId()
        );

        return $this->getUrl($key, $data);
    }

    /**
     * Get url for logging like events
     *
     * @return string
     */
    public function getLikeEventUrl()
    {
        return $this->getEventUrl('facebook/events/like');
    }

    /**
     * Get url for removing like log records
     *
     * @return string
     */
    public function getLikeDeleteEventUrl()
    {
        return $this->getEventUrl('facebook/events/likedelete');
    }

    /**
     * Get url for logging comments events
     *
     * @return string
     */
    public function getCommentEventUrl()
    {
        return $this->getEventUrl('facebook/events/comment');
    }

    /**
     * Get url for removing comments log records
     *
     * @return string
     */
    public function getCommentDeleteEventUrl()
    {
        return $this->getEventUrl('facebook/events/commentdelete');
    }

}
