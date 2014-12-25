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
 * Parse request token
 */
class Belvg_Facebook_Model_Request extends Varien_Object
{

    const FB_REQUEST_URL = 'https://graph.facebook.com/oauth/access_token?client_id=%s&redirect_uri=&client_secret=%s&code=%s';
    const FB_USER_URL = 'https://graph.facebook.com/%s?access_token=%s';

    /**
     * Send request to FB
     *
     * @param string $url
     * @return string
     * @throws Exception
     */
    private function getFbData($url)
    {
        $data = NULL;

        if (extension_loaded('curl')) {
            $request = curl_init();
            curl_setopt($request, CURLOPT_URL, $url);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, TRUE);
            $data = curl_exec($request);
        } else {
            throw new Exception('Curl extension should be loaded');
        }

        return $data;
    }

    /**
     * Get Application Token from FB cookie
     *
     * @return string
     * @throws Exception
     */
    public function getToken()
    {
        $app_id = Mage::helper('facebook')->getAppId();
        $secret = Mage::helper('facebook')->getAppSecret();

        if ($data = Mage::getModel('facebook/request_cookie')->getParsedCookie()) {
            if (isset($data['code'])) {
                $url = sprintf(self::FB_REQUEST_URL, $app_id, $secret, $data['code']);
                $token_response = $this->getFbData($url);
                parse_str($token_response, $signed_request);

                if (isset($signed_request['access_token'])) {
                    return $signed_request['access_token'];
                }

                throw new Exception('Access Token not found');
            }

            throw new Exception('Request code not found');
        } else {
            throw new Exception('False Signed Request');
        }

        return NULL;
    }

    /**
     * Load object data
     *
     * @param int $fb_id
     * @return array
     * @throws Exception
     */
    public function load($fb_id = 'me')
    {
        $url = sprintf(self::FB_USER_URL, $fb_id, $this->getToken());
        $user_data_json = $this->getFbData($url);

        $user_data = json_decode($user_data_json);
        if (is_null($user_data)) {
            throw new Exception('FB-connect user data parse error: ' . json_last_error());
        }

        return (array)$user_data;
    }
}