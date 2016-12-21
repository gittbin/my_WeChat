<?php

/**
 * 默认控制器
 */
class Index extends MY_Controller {

    /**
     * 默认方法路由分配
     * @return [type] [description]
     */
	public function route()
	{
		//尝试获取用户发送的信息
		@$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		if (empty($postStr)){   
          	//没有消息进入管理平台
            redirect('c=Admin&m=login');
        	echo '';
        }else{
        	//处理用户消息
            echo '';
        	$this->_responseMsg($postStr);
    	}
	}

    /**
     * 消息自动处理分配方法
     * @param  [type] $postStr 收到的用户信息
     * @return [type]          [description]
     */
	private function _responseMsg($postStr)
  	{  
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        //方法改进，直接采用拼接方法名
        $method = '_do'.$postObj->MsgType;
        if(method_exists($this, $method))
          $this->{$method}($postObj);
        else
          echo "";
        exit;
 	}

 	/**文本信息自动回复 机器人回复
	* @param  [type] 信息类型 
	* @return [type]
	*/
    private function _dotext($postObj){
        $keyword = trim($postObj->Content);
        $data['addtime'] = time();
        //现在是openid
        $data['user'] = $postObj->FromUserName;
        $data['content'] = htmlspecialchars($keyword);
        /********处理留言**********/
        if(mb_substr($keyword,0,2,'UTF-8') == '留言'){
            //调用模型中的方法，将留言数据存到数据库
            $this->load->model('LiuYanM');
            $this->LiuYanM->addContent($data);
            $content = '谢谢您的留言，祝心想事成';
        /*********处理翻译*************/
        }elseif(mb_substr($keyword, 0,2,'UTF-8')=='翻译'){
            $arr = explode('@', $keyword);
            if(count($arr)<3){
                $content = '请重新输入。可以翻译的语言有：
    中文,英语,文言文,粤语,日语,韩语,法语,泰语,西班牙,阿拉伯语,俄语,葡萄牙语,德语,意大利语,希腊语,荷兰语,波兰语,保加利亚语,爱沙尼亚语,丹麦语,芬兰语,捷克语,罗马尼亚语,斯洛文尼亚语,瑞典语,匈牙利语,繁体中文。
    格式: 翻译@英语@内容';
            }else{
                //可以翻译的语言
                $lan = array('zh'=>'中文','en'=>'英语','yue'=>'粤语','wyw'=>'文言文','jp'=>'日语','kor'=>'韩语','fra'=>'法语','th'=>'泰语','spa'=>'西班牙','ara'=>'阿拉伯语','ru'=>'俄语','pt'=>'葡萄牙语','de'=>'德语','it'=>'意大利语','el'=>'希腊语','nl'=>'荷兰语','pl'=>'波兰语','bul'=>'保加利亚语','est' =>'爱沙尼亚语','dan' =>'丹麦语','fin' =>'芬兰语','cs' =>'捷克语','rom' =>'罗马尼亚语','slo' =>'斯洛文尼亚语','swe' =>'瑞典语','hu'=>'匈牙利语','cht' =>'繁体中文');
                $to = $arr[1];
                $index = array_search($to,$lan);
                if($index === false){
                    $content = '对应的语言不可自动翻译。可以翻译的语言有：
    中文,英语,文言文,粤语,日语,韩语,法语,泰语,西班牙,阿拉伯语,俄语,葡萄牙语,德语,意大利语,希腊语,荷兰语,波兰语,保加利亚语,爱沙尼亚语,丹麦语,芬兰语,捷克语,罗马尼亚语,斯洛文尼亚语,瑞典语,匈牙利语,繁体中文。
    格式: 翻译@英语@内容';
                }else{
                    $query = $arr[2];
                    $this->load->library('Transapi');
                    //自己导入的类不是类原名，首字母是小写的
                    $ret = $this->transapi->translate($query,$index);
                    $content = $ret['trans_result'][0]['dst'];
                }
            }
        }else{
            //存储交流信息
            $this->load->model('ExchangeM');
            $this->ExchangeM->addContent($data);
            if(mb_substr($keyword,0,4,'UTF-8') == '联系方式'){
                $content = 'QQ:1160224892;微信号:tangxiaobin00';
            }else{
                //使用机器人回复
                /*******小黄鸡机器人*******/
                $url = 'http://www.niurenqushi.com/api/simsimi/';
                $data = 'txt='.$keyword;
                $content = $this->_request($url,false,'post',$data); 
                $content = json_decode($content);
                $content = $content->text;

                /*********小逗比机器人*********/
                // $url = 'http://www.xiaodoubi.com/bot/chat.php';
                // $data = 'chat='.$keyword;
                // $content = $this->_request($url,false,'post',$data);
            }
            
        }
        $resultStr = sprintf($this->config->item('wx_text'),$postObj->FromUserName,$postObj->ToUserName,time(),$content);
	  	echo $resultStr;
    }

