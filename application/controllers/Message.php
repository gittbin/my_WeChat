<?php

/**
 * 消息控制器
 */
class Message extends MY_Controller{
	
    /**
     * 获取每日推荐历史列表
     * @return [type] [description]
     */
    public function sendDay(){
        $this->load->model('SendDayM');
        $data = $this->SendDayM->getList();
        $this->load->view('sendday',$data);
    }

    /**
     * 获取留言
     * @return [type] [description]
     */
    public function liuYan(){
        $this->load->model('LiuYanM');
        $data = $this->LiuYanM->getList();
        $this->load->view('liuyan',$data);
    }

    /**
     * 获取聊天信息
     * @return [type] [description]
     */
    public function exchange(){
        $this->load->model('ExchangeM');
        $data = $this->ExchangeM->getList();
        $this->load->view('exchange',$data);
    }

    /**
     *群发文本或者图片 注意：代码是用即时获取openid群发，下同
     * @return [type] [description]
     */
    public function sendALL(){
        if(empty($_POST)){
            $this->load->view('sendall');
        }else{
            $this->load->model('MessageM');
            $re = $this->MessageM->sendAll();
            if($re){
                $this->jump(site_url('c=admin&m=index'),'发送成功!,请在手机端查看',3);
            }else{
                $this->jump(site_url('c=Message&m=sendALL'),$this->MessageM->getError());
            }
        }
    }

    /**
     * 群发图文消息，最多8条 
     * @return [type] [description]
     */
    public function sendPicText(){
        if(empty($_POST)){
            $this->load->view('pictext');
        }else{
            $this->load->model('MessageM');
            $re = $this->MessageM->sendPicText();
            if($re){
                $this->jump(site_url('c=admin&m=index'),'发送成功!,请在手机端查看');
            }else{
                $this->jump(site_url('c=Message&m=sendPicText'),$this->MessageM->getError());
            }
        }
    }

    /**
     * ajax上传图片然后获取服务器的链接,用于微信图文内容发送
     * @return [type] [description]
     */
    public function imgMediaUrl(){
        //判断，后面的图片上传类不然会报错
        if($_FILES['ajaximage']['size'] == 0){
            echo '获取失败!错误原因:未选择图片!';
            die;
        }
        $this->load->model('MessageM');
        $re = $this->MessageM->uploadImage('ajaximage',1);
        if($re == false)
            echo '获取失败!错误原因:'.$this->getError();
        else{
            //拼接出可用的插入图片刷的html
            $str = '<p><img src="'.$re.'" /></p>';
            //实体化
            $str = htmlspecialchars($str);
            echo $str;
        }
    }

}