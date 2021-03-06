<?php
/**
 * @category    Bubble
 * @package     Bubble_AttributeOptionPro
 * @version     1.1.2
 * @copyright   Copyright (c) 2014 BubbleShop (https://www.bubbleshop.net)
 */
$installer = $this;
/* @var $installer Mage_Eav_Model_Entity_Setup */

$installer->startSetup();

try {
    $installer->run("
    ALTER TABLE `{$this->getTable('catalog_eav_attribute')}`
        ADD `image` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
    ");
} catch (Exception $e) {
    Mage::logException($e);
}

$installer->endSetup();
