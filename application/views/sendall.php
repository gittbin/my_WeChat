<?php $this->load->view('common') ?>

 <style type="text/css">
    .off{
        display: none;
    }
    .on{
           
    }
    .insert-tab th{
        width: 20%;
    }
 </style>

 <!--/sidebar-->
    <div class="main-wrap">

        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font"></i><a href="<?php echo site_url('c=admin&m=index') ;?>" >首页</a>><span>群发消息</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <table class="insert-tab" width="100%">
                    <tbody>
                        <tr>
                            <th><i class="require-red">*</i>请选择群发方式</th>
                            <td> 
                            <input type="button" class="btn" value="发送文字">
                            <input type="button" class="btn" value="发送图片"> 
                            <input type="button" class="btn" id='send' value="发送" style="width: 80px;float: right;margin-right: 100px;margin-top: 8px;background-color: #efaf9e">
                            </td>
                        </tr>
                        <tr class='on tr'>
                            <form action="" method="post">
                            	<input type="hidden" name="type" value="text">
                                <th><i class="require-red">*</i>请输入内容：</th>
                                <td><textarea name="content" class="common-textarea" cols="30" style="width: 98%;" rows="10"></textarea></td>
                            </form>
                        </tr>

                        <tr class='off tr'>
                            <form action="" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="image" >
                                <th><i class="require-red">*</i>请选择图片，直接发送即可:</th>
                                <td><input type="file" name="w_image" /></td>
                            </form>
                        </tr>
                    </tbody></table>
            </div>
        </div>

    </div>

<?php $this->load->view('footer') ?>

 <script type="text/javascript" src="<?php echo _PUBLIC_ ?>js/jquery-1.11.3.min.js"></script>
<script type="text/javascript">

    $(function(){
        $('#send').click(function(){
            var form = $('.on form');
            var content = $('#content').val();
            $('input[name="nr"]').val(content);
            form.submit();
        })
        $('.btn').bind('click',function(){
            var num = $(this).index();          
            $('.tr').attr('class','off tr');
            $('.tr').eq(num).attr('class','on tr');
        })
    })
</script>