<?php $this->load->view('common') ?>
   <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo site_url('c=admin&m=index') ?>">首页</a><span class="crumb-step">&gt;</span><span class="crumb-name">用户列表</span></div>
        </div>
        <div class="result-wrap">
                <div class="result-content">
                    <table class="result-tab" width="100%">
                        <tr>
                            <th>id</th>
                            <th>管理员</th>
                            <th>标题</th>
                            <th>作者</th>
                            <th>素材id</th>
                            <th>原文链接</th>
                            <th>简要说明</th>
                            <th>添加时间</th>
                        </tr>
                        <?php foreach($data->result() as $k=> $v): ?>
                        <tr>
                            <td><?php echo $v->id ?></td>
                            <td><?php echo $v->admin_name ?></td>
                            <td><?php echo $v->title ?></td>
                            <td><?php echo $v->author ?></td>
                            <td><?php echo $v->thumb_media_id ?></td>
                            <td><?php echo $v->content_source_url ?></td>
                            <td><?php echo $v->digest ?></td>
                            <td><?php echo $v->addtime ?></td>
                        </tr>
                        <?php endforeach;?>
                    </table>
                    <div class="list-page"><?php echo $pageString ?></div>
                </div>
        </div>
    </div>
    <!--/main-->

<?php $this->load->view('footer') ?>