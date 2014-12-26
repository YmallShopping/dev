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

class Belvg_Facebook_Block_Adminhtml_Catalog_Product_Edit_Tab_Likes
    extends Mage_Adminhtml_Block_Widget_Grid
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    /**
     * Set grid params
     *
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('facebook_likes');
        $this->setDefaultSort('created_at');
        $this->setUseAjax(TRUE);
        if ($this->_getProduct()->getId()) {
            $this->setDefaultFilter(array('in_products' => 1));
        }
    }

    /**
     * Retirve currently edited product model
     *
     * @return Mage_Catalog_Model_Product
     */
    protected function _getProduct()
    {
        return Mage::registry('current_product');
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection Mage_Catalog_Model_Resource_Product_Link_Product_Collection */
        $collection = Mage::getModel('facebook/likes')->getCollection()
                ->addFieldToFilter('product_id', $this->_getProduct()->getId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
                'header' => Mage::helper('catalog')->__('Customer Name'),
                'index' => 'name',
                'renderer' => 'facebook/adminhtml_catalog_product_grid_renderer_likes',
        ));

        $this->addColumn('fb_id', array(
                'header' => Mage::helper('facebook')->__('Facebook'),
                'width' => '70',
                'index' => 'fb_id',
                'align' => 'center',
                'renderer' => 'facebook/adminhtml_customer_grid_renderer_html',
        ));

        $this->addColumn('created_at', array(
                'header' => Mage::helper('customer')->__('Liked On'),
                'type' => 'datetime',
                'align' => 'center',
                'index' => 'created_at',
                'gmtoffset' => TRUE
        ));

        return parent::_prepareColumns();
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('adminhtml/facebook/productlikes', array('_current' => TRUE));
    }

    public function getTabLabel()
    {
        return Mage::helper('facebook')->__('Facebook Likes');
    }

    public function getTabTitle()
    {
        return Mage::helper('facebook')->__('Facebook Likes');
    }

    public function canShowTab()
    {
        if ($this->_getProduct()->getId() &&
                $this->helper('facebook')->isActive() &&
                $this->helper('facebook')->isActiveLike()) {
            return TRUE;
        }

        return FALSE;
    }

    public function isHidden()
    {
        return FALSE;
    }

}
