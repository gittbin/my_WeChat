<?php 

/**
 * 主动消息模型
 */
class MessageM extends MY_Model{

    /**
     * 群发图文消息，一条龙
     * @return [type] 成功或者失败bool
     */
    public function sendPicText(){
        //简单判断
        if(count($_POST['title']) != count($_FILES)){
            $this->_error = '填写不完整！';
            return FALSE;
        }
        $msg = array();
        //先处理图片上传,将所有信息拼接
        //对总条数进行遍历上传 最多只处理8条
        $count = min(8,count($_FILES));
        for($i=0;$i<$count;$i++){
            //上传，成功则继续，下面都一样
            $media_id = $this->uploadImage('w_image'.$i);
            if($media_id == false)
                return false;
            $th_media_id = $this->uploadImage('w_image'.$i); //上传图片到服务器再到腾讯获取到id
            if($th_media_id == false)
                return false;
            $msg[$i]['thumb_media_id'] = $th_media_id;   
            $msg[$i]['author'] = urlencode($_POST['author'][$i]);
            $msg[$i]['title'] = urlencode($_POST['title'][$i]);
            $msg[$i]['content_source_url'] = $_POST['content_source_url'][$i];
            //需要先进行实体化标签
            $content = $_POST['content'][$i];
            $content = htmlspecialchars(str_replace('"', "'", $content));
            $msg[$i]['content'] = urlencode($content);
            $msg[$i]['digest'] = urlencode($_POST['digest'][$i]);
            //都显示封面
            $msg[$i]['show_cover_pic'] = 1;         
        }
        //需要发送的数据msg
        $message['articles'] = $msg;    
        $message = json_encode($message);
        $message = urldecode($message); //解码
        //再讲实体html转成普通html
        $message = htmlspecialchars_decode($message);
        //将推送信息加入到数据库
        $this->load->model('sendDayM');
        $this->sendDayM->addInfo($msg);
        //建立图文素材
        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token='.$this->_getToken();
        $re = $this->_request($url,TRUE,'post',$message);
        $re= json_decode($re);
        if($re->media_id){
            $media_tw = $re->media_id;
            //获取所有的openid
            $this->load->model('UserM');
            $openids = $this->UserM->getUserList();
            if($openids==false){
                $this->_error = '获取用户失败!';
                return false;
            }
            //进行发送
            $str['touser'] =  $openids;
            $str['mpnews'] =  array('media_id' => $media_tw);
            $str['msgtype'] =  'mpnews';
            $data = json_encode($str);
            $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->_getToken();
            $result = $this->_request($url,TRUE,'post',$data);
            $result = json_decode($result);
            if($result->errcode == 0)
                return TRUE;
            else{
                $this->_error = '错误代码：'.$this->errcode;
                return false;
            }
        }else{
            $this->_error = '错误代码:'.$re->errcode;
            return FALSE;
        }
    }

    /**
     * 群发文字或者图片 一条龙
     * @return [type] bool
     */
    public function sendAll(){
        //注意一下bool值得写法。不能用引号
        //微信不识别默认的json编码，先需要编码，之后再解码
        //获取发送的类型
        $type = $this->input->post('type');
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->_getToken();
        if($type == 'text'){
            $content = $this->input->post('content');
            //保存到数据库
            $this->load->model('SendDayM');
            $this->SendDayM->addText($content);
            
            $str['filter'] =  array('is_to_all' => true);
            $str['text'] =  array('content' => urlencode($content));
            $str['msgtype'] =  'text';
            $str = json_encode($str);
            $str = urldecode($str);
            $re = $this->_request($url,TRUE,'post',$str);
            $re = json_decode($re);
            if($re->errcode==0){

              return TRUE;
            }else{
                $this->_error = '错误代码:'.$re->errcode;
                return FALSE;
            }
        }

        if($type == 'image'){
            $media_id = $this->uploadImage('w_image');
            if(!$media_id)
                return FALSE;
            else{
                //发送图片
                $result = $this->sendImage($media_id);
                if($result)
                    return TRUE;
                return false;
            }
        }
        $this->_error = '未知错误';
        return false;
    }

    /**
     * 上传图片到我的服务器再到腾讯服务器最后获得media_id或者图片的url
     * 由第二个参数控制，默认0 获取id，为真的话获取图片的url
     * @param  [type]  $field_name 需要上传的表单图片名称
     * @param  integer $type       要获取的类型
     * @return [type]              $media_id||url
     */
    public function uploadImage($field_name,$url=0){
        $config['upload_path'] = _UPLOADS_;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size'] = '2048';
        $config['remove_spaces'] = TRUE;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        $re = $this->upload->do_upload($field_name);
        if(!$re){
            $this->_error = $this->upload->display_errors();
            return FALSE;
        }else{
            $data = $this->upload->data();
            //获取文件的完整的路径
            $file_name = _UPLOADS_.$data['file_name'];
            //添加临时素材
            if($url)
                $result = $this->addTempMediaUrl($file_name);
            else
                $result = $this->addTempMedia($file_name);
            if($result)
                return $result;
            else
                return FALSE;
        }

    }	

    /**
     * 群发图片
     * @param  [type] $media_id [素材id]
     * @return [type]           bool
     */
    private function sendImage($media_id){
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token='.$this->_getToken();
        $this->load->model('UserM');
        $openids = $this->UserM->getUserList();
        if($openids==false){
        $this->_error = '获取用户失败!';
                return false;
            }
        $arr = array(
            "touser" => $openids,
            "image"  => array("media_id" => $media_id ),
            "msgtype" => "image"
        );
        $str = json_encode($arr);
        $result = $this->_request($url,TRUE,'post',$str);
        $result = json_decode($result);
        if($result->errcode == 0)
            return TRUE;
        else{
            $this->_error = '错误代码'.$result->errcode;
            return FALSE;
        }
    }

    /**
     * [addTempMedia 增加临时素材id，有限制]
     * @param [type] $file [文件路径]
     * @param [type] $type [素材类型]
     * @return  [media_id]
     */
    public function addTempMedia($file,$type='image'){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/upload?access_token='.$this->_getToken().'&type='.$type;
        //5.5php版本不可用，需采用CURLFile类上传
        // $data['type'] = $type;
        // $data['media'] = '@'.$file;
        $data[] = new CURLFile($file);
        $result = $this->_request($url,true,'post',$data);
        $result = json_decode($result);
        if(@$result->media_id){
            return $result->media_id;
        }else{
        	$this->_error = $result->errmsg;
            return FALSE;  
        }
    }

    /**
     * 上传图片到微信服务器获得图片的url
     * @param [type] $file 图片地址
     * @return   素材图片url
     */
    private function addTempMediaUrl($file){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$this->_getToken();
        //5.5php版本不可用，需采用CURLFile类上传
        // $data['type'] = $type;
        // $data['media'] = '@'.$file;
        $data[] = new CURLFile($file);
        $result = $this->_request($url,true,'post',$data);
        $result = json_decode($result);
        if(@$result->url){
            return $result->url;
        }else{
            $this->_error = $result->errcode.' 或者不是绑定服务器!';
            return FALSE;  
        }
    }

    /**
     * [getTempMediaById 根据MEDIA_ID获取临时素材]
     * @param  [type] $MEDIA_ID [素材id]
     * @return [type]           [description]
     */
    public function getTempMediaById($media_id=''){
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token='.$this->_getToken().'&media_id='.$media_id;
        $result = $this->_request($url);
        return $result;
    }
}
