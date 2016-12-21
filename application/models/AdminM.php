<?php

/**
 * 后台登录模型
 */
class AdminM extends CI_Model{
	protected $_tableName = 'admin';
	/**
	 * 登录验证，账号和密码
	 * @return [type] bool
	 */
	public function checkLogin(){
		//接收三个字段
		$user = $this->input->post('username');
		$pass = $this->input->post('password');
		$cap = $this->input->post('captcha');
		//数据库获取
		$data = $this->db->get_where('w_admin',array('username' => $user));
		// echo $this->db->last_query();
		$data = $data->result('array');
		if($data){
			if($data[0]['password'] == md5($pass)){
				//设置登录标识
				$sess_user = array('username' => $data[0]['username']);
				$this->session->set_userdata($sess_user);
				return TRUE;
			}
		}
		return FALSE;
	}
}