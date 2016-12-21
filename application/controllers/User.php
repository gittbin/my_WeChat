<?php

/**
 * 用户信息控制器
 */
class User extends MY_Controller{

	/**
	 * 显示用户列表
	 * @return [type] [description]
	 */
    public function lst(){
        $this->load->model('UserM');
        $data = $this->UserM->search();
        $this->load->view('userlist',$data);
    }

    /**
     * 更新用户 慎用！将会删除数据库，重新下载
     * @return [type] [description]
     */
    public function uploadUser(){
    	$this->load->model('UserM');
    	$re = $this->UserM->setUser();
    	if($re){
    		$this->jump(site_url('c=User&m=lst'),'更新成功！');
    	}else{
    		$this->jump(site_url('c=User&m=lst'),'更新失败！'.$this->UserM->getError());
    	}
    }

}