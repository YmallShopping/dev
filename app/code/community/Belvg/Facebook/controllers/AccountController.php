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
 * Facebook handler in customer dashboard
 */
class Belvg_Facebook_AccountController extends Mage_Core_Controller_Front_Action
{

    /**
     * Action predispatch
     *
     * Check customer authentication for some actions
     */
    public function preDispatch()
    {
        parent::preDispatch();
        if (!Mage::getSingleton('customer/session')->authenticate($this)) {
            $this->setFlag('', self::FLAG_NO_DISPATCH, TRUE);
        }

        if (!Mage::helper('facebook')->isActive()) {
            $this->_redirect('customer/account');
        }
    }

    /**
     * Edit FB account options on frontend
     *
     * @return void
     */
    public function editAction()
    {
        $this->loadLayout();
        $this->_initLayoutMessages('customer/session');
        $this->_initLayoutMessages('catalog/session');
        $this->getLayout()->getBlock('head')->setTitle($this->__('Facebook Information'));
        $this->renderLayout();
    }

    /**
     * Get catalog session singleton
     *
     * @return Mage_Catalog_Model_Session
     */
    public function _getSession()
    {
        return Mage::getSingleton('catalog/session');
    }

    /**
     * Remove association with FB account
     */
    public function removeAction()
    {
        try {
            $fb_id = $this->getRequest()->getParam('fbid', 0);
            $id = $this->getRequest()->getParam('id', 0);

            $customer = Mage::getSingleton('customer/session')->getCustomer();
            /* @var $customer Mage_Customer_Model_Session */

            if (!$fb_id || !$id || $id != $customer->getId()) {
                $error = Mage::helper('facebook')->__('Customer or associated Facebook account was not found');
                Mage::throwException($error);
            }

            $facebook = Mage::getModel('facebook/facebook');
            /* @var $facebook Belvg_Facebook_Model_Facebook */

            $facebook->load($fb_id, 'fb_id')->delete();
            Mage::dispatchEvent('facebook_controller_facebook_delete', array('fb_id' => $fb_id, 'customer_id' => $id));
            $this->_getSession()->addSuccess(Mage::helper('facebook')->__('Association was successfully deleted'));
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }

        $this->_redirect('facebook/account/edit');
    }

}
