<?php $this->load->view('common') ?>

 <style type="text/css">
    .off{
        display: none;
    }
    .on{
           
    }
    .insert-tab th{
        width: 15%;
    }
 </style>

 <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo site_url('c=admin&m=index') ;?>" >首页</a>><span>每日图文推送</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
            <div >图文信息推送<span style="color: red">(标题和图片和内容必须填写！显示封面默认都显示,最多8条。在线编辑器里的链接a iframe或者图片插入无法实现微信功能(插入图片因为只能用微信的图片链接，可用正则表达式替换上传，未实现。)请主动上传.先在此处获取链接，再在在线编辑器的html页中进行插入将其放在想要放置的地方即可,注意是在html！！)</span></div>
                </table>
                </form>
                <form action="" id="uploadimage" method="post" enctype="multipart/form-data">
                    <table class="insert-tab" width="100%">
                        <tr>
                            <td width="50%" ><input type="button" class="btn" id='getMediaUrl' value="获取链接" style="float: right;"><input type="file" name="ajaximage" style="float: right;"> 
                            </td>
                            <td><span style="color: pink;">图片素材url获取结果：</span><span id="imageurl">&nbsp</span></td>
                    </tr>
                </table>
                </form>
                <table class="insert-tab" width="100%">
                    <tr>
                        <td><input type="button" class="btn" value="添加一个" onclick="add()" style="float:left;margin-left: 30%" /></td><td><input type="button" class="btn" onclick="submit()" value="发送" style="width: 80px;float: right;margin-right: 50%;margin-top: 8px;background-color: #efaf9e">
                        </td>
                    </tr>
                </table>
                <form action="" id="form" method="post" enctype="multipart/form-data">
                </form>
            </div>
        </div>
        <table class="insert-tab off" id="off_tab" width="100%">
                <tbody>
                        <tr>
                            <th><i class="require-red">*</i>标题：</th>
                            <td>
                                <input name="title[]" size="70%" type="text">
                            </td>
                        </tr>
                        <tr>
                            <th>作者：</th>
                            <td>
                                <input  name="author[]" size="20%" type="text">
                            </td>
                        </tr>
                        <tr>
                            <th>图文消息的描述：</th>
                            <td><input name="digest[]" size="90%"  type="text"></td>
                        </tr>
                        <tr>
                            <th><i class="require-red">*</i>请选择图片:</th>
                            <td><input type="file" name="w_image0"/></td>
                        </tr>
                        <tr>                             
                            <th><i class="require-red">*</i>请输入内容:</th>
                            <td>
                            <textarea  id="" name="content[]" cols="30" rows="10"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>“阅读原文”后的页面url:</th>
                            <td><input name="content_source_url[]" size="60%"  type="text"></td>
                        </tr>
                        <tr>
                            <th></th>
                            <td>
                                <input class="btn" value="删除此项" onclick="remove(this)" type="button">
                            </td>
                        </tr>
                        <tr>
                            <th>&nbsp</th>
                            <td>
                               &nbsp 
                            </td>
                        </tr>
                </tbody>
            </table>

    </div>

<?php $this->load->view('footer') ?>

 <script type="text/javascript" src="<?php echo _PUBLIC_ ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">
    var i = 0;
    function add(){
        var table = $('#off_tab');
        var new_tab = table.clone();
        new_tab.attr('id','');
        new_tab.removeClass('off');
        new_tab.find('input[name="title[]"]').addClass('tit');
        new_tab.find('input[type="file"]').addClass('image');
        new_tab.find('input[name="content[]"]').addClass('common-textarea');
        new_tab.find('.image').attr('name','w_image'+i);
        var new_id = 'content'+i;
        new_tab.find('textarea').attr('id',new_id);
        i = i+1;
        $('#form').append(new_tab);
        edit(new_id);
    }
    function remove(btn){
        $(btn).parent().parent().parent().remove();
    }
    function submit(){
        var bool = true; 
        $('.tit').each(function(k,v){
            if($(v).val() == ''){
                alert('请把第'+eval(k+1)+'个标题填写完整!');
                bool = false;
            }
        });
        $('.common-textarea').each(function(k,v){
            if($(v).val() == ''){
                alert('请把第'+eval(k+1)+'个内容填写完整!');
                bool = false;
            }
        })
        $('.image').each(function(k,v){
            if($(v).val() == ''){
                alert('第'+eval(k+1)+'张未选择图片!');
                bool = false;
            }
        })
        if(bool == true){
            $('#form').submit();
        }
    }
</script>
<!-- 导入在线编辑器 -->
<link href="<?php echo _PUBLIC_?>umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
<script type="text/javascript" charset="utf-8" src="<?php echo _PUBLIC_?>umeditor/umeditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo _PUBLIC_?>umeditor/umeditor.min.js"></script>
<script type="text/javascript" src="<?php echo _PUBLIC_?>umeditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
function edit(id){
    UM.getEditor(id,{
    initialFrameWidth:'90%', 
    initialFrameHeight:350  
});
}
add();
edit('content0');
//添加获取素材链接
$('#getMediaUrl').click(function(){
    if(!window.FormData) {　
        alert('your brower is too old');
        return false;
    }
    var formdata = new FormData($( "#uploadimage" )[0]);

    $.ajax({
        url:'<?php echo site_url("c=Message&m=imgMediaUrl") ?>',
        type:'post',
        data:formdata,
        processData: false,
        contentType: false,
        success:function(data){
            $('#imageurl').html(data);
        }
  });
})
</script>