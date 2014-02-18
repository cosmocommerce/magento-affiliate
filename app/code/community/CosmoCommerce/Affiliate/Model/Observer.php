<?php
class CosmoCommerce_Affiliate_Model_Observer
{
    const COOKIE_KEY_SOURCE = 'cosmocommerce_affiliate_source';
    const COOKIE_KEY_ID = 'cosmocommerce_affiliate_id';
    public function httppost($url, $data='', $method='GET'){ 
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer
        if($method=='POST'){
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            if ($data != ''){
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
            }
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $tmpInfo = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        return $tmpInfo; // 返回数据
    }
    public function captureReferral(Varien_Event_Observer $observer)
    {
        $frontController = $observer->getEvent()->getFront();

        $utmSource = $frontController->getRequest()
            ->getParam('utm_source', false);

        if ($utmSource) {
            Mage::getModel('core/cookie')->set(
                self::COOKIE_KEY_SOURCE, 
                $utmSource, 
                $this->_getCookieLifetime()
            );
        }
        
        
        $utmId = $frontController->getRequest()
            ->getParam('txId', false);
        if ($utmId) {
            Mage::getModel('core/cookie')->set(
                self::COOKIE_KEY_SOURCE, 
                $utmId, 
                $this->_getCookieLifetime()
            );
        }

        Mage::log($utmSource,null,'cps.log');
        Mage::log($utmId,null,'cps.log');
    }

    public function orderPaid(Varien_Event_Observer $observer)
    {
       
        $order = $event->getInvoice()->getOrder(); // Mage_Sales_Model_Order
    	/*
    		- Check order amount
    		- Get customer object
    		- Set Group id
    		- $customer->save();
    	*/
    	return $this;
        $return=$this->httppost('https://www.chinesean.com/affiliate/tracking3.do?pId=11282&tracking=100000184&cpa=&cpl=&cps=228,TIERID&txId=be14444518d45','','GET');
    }

    protected function _getCookieLifetime()
    {
        $days = Mage::getStoreConfig(
            'cosmocommerce_affiliate/cookie/timeout'
        );

        // convert to seconds
        return (int)86400 * $days;
    }
}