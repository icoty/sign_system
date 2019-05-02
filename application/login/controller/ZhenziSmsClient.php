<?php 
namespace app\login\controller;
class ZhenziSmsClient{
	private $appId;
	private $appSecret;
	private $apiUrl;

	function __construct($apiUrl, $appId,$appSecret) {
        $this->apiUrl = $apiUrl;
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    function send($number, $message){
    	$url = $this->apiUrl . "/sms/send.do";
    	$postdata = array("appId"=>$this->appId,"appSecret"=>$this->appSecret,"number"=>$number,"message"=>$message);
    	$postdata = http_build_query($postdata);  
		$result = $this->http_request($url, $postdata);
		echo $result;
	}

	function balance(){
    	$url = $this->apiUrl . "/account/balance.do";
    	$postdata = array("appId"=>$this->appId,"appSecret"=>$this->appSecret);
    	$postdata = http_build_query($postdata);  
		$result = $this->http_request($url, $postdata);
		echo $result;
	}

	function http_request($url, $postdata){
		$curl = curl_init();
		/* 设置验证方式 */
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//设置返回结果为流
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 15);//设置请求超时时间
        curl_setopt($curl, CURLOPT_TIMEOUT, 60);//设置响应超时时间
        /* 设置通信方式 */
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);//使用urlencode格式请求
        $result = curl_exec($curl);//获取返回结果集
        curl_close($curl);//关闭请求会话
        echo $result;
	}
}


?>