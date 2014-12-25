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
 * Facebook integration model
 */
class Belvg_Facebook_Model_Facebook extends Mage_Core_Model_Abstract
{

    /**
     * Event prefix for observer
     *
     * @var string
     */
    protected $_eventPrefix = 'facebook';

    /**
     * init model
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->_init('facebook/facebook');
    }

    /**
     * Check if customer was already logged in with FB before
     *
     * @param array $fb_data
     * @return boolean
     */
    public function checkFbCustomer(array $fb_data)
    {
        $this->setWebsiteId(Mage::app()->getStore()->getWebsiteId());
        $collection = $this->getCollection();
        /* @var $collection Belvg_Facebook_Model_Resource_Facebook_Collection */

        $collection->addFieldToFilter('fb_id', $fb_data['id'])
                ->addFieldToFilter('website_id', $this->getWebsiteId());
        if ($collection->count() && $customer_id = $collection->getFirstItem()->getCustomerId()) {
            return $customer_id;
        }

        return FALSE;
    }

    /**
     * Check if customer has associated FB account
     *
     * @param Mage_Customer_Model_Customer $customer
     * @return boolean
     */
    public function hasFbAccount(Mage_Customer_Model_Customer $customer)
    {
        $collection = $this->getCollection();
        /* @var $collection Belvg_Facebook_Model_Resource_Facebook_Collection */
        $collection->addFieldToFilter('customer_id', $customer->getId());

        if ($collection->count() && $fb_id = $collection->getFirstItem()->getFbId()) {
            return $fb_id;
        }

        return FALSE;
    }

    /**
     * Load data to the entity
     *
     * @param Belvg_Facebook_Model_Customer $customer
     * @return Belvg_Facebook_Model_Facebook
     */
    public function prepareData(Belvg_Facebook_Model_Customer $customer)
    {
        $data = array(
                'customer_id' => $customer->getId(),
                'website_id' => (int) $customer->getWebsiteId(),
                'store_id' => (int) $customer->getStoreId(),
                'fb_id' => (int) $customer->getFbData('id'),
        );

        $this->setData($data);
        return $this;
    }

}
