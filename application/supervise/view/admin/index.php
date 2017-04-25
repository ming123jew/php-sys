
<div class="wrap js-check-wrap">
    <ul class="nav nav-tabs">
        <li  class="active"><a href="{:url('admin/index')}">用户管理</a></li>
        <li><a href="{:url('admin/add')}">增加用户</a></li>
    </ul>



    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th width="50">ID</th>
            <th>用户名</th>
            <th>最后登录IP</th>
            <th>最后登录时间</th>
            <th>邮箱</th>
            <th>状态</th>
            <th width="170">操作</th>
        </tr>

        </thead>
        <tbody>

        <?php foreach($list as $v) {
            ?>
            <tr>
                <td>{$v.id}</td>
                <td>{$v.user_name}</td>
                <td>{$v.last_login_ip}</td>
                <td>{$v.last_login_time}</td>
                <td>{$v.user_email}</td>
                <td><?php echo $v['user_status'] == 1 ? '启用' :'已拉黑';?></td>
                <td>
                    {if condition="$v['id']==1"}
                    <font color="#cccccc">独立权限</font> | <font color="#cccccc">编辑</font> | <font color="#cccccc">删除</font> |<font color="#cccccc">拉黑</font>
                    {else /}
                        <a href="<?php echo Url('auth/adminAuthorize',['id' => $v['id'],'name'=>$v['user_name']])?>">独立权限</a> |
                        <a href="<?php echo Url('admin/edit',['id' => $v['id']])?>">编辑</a> |
                        <a class="a-post" post-msg="你确定要删除吗" post-url="<?php echo Url('admin/delete',['id' => $v['id']])?>">删除</a> |
                        {if condition="$v['user_status'] == 1"}
                            <a  class="a-post" post-msg="你确定要拉黑吗？" post-url="<?php echo Url('admin/status',['id' => $v['id'],'param'=>0])?>" >拉黑</a>
                        {else /}
                            <a class="a-post" post-msg="你确定要启用吗？" post-url="<?php echo Url('admin/status',['id' => $v['id'],'param'=>1])?>" >启用</a>
                        {/if}
                    {/if}
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <div class="text-center">
        {$page}
    </div>
</div>


