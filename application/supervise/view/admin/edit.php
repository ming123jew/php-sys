
<div class="wrap">
    <ul class="nav nav-tabs">
        <li><a href="{:url('admin/index')}">用户管理</a></li>
        <li><a href="{:url('admin/add')}">增加用户</a></li>
        <li class="active"><a href="{:url('admin/edit')}">增加修改</a></li>
    </ul>
    <div class="site-signup">

        <div class="row">
            <form class="form-horizontal" action="{:url('admin/edit',['id'=>$info['id']])}" method="post" >
                {include file="admin/_form" /}
            </form>
        </div>
    </div>
</div>

