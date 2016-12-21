<?php

/**
 * 基础控制器
 */
class MY_Controller extends CI_Controller{

	/**
	 * 构造方法，用于校验登录
	 */
	function __construct(){
		parent::__construct();
		//判断是否登录 获取当前的控制器和方法
		$con = $this->router->fetch_class();
		$func = $this->router->fetch_method();
		//未登录允许访问的控制器
		if(strtolower($con) == 'index' || strtolower($con) == 'admin' && strtolower($func) != 'index' ){
			//这些不登录也可访问
		}else{
			if(!$this->session->userdata('username')){
				redirect('c=admin&m=login');
			}
		}
	}

	/**通过curl请求数据
   * @param  [type]   $url  请求的url
   * @param  boolean  $https  是否安全请求
   * @param  string   $method 请求方式
   * @param  [type]   $data   post请求的数据
   * @return [type]   请求返回的数据 
   */     
	protected function _request($url,$https=TRUE,$method='get',$data=null){
		//初始化
		$ch = curl_init();
		//URL
		curl_setopt($ch, CURLOPT_URL, $url);
		//不需要头信息,此处指响应头信息
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		//不进行打印
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		if($https){
			//不做认证
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		}
		if(strtolower($method)=='post'){
			curl_setopt($ch, CURLOPT_POST, TRUE);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		}
		//抓取url
		$content = curl_exec($ch);
		//关闭curl资源
		curl_close($ch);
		return $content;
	}

	/**获取access_token 调用接口的凭证
	* @return int  accesstoken
    */
	protected function _getToken(){
		$file = './wx/accesstoken';
		@$content = file_get_contents($file);
		$content = json_decode($content);
		//如果此文件不存在或者为空或者已经过期,重新请求一次
		if(!$content || time()-filemtime($file)>$content->expires_in){
			$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->config->item('APPID')."&secret=".$this->config->item('APPSECRET');
			//重新请求token
			$data = $this->_request($url);
			file_put_contents($file, $data);
			$content = $data;
			$content = json_decode($content);
		}
		//如果获取凭证出错
		if(isset($content->errcode))
			die('获取token出现异常');

		return $content->access_token;
	}

	/**
	 * 跳转
	 * @param  [type]  $url     [跳转的链接]
	 * @param  [type]  $message [提示信息]
	 * @param  integer $wait    [等待时间]
	 * @return [type]           [description]
	 */
	protected function jump($url,$message,$wait=3){
		if($wait == 0){
			header("Location:$url");
		}else{
			$this->load->view('message',array(
				'url' => $url,
				'message'	=> $message,
				'wait'	=> $wait
			));
		}
	}
}