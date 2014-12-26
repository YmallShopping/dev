<?php

class Belvg_Facebook_Helper_Config extends Mage_Core_Helper_Data
{

    const XML_PATH_FB_ENABLED = 'facebook/settings/enabled';
    const XML_PATH_FB_APP_ID = 'facebook/settings/appid';
    const XML_PATH_FB_APP_SECRET = 'facebook/settings/secret';
    const XML_PATH_FB_CONNECT_IMAGE = 'facebook/settings/imglogin';
    const XML_PATH_FB_CONNECT_DEFIMAGE = 'facebook/settings/defimage';
    const XML_PATH_FB_LIKE_ENABLED = 'facebook/like/enabled';
    const XML_PATH_FB_LIKE_LAYOUT = 'facebook/like/layout';
    const XML_PATH_FB_LIKE_ACTION = 'facebook/like/action';
    const XML_PATH_FB_LIKE_FACES = 'facebook/like/faces';
    const XML_PATH_FB_LIKE_WIDTH = 'facebook/like/width';
    const XML_PATH_FB_LIKE_COLOR = 'facebook/like/color';
    const XML_PATH_FB_SEND_ENABLED = 'facebook/send/enabled';
    const XML_PATH_FB_SEND_COLOR = 'facebook/send/color';
    const XML_PATH_FB_SEND_FONT = 'facebook/send/font';
    const XML_PATH_FB_COMMENTS_ENABLED = 'facebook/comments/enabled';
    const XML_PATH_FB_COMMENTS_POSTS = 'facebook/comments/posts';
    const XML_PATH_FB_COMMENTS_WIDTH = 'facebook/comments/width';
    const XML_PATH_FB_COMMENTS_COLOR = 'facebook/comments/color';
    const XML_PATH_FB_ACTIVITY_ENABLED = 'facebook/activity/enabled';
    const XML_PATH_FB_ACTIVITY_WIDTH = 'facebook/activity/width';
    const XML_PATH_FB_ACTIVITY_HEIGHT = 'facebook/activity/height';
    const XML_PATH_FB_ACTIVITY_HEADER = 'facebook/activity/header';
    const XML_PATH_FB_ACTIVITY_COLOR = 'facebook/activity/color';
    const XML_PATH_FB_ACTIVITY_FONT = 'facebook/activity/font';
    const XML_PATH_FB_ACTIVITY_RECOMENDATIONS = 'facebook/activity/recomendations';
    const XML_PATH_FB_ACTIVITY_MAXAGE = 'facebook/activity/maxage';
    const XML_PATH_FB_WISHLIST_ENABLED = 'facebook/wishlist/enabled';
    const XML_PATH_FB_WISHLIST_DESCRIPTION = 'facebook/wishlist/note';
    const XML_PATH_FB_ORDER_ENABLED = 'facebook/order/enabled';
    const XML_PATH_FB_ORDER_DESCRIPTION = 'facebook/order/note';

