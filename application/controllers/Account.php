<?php

/**
 * 账户控制器
 */
class Account extends MY_Controller{

    /**获取关注二维码
     * @param integer   $expire  验证码有效期
     * @param string    $type    是否永久 
     * @param integer   $scene   场景id
     */
  	public function QRcode($expire=60*60*24,$type='temp',$scene=1){
		$ret = $this->_getTicket($expire,$type,$scene);
		$ret = json_decode($ret);
		//换取二维码
		$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.urlencode($ret->ticket);
		header('content-type:image/jpeg');
		echo $this->_request($url);
  	}

    /**获取获取二维码的ticket
     * @param integer   $expire  验证码有效期
     * @param string    $type    是否永久 
     * @param integer   $scene   场景id
     * @return [type]   integer
     */
  	private function _getTicket($expire=300,$type='temp',$scene=1){
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->_getToken();
		//获取临时二维码的ticket
		if($type=='temp'){
			$data = '{"expire_seconds": '.$expire.', "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": '.$scene.'}}}';
			return $this->_request($url,TRUE,'POST',$data);
		}else{
			$data = '{"expire_seconds": '.$expire.', "action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_str": '.$scene.'}}}';
			return $this->_request($url,TRUE,'POST',$data);
		}
  	}

}