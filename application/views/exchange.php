<?php $this->load->view('common') ?>
   <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo site_url('c=admin&m=index') ?>">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">聊天信息列表</span></div>
        </div>
        <div class="result-wrap">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>id</th>
                            <th>名称</th>
                            <th>内容</th>
                            <th>发送时间</th>
                        </tr> 
                        <?php foreach($data->result() as $k=> $v): ?>
                        <tr>
                            <td><?php echo $v->id ?></td>
                            <td><?php echo $v->user ?></td>
                            <td><?php echo $v->content ?></td>
                            <td><?php echo date('Y-m-d H:i:s',$v->addtime) ?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <div class="list-page"><?php echo $pageString ?></div>
                </div>
        </div>
    </div>
    <!--/main-->

<?php $this->load->view('footer') ?>