    /**
     * Check if module is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActive($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_ENABLED, $store);
    }

    /**
     * Get application ID (see https://developers.facebook.com/apps/)
     *
     * @param mixed $store
     * @return string
     */
    public function getAppId($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_APP_ID, $store);
    }

    /**
     * Get application secret key
     *
     * @param mixed $store
     * @return string
     */
    public function getAppSecret($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_APP_SECRET, $store);
    }

    /**
     * Check if like option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveLike($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_LIKE_ENABLED, $store);
    }

    /**
     * Check if send option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveSend($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_SEND_ENABLED, $store);
    }

    /**
     * Check if comments option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveComments($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_COMMENTS_ENABLED, $store);
    }

    /**
     * Check if like option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveActivity($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_ACTIVITY_ENABLED, $store);
    }

    /**
     * Check if share wishlist option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveWishlist($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_WISHLIST_ENABLED, $store);
    }

    /**
     * Get wishlist secription
     *
     * @param string $product
     * @param mixed $store
     * @return boolen
     */
    public function getWishlistDescription($product, $store = '')
    {
        $pattern = Mage::getStoreConfig(self::XML_PATH_FB_WISHLIST_DESCRIPTION, $store);
        return str_replace('{product}', $product, $pattern);
    }

    /**
     * Check if share wishlist option is enabled
     *
     * @param mixed $store
     * @return boolen
     */
    public function isActiveOrder($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_ORDER_ENABLED, $store);
    }

    /**
     * Get wishlist secription
     *
     * @param string $product
     * @param mixed $store
     * @return boolen
     */
    public function getOrderDescription($product, $store = '')
    {
        $pattern = Mage::getStoreConfig(self::XML_PATH_FB_ORDER_DESCRIPTION, $store);
        return str_replace('{product}', $product, $pattern);
    }

    /**
     * Get like button layout
     *
     * @return string
     */
    public function getLikeLayout($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_LIKE_LAYOUT, $store);
    }

    /**
     * Get like button layout
     *
     * @return string
     */
    public function getLikeAction($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_LIKE_ACTION, $store);
    }

    /**
     * Show profile pictures below the button.
     *
     * @return string (fb:like accepts true/false param)
     */
    public function isFacesLikeActive($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_LIKE_FACES, $store) ? 'true' : 'false';
    }

    /**
     * The width of the like plugin, in pixels.
     *
     * @return int
     */
    public function getLikeWidth($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_LIKE_WIDTH, $store);
    }

    /**
     * The width of the activity plugin, in pixels.
     *
     * @return int
     */
    public function getActivityWidth($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_ACTIVITY_WIDTH, $store);
    }

    /**
     * The height of the activity plugin, in pixels.
     *
     * @return int
     */
    public function getActivityHeight($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_ACTIVITY_HEIGHT, $store);
    }

    /**
     * Whether to show activity header
     *
     * @return bool
     */
    public function isActivityHeader($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_ACTIVITY_HEADER, $store) ? 'true' : 'false';
    }

    /**
     * Whether to show recomendations in activity plugin
     *
     * @return bool
     */
    public function isActivityRecomendations($store = '')
    {
        return Mage::getStoreConfigFlag(self::XML_PATH_FB_ACTIVITY_RECOMENDATIONS, $store) ? 'true' : 'false';
    }

    /**
     * The color scheme of the like plugin.
     *
     * @return string
     */
    public function getActivityMaxAge($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_ACTIVITY_MAXAGE, $store);
    }

    /**
     * The color scheme of the like plugin.
     *
     * @return string
     */
    public function getLikeColor($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_LIKE_COLOR, $store);
    }

    /**
     * The color scheme of the send plugin.
     *
     * @return string
     */
    public function getSendColor($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_SEND_COLOR, $store);
    }

    /**
     * The color scheme of the activity plugin.
     *
     * @return string
     */
    public function getActivityColor($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_ACTIVITY_COLOR, $store);
    }

    /**
     * The font of the send plugin.
     *
     * @return string
     */
    public function getSendFont($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_SEND_FONT, $store);
    }

    /**
     * The font of the activity plugin.
     *
     * @return string
     */
    public function getActivityFont($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_ACTIVITY_FONT, $store);
    }

    /**
     * The number of visible comments
     *
     * @return int
     */
    public function getCommentsPosts($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_COMMENTS_POSTS, $store);
    }

    /**
     * The width of the comments plugin, in pixels.
     *
     * @return int
     */
    public function getCommentsWidth($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_COMMENTS_WIDTH, $store);
    }

    /**
     * The color scheme of the сщььутеы plugin.
     *
     * @return string
     */
    public function getCommentsColor($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_COMMENTS_COLOR, $store);
    }

    /**
     * Get name of the configured connect button image
     *
     * @return string
     */
    public function getImageLogin($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_CONNECT_IMAGE, $store);
    }

    /**
     * Get name of the default connect button image
     *
     * @return string
     */
    public function getDefaultImageLogin($store = '')
    {
        return Mage::getStoreConfig(self::XML_PATH_FB_CONNECT_DEFIMAGE, $store);
    }

}
