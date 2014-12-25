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

class Belvg_Facebook_Block_Activity extends Mage_Core_Block_Template
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
     * Check if like option is enabled
     *
     * @return boolen
     */
    public function isActiveActivity()
    {
        return Mage::helper('facebook')->isActiveActivity();
    }

    /**
     * The width of the activity plugin, in pixels.
     *
     * @return int
     */
    public function getActivityWidth()
    {
        return Mage::helper('facebook')->getActivityWidth();
    }

    /**
     * The height of the activity plugin, in pixels.
     *
     * @return int
     */
    public function getActivityHeight()
    {
        return Mage::helper('facebook')->getActivityHeight();
    }

    /**
     * Whether to show activity header
     *
     * @return bool
     */
    public function isActivityHeader()
    {
        return Mage::helper('facebook')->isActivityHeader();
    }

    /**
     * The color scheme of the activity plugin.
     *
     * @return string
     */
    public function getActivityColor()
    {
        return Mage::helper('facebook')->getActivityColor();
    }

    /**
     * The font of the activity plugin.
     *
     * @return string
     */
    public function getActivityFont()
    {
        return Mage::helper('facebook')->getActivityFont();
    }

    /**
     * Whether to show recomendations in activity plugin
     *
     * @return bool
     */
    public function isActivityRecomendations()
    {
        return Mage::helper('facebook')->isActivityRecomendations();
    }

    /**
     * The color scheme of the like plugin.
     *
     * @return string
     */
    public function getActivityMaxAge()
    {
        return Mage::helper('facebook')->getActivityMaxAge();
    }

    /**
     * Get public domain name for the store
     *
     * @return string
     */
    public function getDomainName()
    {
        return Mage::helper('core/http')->getHttpHost(TRUE);
   }
}
