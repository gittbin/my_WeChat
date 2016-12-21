<?php
/**
 * 提供了基础的几个数据库操作的方法
 * 注意数据插入都没有使用接收表单第二个参数true过滤
 */

class MY_Model extends CI_Model{
	//表名，用于重写,如果要操作表，必须重写！
	protected $_tableName;
	//允许接收的字段 这里需要模型接收post数据重写
	protected $_insertFields;
	protected $_updateFields;
	protected $_error = '';

	/**
	 * 提供错误获取
	 * @return [type] [description]
	 */
	public function getError(){
		//将错误信息存储到log
		$str = date('Y-m-d H:i:s').' info:'.$msg;
		file_put_contents('./wx/err.log', $str,FILE_APPEND);
		return $this->_error;
	}
	/**
	 * 根据字段id查找这条记录
	 * @param  [type] $id 字段id
	 * @return [type]     bool || array
	 */
	public function find($id){
		$data = $this->db->get_where($this->_tableName,array('id'=>$id));
		$data = $data->result('array');
		if($data)
			return $data[0];
		return FALSE;
	}

	/**
	 * 根据id删除
	 * @param  [type] $id 数据表的字段id
	 * @return [type]     int || bool
	 */
	public function delete($id){
		//模仿tp中的钩子函数 之后的没写了
		if(method_exists($this, '_before_delete'))
			if($this->_before_delete($id) === FALSE)
				return FALSE;
		$re = $this->db->delete($this->_tableName, array('id' => $id));
		//删除之后
		if($re){
			if(method_exists($this, '_before_delete'))
				$this->_before_delete($id);
			return $re;
		}
		return FALSE;
	}

	/**
	 * 接收表单，并添加到数据库 返回添加后的id 或者false
	 * @return [type]     int || bool
	 */
	public function add($data=null){
		//如果没有数据传入,接收数据构建数组
		if($data == null){
			$data = array();
			foreach($this->_insertFields as $v){
				$data[$v] = $this->input->post($v);
			}
		}

		//模仿tp中的钩子函数
		if(method_exists($this, '_before_add'))
			if($this->_before_add($data) === FALSE)
				return FALSE;

		//插入数据库 如果成功获取新插入的id
		if($this->db->insert($this->_tableName,$data)){
			$new_id = $this->db->insert_id();
		}else{
			die('插入失败!');
			return FALSE;
		}

		if(method_exists($this, '_after_add'))
			$this->_after_add($new_id);
		return $new_id;
	}

	/**
	 * 修改的模型方法，以隐藏的字段id修改
	 * @return [type] bool
	 */
	public function save(){
		//设置条件
		$this->db->where('id',(int)$this->input->post('id'));

		//接收数据构建数组
		$data = array();
		foreach($this->_updateFields as $v)
			$data[$v] = $this->input->post($v);
		//模仿tp中的钩子函数
		if(method_exists($this, '_before_update'))
			if($this->_before_update($data) === FALSE)
				return FALSE;
		//更新数据库
		$re = $this->db->update($this->_tableName, $data);
		if(!$re)
			return FALSE;
		if(method_exists($this, '_after_update'))
			$this->_after_update($data);
		return $re;
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
}