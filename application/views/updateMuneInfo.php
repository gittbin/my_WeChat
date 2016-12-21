<?php $this->load->view('common') ?>
    <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><a href="<?php echo site_url('c=admin&m=index') ;?>">首页</a>><span>更新菜单推送</span></div>
        </div>
        <div class="result-wrap">
            <button id = 'add_table' class="btn">添加一个</button><button style="margin-left: 40%; " id='submit' class="btn">提交</button>
            <br /><span style="color: red;font-weight: bold;">说明:最多不超过10个！相同推送按钮的必须在同一次提交，否则只取最后一条,不选择菜单会被舍弃。</span>
            <div class="result-content">
                <form action="" method="post" id="myform" name="myform" >
                    <div class='content'>
                    <table class="insert-tab" width="100%">
                        <tbody>
                        <tr><td><br /></td></tr>
                        <tr>
                            <th width="120"><i class="require-red">*</i>菜单推送按钮：</th>
                            <td>
                                <select name="type_id[]" >
                                    <option value="">请选择</option>
                                    <?php foreach($type as $k => $v): ?>
                                    <option value="<?php echo $v['id'] ?>"><?php echo $v['type_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                            <tr>
                                <th>标题：</th>
                                <td>
                                    <input id="title" name="title[]" size="80" type="text">
                                </td>
                            </tr>
                            <tr>
                                <th>简单描述：</th>
                                <td><input name="description[]" size="80"  type="text"></td>
                            </tr>
                            <tr>
                                <th>图片url：</th>
                                <td><input name="picurl[]" size="80"  type="text"></td>
                            </tr>
                            <tr>
                                <th>链接url：</th>
                                <td><input name="url[]" size="80"  type="text"></td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </form>
            </div>
        </div>

    </div>
    <!--/main-->

<?php $this->load->view('footer') ?>
<script type="text/javascript" src="<?php echo _PUBLIC_ ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#add_table').click(function(){
            var table = $('.insert-tab').first();
            new_tab = table.clone(true);
            new_tab.append('<tr><td></td><td><input type="button" class="btn" onclick="move_tab(this);" value="删除此菜单"></td></td></tr>');
            $('.content').append(new_tab);
        })
        $('#submit').click(function(){
            $('form').submit();
        })
    });
    function move_tab(mov){
        $(mov).parent().parent().parent().remove();
    }
</script>