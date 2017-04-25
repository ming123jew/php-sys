<style>
.well{margin-top:20px;  line-height: 2px}
.wrap ul,.wrap ol{line-height:26px;}
</style>
<div class="wrap">
    <div id="home_toptip"></div>
    <h4 class="well">系统通知</h4>
    <div class="home_info">
        <ul id="thinkcmf_notices">
            <!-- <li><img src="/cmf/admin/themes/simplebootx/Public/assets/images/loading.gif"style="vertical-align: middle;" /><span style="display: inline-block; vertical-align: middle;">加载中...</span></li>-->
        </ul>
    </div>
    <h4 class="well">系统信息</h4>
    <div class="home_info">
        <div class="bs-example" data-example-id="simple-ol">
        <ol>
        <?php 
        //$mysql= mysqli_get_server_info();
       // $mysql=empty($mysql)?"未知":$mysql;
        //服务器信息
        $info = array(
        		'操作系统' => PHP_OS,
        		'运行环境' => $_SERVER["SERVER_SOFTWARE"],
        		'PHP运行方式' => php_sapi_name(),
        		'MYSQL版本' =>'mysql_v5.6.0',
        		'主程序版本' => 'Thinkphp5.0.7' . "&nbsp;&nbsp;&nbsp; [<a href='#' target='_blank'>访问官网</a>]",
        		'上传附件限制' => ini_get('upload_max_filesize'),
        		'执行时间限制' => ini_get('max_execution_time') . "秒",
        		'剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
        );
		foreach ($info as $key => $value){
        ?>
		<li><em><?php echo $key;?></em> <span><?php echo $value;?></span></li>
		<?php } ?>
        </ol>
          
        </div>

    </div>
    <h4 class="well">发起团队</h4>
    <div class="home_info" id="home_devteam">
        <ul>
            <li>
            	<em>项目总负责:</em> <a href="" target="_blank">ming123jew</a>
            	&nbsp;&nbsp;&nbsp;&nbsp;
            	<em>产品设计:</em> <a href="" target="_blank">ming123jew</a>
            	&nbsp;&nbsp;&nbsp;&nbsp;
            	<em>程序实现:</em> <a href="" target="_blank">ming123jew</a>
            </li>
            <li>
            	<em>前端:</em> <a href="" target="_blank">ming123jew</a>
            	&nbsp;&nbsp;&nbsp;&nbsp;
            	<em>设计:</em> <a href="" target="_blank">ming123jew</a>
            </li>
            <li>
            	<em>联系方式:</em> <a href="" target="_blank">ming123jew123@qq.com</a>
            	
            </li>
        </ul>

    </div>
    <h4 class="well">贡献者</h4>
    <div class="">
        <ul class="inline" style="margin-left: 25px;">
            <li>ming123jew</li>
 			<li>zouxiang</li>
        </ul>
    </div>

</div>