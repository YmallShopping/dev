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
class Belvg_Facebook_Block_Links_Button extends Mage_Core_Block_Template
{

    /**
     * Get image for the connect button
     *
     * @return string
     */
    public function getImage()
    {
        $img_button = $this->getDefaultImage();

        if ($image = $this->helper('facebook')->getImageLogin()) {
            $img_button_path = Mage::getBaseDir(Mage_Core_Model_Store::URL_TYPE_MEDIA) . DS . 'facebook' . DS . $image;

            // if configured image was foud - use it
            if (file_exists($img_button_path)) {
                $img_button = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . 'facebook/' . $image;
            }
        }

        return $img_button;
    }

    /**
     * Get default image button
     *
     * @return string
     */
    public function getDefaultImage()
    {
        return $this->getSkinUrl($this->helper('facebook')->getDefaultImageLogin());
    }

}