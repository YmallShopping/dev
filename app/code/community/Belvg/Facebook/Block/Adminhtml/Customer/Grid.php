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
 **************************************
 *         MAGENTO EDITION USAGE NOTICE *
 * ***************************************
 * This package designed for Magento COMMUNITY edition
 * BelVG does not guarantee correct work of this extension
 * on any other Magento edition except Magento COMMUNITY edition.
 * BelVG does not provide extension support in case of
 * incorrect edition usage.
 **************************************
 *         DISCLAIMER   *
 **************************************
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future.
 * ****************************************************
 * @category   Belvg
 * @package    Belvg_Facebook
 * @author Pavel Novitsky <pavel@belvg.com>
 * @copyright  Copyright (c) 2010 - 2013 BelVG LLC. (http://www.belvg.com)
 * @license    http://store.belvg.com/BelVG-LICENSE-COMMUNITY.txt
 */

/*
 * Rewrite customer admin grid
 */
class Belvg_Facebook_Block_Adminhtml_Customer_Grid extends Mage_Adminhtml_Block_Customer_Grid
{

    /**
     * Check if Belvg_Facebook is active
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->helper('facebook')->isActive();
    }

    protected function _prepareCollection()
    {
        if (!$this->isActive()) {
            return parent::_prepareCollection();
        }

        $collection = Mage::getResourceModel('customer/customer_collection')
                ->addNameToSelect()
                ->addAttributeToSelect('email')
                ->addAttributeToSelect('created_at')
                ->addAttributeToSelect('group_id')
                ->joinAttribute('billing_postcode', 'customer_address/postcode', 'default_billing', NULL, 'left')
                ->joinAttribute('billing_city', 'customer_address/city', 'default_billing', NULL, 'left')
                ->joinAttribute('billing_telephone', 'customer_address/telephone', 'default_billing', NULL, 'left')
                ->joinAttribute('billing_region', 'customer_address/region', 'default_billing', NULL, 'left')
                ->joinAttribute('billing_country_id', 'customer_address/country_id', 'default_billing', NULL, 'left');

        $fb_table = Mage::getSingleton('core/resource')->getTableName('facebook/facebook');
        $collection->getSelect()->joinLeft($fb_table, 'e.entity_id = ' . $fb_table . '.customer_id', array('fb_id'));

        $this->setCollection($collection);

        return Mage_Adminhtml_Block_Widget_Grid::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        if (!$this->isActive()) {
            return parent::_prepareColumns();
        }

        $this->addColumn('entity_id', array(
                'header' => Mage::helper('customer')->__('ID'),
                'width' => '50px',
                'index' => 'entity_id',
                'type' => 'number',
        ));

        $this->addColumn('fb_id', array(
                'header' => Mage::helper('facebook')->__('Facebook'),
                'width' => '70',
                'index' => 'fb_id',
                'align' => 'center',
                'renderer' => $this->_isExport ?
                        'facebook/adminhtml_customer_grid_renderer_link' :
                        'facebook/adminhtml_customer_grid_renderer_html',
        ));

        $this->addColumn('name', array(
                'header' => Mage::helper('customer')->__('Name'),
                'index' => 'name'
        ));
        $this->addColumn('email', array(
                'header' => Mage::helper('customer')->__('Email'),
                'width' => '150',
                'index' => 'email'
        ));

        $groups = Mage::getResourceModel('customer/group_collection')
                ->addFieldToFilter('customer_group_id', array('gt' => 0))
                ->load()
                ->toOptionHash();

        $this->addColumn('group', array(
                'header' => Mage::helper('customer')->__('Group'),
                'width' => '100',
                'index' => 'group_id',
                'type' => 'options',
                'options' => $groups,
        ));

        $this->addColumn('Telephone', array(
                'header' => Mage::helper('customer')->__('Telephone'),
                'width' => '100',
                'index' => 'billing_telephone'
        ));

        $this->addColumn('billing_postcode', array(
                'header' => Mage::helper('customer')->__('ZIP'),
                'width' => '90',
                'index' => 'billing_postcode',
        ));

        $this->addColumn('billing_country_id', array(
                'header' => Mage::helper('customer')->__('Country'),
                'width' => '100',
                'type' => 'country',
                'index' => 'billing_country_id',
        ));

        $this->addColumn('billing_region', array(
                'header' => Mage::helper('customer')->__('State/Province'),
                'width' => '100',
                'index' => 'billing_region',
        ));

        $this->addColumn('customer_since', array(
                'header' => Mage::helper('customer')->__('Customer Since'),
                'type' => 'datetime',
                'align' => 'center',
                'index' => 'created_at',
                'gmtoffset' => TRUE
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('website_id', array(
                    'header' => Mage::helper('customer')->__('Website'),
                    'align' => 'center',
                    'width' => '80px',
                    'type' => 'options',
                    'options' => Mage::getSingleton('adminhtml/system_store')->getWebsiteOptionHash(TRUE),
                    'index' => 'website_id',
            ));
        }

        $this->addColumn('action', array(
                'header' => Mage::helper('customer')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                        array(
                                'caption' => Mage::helper('customer')->__('Edit'),
                                'url' => array('base' => '*/*/edit'),
                                'field' => 'id'
                        )
                ),
                'filter' => FALSE,
                'sortable' => FALSE,
                'index' => 'stores',
                'is_system' => FALSE,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('customer')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('customer')->__('Excel XML'));
        return parent::_prepareColumns();
    }

}