    /**图片信息自动回复
    * @param  [type]   信息类型
    * @return [type]
    */
    private function _doimage($postObj){
		$content = '你可以查看你发的图片哦'.$postObj->PicUrl;
	  	$resultStr = sprintf($this->config->item('wx_text'),$postObj->FromUserName,$postObj->ToUserName,time(),$content);
	  	echo $resultStr;
    }

    /**收到位置信息处理
     * @param  [type] 
     * @return [type]
     */
    private function _dolocation($postObj){
    }

    /**语音信息处理
     * @param  [type]
     * @return [type]
     */
    private function _dovoice($postObj){
    }

    /**视频信息处理
     * @param  [type]
     * @return [type]
     */
    private function _dovideo($postObj){
    }

    /**小视频信息处理
     * @param  [type]
     * @return [type]
     */
    private function _doshortvideo($postObj){
    }

    /**链接信息处理
     * @param  [type]
     * @return [type]
     */
    private function _dolink($postObj){
    }

    /**事件分配函数
     * @param  [type] 事件类型
     * @return [type] 
     */
    private function _doevent($postObj){
	  	switch ($postObj->Event) {
	  		case 'subscribe':
	  			$this->_Subscribe($postObj);
	  			break;
	  		case 'unsubscribe':
	  			$this->_Unsubscribe($postObj);
	  			break;
	        case 'CLICK':
	        	$this->_menuClick($postObj);
	        	break;
	  		default:
	  			break;
	  	}
    } 

    /**关注事件处理
     * @param  [type] 事件类型
     * @return [type]
     */
    private function _Subscribe($postObj){
        //将其添加到数据库
        $this->load->model('UserM');
        $this->UserM->addUser($postObj->FromUserName);
		$content = '欢迎关注xiaotang测试号，测试号还不够完善。下列菜单是我的一些作品和推荐，如果大家有什么看法，欢迎留言。
    直接回复"留言:(这里是你想说的话即可)"，也可以回复"联系方式"获取我的连接方式;集成了翻译功能，可以回复\'翻译\'了解.当然，还有一个机器人可以搞怪聊天哦。
    ME,新生代的码农一只。';
	  	$resultStr = sprintf($this->config->item('wx_text'),$postObj->FromUserName,$postObj->ToUserName,time(),$content);
        echo $resultStr;
    }

    /**取消关注事件处理
     * @param  [type] 事件类型
     * @return [type]
     */
    private function _Unsubscribe($postObj){
        //在数据库中删除	
        $this->load->model('UserM');
        $this->UserM->delUser($postObj->FromUserName);
    }

    /**用于菜单被动回复图文消息
     * @param  [type] 事件类型
     * @return [type]
     */
    private function _menuClick($postObj){
        $type = $postObj->EventKey;
        if($type=='about_me'){
            $content = '欢迎关注xiaotang测试号，测试号还不够完善。下列菜单是我的一些作品和推荐，如果大家有什么看法，欢迎留言。
    直接回复"留言:(这里是你想说的话即可)"，也可以回复"联系方式"获取我的连接方式;集成了翻译功能，可以回复\'翻译\'了解.当然，还有一个机器人可以搞怪聊天哦。
    ME,新生代的码农一只。';
            $resultStr = sprintf($this->config->item('wx_text'),$postObj->FromUserName,$postObj->ToUserName,time(),$content);
        }else{
            $this->load->model('MenuInfoM');
            $result = $this->MenuInfoM->getCurInfo($type);
            $resultStr = sprintf($this->config->item('wx_news'),$postObj->FromUserName, $postObj->ToUserName, time(),$result['count'],$result['msg']);
        }
        echo $resultStr;
    }
}