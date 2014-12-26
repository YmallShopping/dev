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
 * Collect information about like and comment events
 */
class Belvg_Facebook_EventsController extends Mage_Core_Controller_Front_Action
{

    /**
     * Log like event
     */
    public function likeAction()
    {
        $response = array('status' => 0);
        if ($this->getRequest()->isAjax()) {
            $product_id = (int) $this->getRequest()->getParam('product', 0);
            $customer_id = $this->getRequest()->getParam('customer', 0);
            $fb_id = (int) $this->getRequest()->getParam('fb_id', 0);

            try {
                if ($product_id && $fb_id) {
                    $model = Mage::getModel('facebook/likes');
                    /* @var $model Belvg_Facebook_Model_Likes */
                    $model->setProductId($product_id);

                    if ($fb_customer = Mage::getModel('facebook/facebook')->load($fb_id, 'fb_id')) {
                        /* @var $fb_customer Belvg_Facebook_Model_Facebook */
                        $customer_id = $fb_customer->getCustomerId();
                    }

                    if ($customer_id) {
                        $model->setCustomerId($customer_id);
                        $name = Mage::getModel('customer/customer')->load($customer_id)->getName();
                        $model->setName($name);
                    }

                    $model->setFbId($fb_id)->save();
                    $response['status'] = 1;
                    Mage::dispatchEvent('facebook_controller_like',
                            array('fb_id' => $fb_id, 'customer_id' => $customer_id, 'product_id' => $product_id));
                }
            } catch (Exception $e) {
                Mage::log('Like: ' . $e->getMessage(), NULL, 'facebook.log');
                $response['error'] = $e->getMessage();
            }
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

    /**
     * Log commetns actions
     */
    public function commentAction()
    {
        $response = array('status' => 0);
        if ($this->getRequest()->isAjax()) {
            $product_id = (int) $this->getRequest()->getParam('product', 0);
            $customer_id = (int) $this->getRequest()->getParam('customer', 0);
            $fb_id = $this->getRequest()->getParam('fb_id', 0);
            $comment_id = (int) $this->getRequest()->getParam('comment', 0);

            try {
                if ($product_id && $fb_id && $comment_id) {
                    $model = Mage::getModel('facebook/comments');
                    /* @var $model Belvg_Facebook_Model_Comments */
                    $model->setProductId($product_id);
                    $model->setCommentId($comment_id);

                    if ($fb_customer = Mage::getModel('facebook/facebook')->load($fb_id, 'fb_id')) {
                        /* @var $fb_customer Belvg_Facebook_Model_Facebook */
                        $customer_id = $fb_customer->getCustomerId();
                    }

                    if ($customer_id) {
                        $model->setCustomerId($customer_id);
                        $name = Mage::getModel('customer/customer')->load($customer_id)->getName();
                        $model->setName($name);
                    }

                    $model->setFbId($fb_id)->save();
                    $response['status'] = 1;
                    Mage::dispatchEvent('facebook_controller_comment',
                            array(
                                    'fb_id' => $fb_id,
                                    'customer_id' => $customer_id,
                                    'product_id' => $product_id,
                                    'comment_id' => $comment_id
                            )
                            );
                }
            } catch (Exception $e) {
                Mage::log('Comment: ' . $e->getMessage(), NULL, 'facebook.log');
                $response['error'] = $e->getMessage();
            }
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

    /**
     * Delete like log event
     */
    public function likeDeleteAction()
    {
        $response = array('status' => 0);
        if ($this->getRequest()->isAjax()) {
            $product_id = (int) $this->getRequest()->getParam('product', 0);
            $customer_id = (int) $this->getRequest()->getParam('customer', 0);
            $fb_id = $this->getRequest()->getParam('fb_id', 0);

            try {
                if ($product_id && $fb_id) {
                    $collection = Mage::getModel('facebook/likes')->getCollection();
                    /* @var $model Belvg_Facebook_Model_Resource_Likes_Collection */
                    $collection->addFieldToFilter('fb_id', $fb_id)
                            ->addFieldToFilter('product_id', $product_id);

                    if ($collection->count()) {
                        foreach ($collection as $item) {
                            $item->delete();
                        }
                    }

                    $response['status'] = 1;
                    Mage::dispatchEvent('facebook_controller_like_delete',
                            array('fb_id' => $fb_id, 'customer_id' => $customer_id, 'product_id' => $product_id));
                }
            } catch (Exception $e) {
                Mage::log('Delete Like: ' . $e->getMessage(), NULL, 'facebook.log');
                $response['error'] = $e->getMessage();
            }
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

    /**
     * Delete comments log event
     */
    public function commentDeleteAction()
    {
        $response = array('status' => 0);
        if ($this->getRequest()->isAjax()) {
            $product_id = (int) $this->getRequest()->getParam('product', 0);
            $customer_id = (int) $this->getRequest()->getParam('customer', 0);
            $fb_id = $this->getRequest()->getParam('fb_id', 0);
            $comment_id = (int) $this->getRequest()->getParam('comment', 0);

            try {
                if ($product_id && $fb_id && $comment_id) {
                    $collection = Mage::getModel('facebook/likes')->getCollection();
                    /* @var $model Belvg_Facebook_Model_Resource_Comments_Collection */
                    $collection->addFieldToFilter('fb_id', $fb_id)
                            ->addFieldToFilter('product_id', $product_id)
                            ->addFieldToFilter('comment_id', $comment_id);

                    if ($collection->count()) {
                        foreach ($collection as $item) {
                            $item->delete();
                        }
                    }

                    $response['status'] = 1;
                    Mage::dispatchEvent('facebook_controller_comment_delete',
                            array(
                                    'fb_id' => $fb_id,
                                    'customer_id' => $customer_id,
                                    'product_id' => $product_id,
                                    'comment_id' => $comment_id
                            )
                            );
                }
            } catch (Exception $e) {
                Mage::log('Delete Comment: ' . $e->getMessage(), NULL, 'facebook.log');
                $response['error'] = $e->getMessage();
            }
        }

        $this->getResponse()->setHeader('Content-type', 'application/json');
        $this->getResponse()->setBody(Zend_Json::encode($response));
    }

}
