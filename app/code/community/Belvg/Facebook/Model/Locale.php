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
 * Available FB locales
 */
class Belvg_Facebook_Model_Locale extends Mage_Core_Model_Abstract
{

    /**
     *
     * @var SimpleXMLElement|NULL
     */
    protected $_locales = NULL;

    const FB_DEFAULT_LOCALE = 'en_US';

    /**
     * Read locales
     */
    public function __construct()
    {
        $classArr = explode('_', get_class($this));
        $moduleName = $classArr[0] . '_' . $classArr[1];
        $etcDir = Mage::getConfig()->getModuleDir('etc', $moduleName);

        $fileName = $etcDir . DS . 'locale.xml';
        if (is_readable($fileName)) {
            $localesXml = file_get_contents($fileName);
            $this->_locales = new Varien_Simplexml_Element($localesXml);
        }
    }

    /**
     * Get current FB locale according to the selected store locale
     *
     * @return string
     */
    public function getLocale()
    {
        $store_locale = Mage::app()->getLocale()->getLocaleCode();
        $localeParams = array();

        if (isset($this->_locales->$store_locale)) {
            $localeParams = new Varien_Object($this->_locales->$store_locale->asArray());
        }

        $locale = isset($localeParams['code']) ? $localeParams['code'] : self::FB_DEFAULT_LOCALE;

        return $locale;
    }

}
