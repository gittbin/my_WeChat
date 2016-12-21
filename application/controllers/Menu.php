<?php

/**
 * 菜单控制器
 */
class Menu extends MY_Controller{

    /**
     * 用来更新中间的菜单推荐
     * @return [type] [description]
     */
    public function updateMuneInfo(){
        $this->load->model('MenuInfoM');
        if(empty($_POST)){
            $type = $this->MenuInfoM->getMenuType();
            $this->load->view('updateMuneInfo',array('type' => $type));
        }else{
            $this->MenuInfoM->addMenuInfo();
            $this->jump(site_url('c=admin&m=index'),'更新完成，请用手机查看效果,如果未成功请重试');
        }
    }

	/**删除自定义菜单
     * @return [type] 输出删除结果
     */
    public function delMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token='.$this->_getToken();
        $re = $this->_request($url);
        $re = json_decode($re);
        if($re->errcode == 0)
            echo '删除成功!';
        else
            echo '失败！错误代码:'.$re->errcode;
    }

    /**查询自定义菜单
     * @return [type] json菜单结果
     */
    public function getMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token='.$this->_getToken();
        $re = $this->_request($url);
        $re = json_decode($re,TRUE);
        if(!$re['menu'])
            return false;
        $menu = '';
        foreach($re['menu']['button'] as $v){
            $menu .= $v['name'].'-->';
            foreach($v['sub_button'] as $v1){
                $menu .= $v1['name'].'&nbsp ';
            }
            $menu .='<br />';
        }
        echo $menu;
    }

    /**创建菜单
     * @return [type] 输出json结果
     */
    public function createMenu(){
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$this->_getToken();
        $menu = array(
                'button' => array(
                    array(
                        'type' => 'click',
                        'name'  => urlencode('关于ME'),
                        'key'   => 'about_me'
                        ),
                    array(
                        'name' => urlencode('MyRecommendation'),
                        'sub_button' => array(
                            array(
                                'type' => 'click',
                                'name'  => urlencode('我的推荐'),
                                'key'   => 'from_me'
                            ),
                            array(
                                'type' => 'click',
                                'name'  => urlencode('爆笑关注'),
                                'key'   => 'focus'
                            ),
                            array(
                                'type' => 'click',
                                'name'  => urlencode('篮球热点'),
                                'key'   => 'basketball'
                            ),
                            ),
                        ),
                    array(
                        'name'  => urlencode('作品展示'),
                        'sub_button' => array(
                            array(
                                'type' => 'view',
                                'name'  => urlencode('简单商城'),
                                'url'   => 'http://120.27.7.233/'
                            ),
                            array(
                                'type' => 'view',
                                'name'  => urlencode('微信管理'),
                                'url'   => 'http://139.199.171.254/wxtang/'
                            )
                        )
                        )
                    )
            );
        $menu = json_encode($menu);
        $menu = urldecode($menu);
        $re = $this->_request($url,TRUE,'POST',$menu);
        $re = json_decode($re);
        if($re->errcode == 0){
            echo '创建成功!<hr />';
            $this->getMenu();
        }   
        else
            echo '失败！错误代码:'.$re->errcode;
    }

}

                