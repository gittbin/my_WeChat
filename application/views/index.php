<?php $this->load->view('common') ;?>
    <!--/sidebar-->
    <div class="main-wrap">
        <div class="crumb-wrap">
            <div class="crumb-list"><i class="icon-font">&#xe06b;</i><span>欢迎使用微信管理后台。</span></div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>快捷操作</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                    <a href="<?php echo site_url('c=Account&m=QRcode') ?>"><i class="icon-font">&#xe001;</i>获取二维码(1天)</a>
                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
            <?php $info = $_SERVER; ?>
                <h1>系统基本信息</h1>
            </div>
            <div class="result-content">
                <ul class="sys-info-list">

                    <li>
                        <label class="res-lab">服务器操作系统:</label><span ><?PHP echo php_uname(); ?></span>
                    </li>
                    <li>
                        <label class="res-lab">运行环境:</label><span ><?php echo $info['SERVER_SOFTWARE']; ?></span>
                    </li>
                    <li>
                        <label class="res-lab">PHP版本:</label><span ><?php echo PHP_VERSION ;?></span>
                    </li>
                    <li>
                        <label class="res-lab">服务器ip：</label><span ><?php echo $info['SERVER_ADDR']; ?></span>
                    </li>
                    <li>
                        <label class="res-lab">北京时间:</label><span ><?php echo date('Y-m-d H:i:s') ?></span>
                    </li>
                    <li>
                        <label class="res-lab">浏览器信息:</label><span ><?php echo $info['HTTP_USER_AGENT']; ?></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-title">
                <h1>其他操作(菜单操作未完善)</h1>
            </div>
            <div class="result-content">
                <div class="short-wrap">
                    <a href="javascript:void(0)" onclick="menu('get')"><i class="icon-font">&#xe001;</i>获取菜单列表信息</a>
                    <a href="javascript:void(0)" onclick="menu('del')"><i class="icon-font">&#xe001;</i>删除菜单列表</a>
                    <a href="javascript:void(0)" onclick="menu('create')"><i class="icon-font">&#xe001;</i>创建菜单列表</a>
                </div>
            </div>
        </div>
        <div class="result-wrap">
            <div class="result-content">
                <span id='showmenu'></span>
            </div>
        </div>
    </div>
    <!--/main-->
<?php $this->load->view('footer') ;?>

 <script type="text/javascript" src="<?php echo _PUBLIC_ ?>js/jquery-1.11.3.min.js"></script>
 <script type="text/javascript">
     function menu(type){
        $.ajax({
            type:'get',
            url:'<?php echo site_url('c=Menu&m=') ?>'+type+'Menu',
            success:function(msg){
                $('#showmenu').html(msg);
            }
        })
     }
 </script>