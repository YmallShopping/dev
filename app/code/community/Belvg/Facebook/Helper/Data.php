<?php

class Belvg_Facebook_Helper_Data extends Belvg_Facebook_Helper_Config
{

    const SHARE_URL = 'http://www.facebook.com/sharer/sharer.php?s=100';

    /**
     * Return encoded current URL for after auth redirection
     *
     * @return string
     */
    public function getLoginUrl()
    {
        $referer = Mage::helper('core')->urlEncode(Mage::helper('core/url')->getCurrentUrl());
        return Mage::getUrl('facebook/customer/login', array('referer' => $referer, '_store'=>'mall'));
    }

    /**
     *
     * @return int
     */
    public function getFbUserId()
    {
        $user_id = NULL;

        if ($data = Mage::getModel('facebook/request_cookie')->getParsedCookie()) {
            $user_id = isset($data['user_id'])?$data['user_id']:NULL;
        }

        return $user_id;
    }

    /**
     * Share URL
     *
     * @param type $title
     * @param type $url
     * @param type $image_url
     * @param type $description
     * @return string
     */
    public function getShareUrl($title, $url, $image_url = NULL, $description = NULL)
    {
        $share_url = self::SHARE_URL;
        $share_url .= '&p[title]=' . urlencode($title);
        $share_url .= '&p[url]=' . urlencode($url);

        if ($image_url) {
            $share_url .= '&p[images][0]=' . urlencode($image_url);
        }

        if ($description) {
            $share_url .= '&p[summary]=' . urlencode($description);
        }

        return $share_url;
    }

}
