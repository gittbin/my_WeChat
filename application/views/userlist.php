<?php $this->load->view('common') ?>
   <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo site_url('c=admin&m=index') ?>">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">用户列表</span></div>
        </div>
        <div class="search-wrap">
            <div class="search-content">
                <form action="" method="post">
                    <table class="search-tab">
                        <tr>
                            <th width="70">关键字:</th>
                            <td><input class="common-text" placeholder="关键字" name="keywords" value="<?php echo $this->input->post('keywords') ?>" type="text"></td>
                            <td><input class="btn" value="查询" type="submit"></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="result-wrap">
                <div class="result-title">
                    <div class="result-list">
                        <a onclick='return confirm("你确定要刷新吗？")' href="<?php echo site_url('c=User&m=uploadUser') ?>" >　刷新新用户(请慎用!)</a>
                    </div>
                </div>
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>id</th>
                            <th>openid</th>
                            <th>用户头像</th>
                            <th>昵称</th>
                            <th>性别</th>
                            <th>城市</th>
                            <th>省份</th>
                            <th>国家</th>
                            <th>语言</th>
                            <th>关注时间</th>
                        </tr>
                        <?php foreach($data->result() as $k=> $v): ?>
                        <tr>
                            <td><?php echo $v->id ?></td>
                            <td><?php echo $v->openid ?></td>
                            <td><img width="50px" src="<?php echo $v->headimgurl ?>"></td>
                            <td><?php echo $v->nickname ?></td>
                            <?php 
                                if($v->sex==0)
                                    $sex = '未知';
                                elseif($v->sex==1)
                                    $sex = '男';
                                else
                                    $sex = '女';
                            ?>
                            <td><?php echo $sex ?></td>
                            <td><?php echo $v->city ?></td>
                            <td><?php echo $v->province ?></td>
                            <td><?php echo $v->country ?></td>
                            <td><?php echo $v->language ?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v->subscribe_time) ?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <div class="list-page"><?php echo $pageString ?></div>
                </div>
        </div>
    </div>
    <!--/main-->

<?php $this->load->view('footer') ?>