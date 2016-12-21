<?php
/**
 * 聊天信息模型
 */

class ExchangeM extends MY_Model{

	protected $_tableName = 'exchange';

    /**
     * 增加记录
     * @param [type] $data [description]
     */
	public function addContent($data){
        //需要将其中的openid 转化成用户名
        $re = $this->db->get_where('user',array('openid'=>$data['user']),1);
        $re = $re->result('array');
        $data['user'] = $re[0]['nickname'];
        $this->add($data);
    }

    /**
     * 提供获取列表的方法
     * @param  integer $page [description]
     * @return [type]        [description]
     */
    public function getList($page=10){
        $count = $this->db->count_all_results($this->_tableName);
        // echo $this->db->last_query();
        //载入分页类
        $this->load->library('pagination');
        $config['base_url'] = site_url('c=Message&m=exchange');
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