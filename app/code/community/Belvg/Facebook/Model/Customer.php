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
 * Extend customer model for FB integration
 */
class Belvg_Facebook_Model_Customer extends Mage_Customer_Model_Customer
{

    /**
     * Array of the FB user profile information
     * @var array
     */
    private $_fb_data = array();

    /**
     * Assign FB data to the entity
     *
     * @param array $fb_data
     * @return Belvg_Facebook_Model_Customer
     */
    public function setFbData(array $fb_data)
    {
        $this->_fb_data = $fb_data;
        return $this;
    }

    /**
     * Get data from the entity
     *
     * @param string|NULL $key
     * @return type
     */
    public function getFbData($key = NULL)
    {
        $data = $this->_fb_data;

        if (!is_null($key) && isset($data[$key])) {
            $data = $data[$key];
        }

        return $data;
    }

    /**
     * Check if customer exists
     *
     * @return boolean
     */
    public function checkCustomer()
    {
        $this->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        $this->setStoreId(Mage::app()->getStore()->getStoreId());

        $this->loadByEmail($this->getFbData('email'));

        if ($this->getId()) {
            return $this->getId();
        }

        return FALSE;
    }

    /**
     * Check if customer was already logged in with FB before
     *
     * @return boolean
     */
    public function checkFbCustomer()
    {
        return Mage::getModel('facebook/facebook')->checkFbCustomer($this->getFbData());
    }

    /**
     * Map FB data to the entity
     *
     * @return Belvg_Facebook_Model_Customer
     */
    public function prepareData()
    {
        $this->setData('firstname', $this->getFbData('first_name'));
        $this->setData('lastname', $this->getFbData('last_name'));
        $this->setData('email', $this->getFbData('email'));
        $this->setData('password', $this->generatePassword());

        if ($dob = $this->getFbData('birthday')) {
            list($month, $day, $year) = explode('/', $dob);
            $this->setData('day', $day);
            $this->setData('month', $month);
            $this->setData('year', $year);
            $this->setData('dob', "$year-$month-$day 00:00:00");
        }

        $this->setData('is_active', TRUE);
        $this->setData('confirmation', NULL);
        return $this;
    }

}
