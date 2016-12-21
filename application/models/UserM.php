<?php
 
/**
 * 用户模型
 */
class UserM extends MY_Model{
    protected $_tableName = 'user';

    /**
     * 关注后添加到数据库
     * @param [type] $openid [description]
     */
    public function addUser($openid){
        //先获取其的详细信息
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->_getToken().'&openid='.$openid.'&lang=zh_CN';
        $re = $this->_request($url);
        $re = json_decode($re,TRUE);
        if($re['subscribe']){
            $this->add($re);
        }else{
            $this->_error = '错误代码:'.$re['errcode'];
            $this->getError();
        }
    }

    /**
     * 取消关注从数据库删除
     * @param  [type] $openid [description]
     * @return [type]         [description]
     */
    public function delUser($openid){
        $this->db->delete($this->_tableName, array('openid' => $openid));
    }

    /**
     * 粉丝列表获取显示，搜索
     * @param  integer $page [description]
     * @return [type]        [description]
     */
    public function search($page=10){
        $where = array();
        $key = $this->input->post('keywords');
        if($key)
            $where['nickname like'] = '%'.$key.'%';
        //取出总数
        $count = $this->db->where($where)->count_all_results($this->_tableName);
        // echo $this->db->last_query();
        //载入分页类
        $this->load->library('pagination');
        $config['base_url'] = site_url('c=User&m=lst');
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
        $data = $this->db->order_by('subscribe_time','DESC')->get_where($this->_tableName,$where,$page,$offset);
        //数据返回
        return array(
            'data' => $data,
            'pageString' => $pageString,
        );
    }

	/**获取关注的用户列表
     * @param  [type] 从多少个开始获取，默认从头
     * @return array() 用户openid数组
     */
    public function getUserList($next_openid=''){
        $url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->_getToken().'&next_openid='.$next_openid;
        $result = $this->_request($url);
        //从返回的json信息中将所有的信息转化成数组
        $result = json_decode($result,TRUE);
        if(!$result['data']){
        	return FALSE;
        }
        return $result['data']['openid'];
    }

    /**
     * 重新从微信服务器取得数据
     */
    public function setUser(){
        //清空数据表
        $this->db->query('TRUNCATE w_user');
        $list = $this->getUserList();
        if($list === FALSE)
            return FALSE;
        $count = count($list);
        $data = array();
        if($count <= 100){
            foreach($list as $k=>$v){
                $data['user_list'][$k]['openid'] = $v;
            }
            $data = json_encode($data);
            $result = $this->addUserInfo($data);
            if($result)
                return TRUE;
            else
                return FALSE;
        }else{
            //当大于100的时候
            $num = ceil($count/100);
            for($i=0;$i<$num;$i++){
                for($j=$i*100;$j<$i*100+100;$j++){
                    $data['user_list'][$j]['openid'] = $list[$j];
                }
                $data = json_encode($data);
                $result = $this->addUserInfo($data);
                if($result)
                    return TRUE;
                else
                    return FALSE;
            }
        }        
    }

    /**
     * 批量的用户将数据存到数据库
     * @param [type] $data [description]
     */
    private function addUserInfo($data){
        //批量获取
        $url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token='.$this->_getToken();
        $re = $this->_request($url,TRUE,'post',$data);
        $re = json_decode($re,TRUE);
        //收到用户信息成功
        if(@$re['user_info_list']){
            foreach($re['user_info_list'] as $k =>$v){
                $this->add($v);
            }
            return TRUE;
        }else{
            $this->_error = '错误代码:'.$re['errcode'];
            return FALSE;
        }
    }

    /**
     * 钩子方法
     * @param  [type] &$data [description]
     * @return [type]        [description]
     */
    protected function _before_add(&$data){
        //将最后一个数组转成字符串
        $data['tagid_list'] = implode(',', $data['tagid_list']);
    }
}