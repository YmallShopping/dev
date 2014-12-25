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
 * Facebook handler in admin dashboard
 */
class Belvg_Facebook_Adminhtml_FacebookController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Get admin session singleton
     *
     * @return Mage_Adminhtml_Model_Session
     */
    public function _getSession()
    {
        return Mage::getSingleton('adminhtml/session');
    }

    /**
     * Remove association with Facebook account
     */
    public function removeAction()
    {
        try {
            $fb_id = $this->getRequest()->getParam('fbid', 0);
            $id = $this->getRequest()->getParam('id', 0);

            if (!$fb_id || !$id) {
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

        $this->_redirect('adminhtml/customer/edit', array('id' => $id));
    }

    /**
     * Initialize product from request parameters
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _initProduct()
    {
        $this->_title($this->__('Catalog'))
                ->_title($this->__('Manage Products'));

        $productId = (int) $this->getRequest()->getParam('id');
        $product = Mage::getModel('catalog/product')
                ->setStoreId($this->getRequest()->getParam('store', 0));

        if (!$productId) {
            if ($setId = (int) $this->getRequest()->getParam('set')) {
                $product->setAttributeSetId($setId);
            }

            if ($typeId = $this->getRequest()->getParam('type')) {
                $product->setTypeId($typeId);
            }
        }

        $product->setData('_edit_mode', TRUE);
        if ($productId) {
            try {
                $product->load($productId);
            } catch (Exception $e) {
                $product->setTypeId(Mage_Catalog_Model_Product_Type::DEFAULT_TYPE);
                Mage::logException($e);
            }
        }

        $attributes = $this->getRequest()->getParam('attributes');
        if ($attributes && $product->isConfigurable() &&
                (!$productId || !$product->getTypeInstance()->getUsedProductAttributeIds())) {
            $product->getTypeInstance()->setUsedProductAttributeIds(
                    explode(",", base64_decode(urldecode($attributes)))
            );
        }

        // Required attributes of simple product for configurable creation
        if ($this->getRequest()->getParam('popup') && $requiredAttributes = $this->getRequest()->getParam('required')) {
            $requiredAttributes = explode(",", $requiredAttributes);
            foreach ($product->getAttributes() as $attribute) {
                if (in_array($attribute->getId(), $requiredAttributes)) {
                    $attribute->setIsRequired(1);
                }
            }
        }

        if ($this->getRequest()->getParam('popup') &&
                $this->getRequest()->getParam('product') &&
                !is_array($this->getRequest()->getParam('product')) &&
                $this->getRequest()->getParam('id', FALSE) === FALSE) {
            $configProduct = Mage::getModel('catalog/product')
                    ->setStoreId(0)
                    ->load($this->getRequest()->getParam('product'))
                    ->setTypeId($this->getRequest()->getParam('type'));
            /* @var $configProduct Mage_Catalog_Model_Product */

            $data = array();
            foreach ($configProduct->getTypeInstance()->getEditableAttributes() as $attribute) {
                /* @var $attribute Mage_Catalog_Model_Resource_Eav_Attribute */
                if (!$attribute->getIsUnique() &&
                        $attribute->getFrontend()->getInputType() != 'gallery' &&
                        $attribute->getAttributeCode() != 'required_options' &&
                        $attribute->getAttributeCode() != 'has_options' &&
                        $attribute->getAttributeCode() != $configProduct->getIdFieldName()) {
                    $data[$attribute->getAttributeCode()] = $configProduct->getData($attribute->getAttributeCode());
                }
            }

            $product->addData($data)
                    ->setWebsiteIds($configProduct->getWebsiteIds());
        }

        Mage::register('product', $product);
        Mage::register('current_product', $product);
        Mage::getSingleton('cms/wysiwyg_config')->setStoreId($this->getRequest()->getParam('store'));
        return $product;
    }

    /**
     * Initialize customer from request parameters
     *
     * @return Belvg_Facebook_Adminhtml_FacebookController
     */
    protected function _initCustomer($idFieldName = 'id')
    {
        $this->_title($this->__('Customers'))->_title($this->__('Manage Customers'));

        $customerId = (int) $this->getRequest()->getParam($idFieldName);
        $customer = Mage::getModel('customer/customer');
        /* @var $customer Mage_Customer_Model_Customer */

        if ($customerId) {
            $customer->load($customerId);
        }

        Mage::register('current_customer', $customer);
        return $this;
    }

    /**
     * Show likes statistics on customer account page
     */
    public function likesAction()
    {
        $this->_initCustomer();
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show likes statistics on product page
     */
    public function productLikesAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout();
        $this->renderLayout();
    }

    /**
     * Show comments statistics on customer account page
     */
    public function commentsAction()
    {
        $this->_initCustomer();
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * Show comments statistics on product page
     */
    public function productCommentsAction()
    {
        $this->_initProduct();
        $this->loadLayout();
        $this->getLayout();
        $this->renderLayout();
    }

}
