<?php

/**
 * 菜单消息推送模型
 */
class MenuInfoM extends MY_Model{
	protected $_tableName = 'menu_info';
	protected $_insertFields = array('type_id','title','description','picurl','url');

	/**
	 * 提供更新菜单列表(中间那个个)
	 * @return [type] 菜单推送列表数据
	 */
	public function getMenuType(){
		$data = $this->db->get('num');
		return $data->result('array');
	}

	/**
	 * 菜单事件自动回复使用
	 * @param  [type] $type [菜单类型]
	 * @return array       数据和条数
	 */
	public function getCurInfo($type){
		//先获取最新的此类型下发送信息的条数
		$num = $this->db->get_where('w_num',array('type' => $type));
		$num = $num->result('array');
		//获取最新的，倒序排
		$this->db->order_by("id", "desc");
		$data = $this->db->get_where($this->_tableName,array('type_id' => $num[0]['id']),$num[0]['number']); 
		// echo $this->db->last_query();
		$data = $data->result('array');
		$count = count($data);
        $msg = '';
        foreach($data as $v){
          	$msg .= sprintf($this->config->item('wx_news_item'),$v['title'],$v['description'],$v['picurl'],$v['url']);
        }
        $re['count'] = $count;
        $re['msg'] = $msg;
        return $re;
	}

	/**
	 * 增加菜单信息，也就是更新
	 */
	public function addMenuInfo(){
		//接收数据构建数组
		$data = array();
		foreach($this->_insertFields as $v)
			$data[$v] = $this->input->post($v);

		foreach($data['type_id'] as $k => $v){
			if(!$v)
				continue;
			$result[$k]['type_id'] = $v;
			$result[$k]['title'] = $data['title'][$k];
			$result[$k]['description'] = $data['description'][$k];
			$result[$k]['picurl'] = $data['picurl'][$k];
			$result[$k]['url'] = $data['url'][$k];
			$result[$k]['addtime'] = date('Y-m-d H:i:s');
		}
		//不为空时循序插入 到数据库
		if(!empty($result)){
				foreach($result as $k => $v){
				$this->db->insert($this->_tableName,$v);
				$arr[] = $v['type_id'];
			}
			//维护数量表,先求出同种类型的数量
			$num = array_count_values($arr);
			//更新数量表
			foreach($num as $k => $v){
				$this->db->update('num', array('number' => $v), array('id' => $k));
			}
		}
	}
}