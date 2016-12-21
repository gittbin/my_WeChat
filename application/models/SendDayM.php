<?php

/**
 * 每日推荐信息模型
 */
class SendDayM extends MY_Model{
	protected $_tableName = 'send_day';

    /**
     * 每日群发文本记录，保存到相对于图文中的简要说明字段
     */
    public function addText($content){
        //构建数组
        $data['admin_name'] = $this->session->userdata('username');
        $data['digest'] = htmlspecialchars($content);
        $data['addtime'] = date('Y-m-d H:i:s');
        $this->add($data);
    }

    /**
     * 每日推荐增加图文记录
     * @param [type] $data [description]
     */
	public function addInfo($data){
		//因为之前进行过url编码，需要进行一下操作
		$data = json_encode($data);
        $data = urldecode($data);
        $data = json_decode($data,TRUE);
        //不止一条，并且是一个二维数组
        for($i=0;$i<count($data);$i++){
        	$msg = $data[$i];
        	unset($msg['content']);
	        unset($msg['show_cover_pic']);
	        $msg['addtime'] = date('Y-m-d H:i:s');
	        $msg['admin_name'] = $this->session->userdata('username');
	        $this->add($msg);
        }
	}

    /**
     * 获取每日推荐的列表
     * @param  integer $page [description]
     * @return [type]        [description]
     */
	public function getList($page=10){
        $count = $this->db->count_all_results($this->_tableName);
        // echo $this->db->last_query();
        //载入分页类
        $this->load->library('pagination');
        $config['base_url'] = site_url('c=Message&m=sendDay');
        $config['total_rows'] = $count;
        $config['per_page'] = $page;
        //翻页是保持条件
        $config['reuse_query_string'] = TRUE;
        $config['first_link'] = '首页';
        $config['next_link'] = '下一页';
        $config['prev_link'] = '上一页';
        $config['last_link'] = '尾页';
        //根据config数组配置分页类，可以知己创建配置文件
        $this->pagination->initialize($config);
        //生成翻页字符串
        $pageString = $this->pagination->create_links();
        //根据当前页计算偏移量
        $offset = (max(1,(int)$this->pagination->cur_page)-1)*$page;
        /***********取数据***************/
        $data = $this->db->order_by('id','DESC')->get($this->_tableName,$page,$offset);
        //数据返回
        return array(
            'data' => $data,
            'pageString' => $pageString,
        );
    }
}