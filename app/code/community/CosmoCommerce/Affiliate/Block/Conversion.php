<?php
class CosmoCommerce_Affiliate_Block_Conversion extends Mage_Core_Block_Template
{
    public function IsEnabled()
    {
        return Mage::getStoreConfig('cosmocommerce_affiliate/general/status') ? true : false;
    }

    public function getMerchantId()
    {
        return Mage::getStoreConfig('cosmocommerce_affiliate/general/merchant_id');
    }

    public function getAffiliateType()
    {
        return Mage::getModel('core/cookie')->get(
            CosmoCommerce_Affiliate_Model_Observer::COOKIE_KEY_SOURCE
        );
    }
    public function getAffiliateId()
    {
        return Mage::getModel('core/cookie')->get(
            CosmoCommerce_Affiliate_Model_Observer::COOKIE_KEY_ID
        );
    }
}