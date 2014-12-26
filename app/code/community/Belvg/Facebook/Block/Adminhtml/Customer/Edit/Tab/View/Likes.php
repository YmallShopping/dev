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

class Belvg_Facebook_Block_Adminhtml_Customer_Edit_Tab_View_Likes extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('customerLikesGrid');
        $this->setUseAjax(TRUE);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(TRUE);
    }

    protected function getCustomer()
    {
        return Mage::registry('current_customer');
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function getCustomerId()
    {
        $customer_id = 0;
        if ($this->getCustomer()->getId()) {
            $customer_id = (int) $this->getCustomer()->getId();
        }

        return $customer_id;
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('catalog/product_collection')
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('sku')
                ->addAttributeToSelect('price')
                ->addAttributeToSelect('status')
                ->addAttributeToSelect('visibility')
                ->addFieldToFilter('status', Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
                ->addAttributeToFilter('visibility', array('neq' => 1));

        $fb_table = Mage::getSingleton('core/resource')->getTableName('facebook/likes');
        $collection->getSelect()->join($fb_table, 'e.entity_id = ' . $fb_table . '.product_id AND ' . $fb_table . '.customer_id = ' . $this->getCustomerId(), array('fb_id', 'event_created_at' => 'created_at'));

        $this->setCollection($collection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('entity_id', array(
                'header' => Mage::helper('catalog')->__('Product Id'),
                'width' => '50px',
                'type' => 'number',
                'index' => 'entity_id',
        ));
        $this->addColumn('name', array(
                'header' => Mage::helper('catalog')->__('Name'),
                'index' => 'name',
        ));

        $this->addColumn('type', array(
                'header' => Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type' => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $this->addColumn('sku', array(
                'header' => Mage::helper('catalog')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
        ));

        $store = $this->_getStore();
        $this->addColumn('price', array(
                'header' => Mage::helper('catalog')->__('Price'),
                'type' => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/facebook/likes', array('_current' => TRUE));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('adminhtml/catalog_product/edit', array(
                        'store' => $this->getRequest()->getParam('store'),
                        'id' => $row->getId())
        );
    }

}
