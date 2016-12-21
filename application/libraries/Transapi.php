<?php
/**
 * 百度翻译api接口类
 */

class Transapi{
	private $_app_id = '';
	private $_sec_key = '';
	private $_url = 'http://api.fanyi.baidu.com/api/trans/vip/translate';

	/***************翻译入口*********************/
	/**
	 * 翻译入口
	 * @param  [type] $query 查询的内容
	 * @param  [type] $from  源语言
	 * @param  [type] $to    目标语言
	 * @return [type]        翻译结果(数组)
	 */
	public function translate($query, $to, $from='auto')
	{
	    $args = array(
	        'q' => $query,
	        'appid' => $this->_app_id,
	        'salt' => rand(10000,99999),
	        'from' => $from,
	        'to' => $to,

	    );
	    $args['sign'] = $this->buildSign($query, $this->_app_id, $args['salt'], $this->_sec_key);
	    $ret = $this->call($this->_url, $args);
	    $ret = json_decode($ret, true);
	    return $ret; 
	}

	//加密
	/**
	 * [buildSign description]
	 * @param  [type] $query  查询的内容
	 * @param  [type] $appID  id
	 * @param  [type] $salt   随机数
	 * @param  [type] $secKey 密钥
	 * @return [type]         md5解密后的字符串
	 */
	private function buildSign($query, $appID, $salt, $secKey)
	{/*{{{*/
	    $str = $appID . $query . $salt . $secKey;
	    $ret = md5($str);
	    return $ret;
	}/*}}}*/

	//发起网络请求
	/**
	 * [call description]
	 * @param  [type]  $url      url
	 * @param  [type]  $args     请求的数据
	 * @param  string  $method   方式
	 * @param  integer $testflag 未知
	 * @param  [type]  $timeout  超时设置
	 * @param  array   $headers  是否设置header
	 * @return [type]            查询结果
	 */
	private function call($url, $args=null, $method="post", $testflag = 0, $timeout = 10, $headers=array())
	{/*{{{*/
	    $ret = false;
	    $i = 0; 
	    //用来如果不成功 重复请求一次
	    while($ret === false) 
	    {
	        if($i > 1)
	            break;
	        if($i > 0) 
	        {
	            sleep(1);
	        }
	        $ret = $this->callOnce($url, $args, $method, false, $timeout, $headers);
	        $i++;
	    }
	    return $ret;
	}/*}}}*/

	/**
	 * curl配置，请求
	 * @param  [type]  $url        [description]
	 * @param  [type]  $args       [description]
	 * @param  string  $method     [description]
	 * @param  boolean $withCookie [description]
	 * @param  [type]  $timeout    [description]
	 * @param  array   $headers    [description]
	 * @return [type]              [description]
	 */
	private function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = 10, $headers=array())
	{/*{{{*/
	    $ch = curl_init();
	    if($method == "post") 
	    {
	        $data = $this->convert($args);
	        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	        curl_setopt($ch, CURLOPT_POST, 1);
	    }
	    else 
	    {
	        $data = $this->convert($args);
	        if($data) 
	        {
	            if(stripos($url, "?") > 0) 
	            {
	                $url .= "&$data";
	            }
	            else 
	            {
	                $url .= "?$data";
	            }
	        }
	    }
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    if(!empty($headers)) 
	    {
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    }
	    if($withCookie)
	    {
	        curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
	    }
	    $r = curl_exec($ch);
	    curl_close($ch);
	    return $r;
	}/*}}}*/

	/**
	 * urlencode
	 * @param  [type] &$args [description]
	 * @return [type]        [description]
	 */
	private function convert(&$args)
	{/*{{{*/
	    $data = '';
	    if (is_array($args))
	    {
	        foreach ($args as $key=>$val)
	        {
	            if (is_array($val))
	            {
	                foreach ($val as $k=>$v)
	                {
	                    $data .= $key.'['.$k.']='.rawurlencode($v).'&';
	                }
	            }
	            else
	            {
	                $data .="$key=".rawurlencode($val)."&";
	            }
	        }
	        return trim($data, "&");
	    }
	    return $args;
	}/*}}}*/
}

/**
 * 使用说明 设置相关的配置
 * $new = new Transapi();
 * $new ->translate();
 */