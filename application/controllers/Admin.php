<?php

/**
 * 后台控制器
 */
class Admin extends MY_Controller{
	
	/**
	 * 首页
	 * @return [type] [description]
	 */
	public function index(){

		$this->load->view('index');
	}

	/**
	 * 退出登录
	 * @return [type] [description]
	 */
	public function logout(){
		$this->session->unset_userdata('username');
		redirect('c=admin&m=login');
	}

	/**
	 * 登录验证
	 * @return [type] [description]
	 */
	public function login(){
		if(empty($_POST))
			$this->load->view('login');
		else{
			$this->load->library('form_validation');
			//验证表单
			$this->form_validation->set_rules('username', '用户名', 'required');
			$this->form_validation->set_rules('password', '密码', 'required');
			$this->form_validation->set_rules('captcha', '验证码', 'required');
			$this->form_validation->set_rules('captcha', '验证码', 'callback_captcha_check');
			//验证表单
			if($this->form_validation->run() === FALSE){
				$this->jump(site_url('c=admin&m=login'),validation_errors());
				return;
			}
			$this->load->model('AdminM');
			//验证账号和密码是否错误
			$re = $this->AdminM->checkLogin();
			if($re)
				$this->jump(site_url('c=admin&m=index'),'登录成功');
			else
				$this->jump(site_url('c=admin&m=login'),'登录失败,账号或者密码错误!');
		}
	}

	/**
	 * 产生验证码
	 * @return [type] [description]
	 */
	public function captcha(){
		$this->load->library('Captcha');	//载入自己的验证码类
		$this->captcha->generateCode();		//生成验证码，注意之后的验证码数据只有生成验证码之后才能获取
		$sess_cap = array('captcha' => $this->captcha->getCode());
		$this->session->set_userdata($sess_cap);	//存到session
	}

	/**
	 * 校验验证码
	 * @return [type] [description]
	 */
	public function captcha_check(){
		$code = $this->input->post('captcha');
		if($this->session->userdata('captcha') == trim(strtolower($code))){
			return TRUE;
		}
		$this->form_validation->set_message('captcha_check', '验证码不正确!');
		return false;
	}
}