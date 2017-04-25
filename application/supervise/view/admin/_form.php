
<link rel="stylesheet" href="__PublicDefault__/multiselect/css/multi-select.css">
<script src="__PublicDefault__/multiselect/js/jquery.multi-select.js"></script>
<script src="__PublicDefault__/multiselect/js/joinable.js"></script>
    <div class="form-group ">
        <label class="col-lg-2 control-label" for="signupform-username">用户名</label>
        <div class="col-lg-3">
            {if condition="!isset($info['user_name'])"}
                <input type="text" class="form-control" value="" name="user_name" >
            {else /}
                {$info.user_name}
            {/if}

        </div>

    </div>
    <div class="form-group ">
        <label class="col-lg-2 control-label" >邮箱</label>
        <div class="col-lg-3">
            <input type="text" value="{$info.user_email ?? ''}" class="form-control" name="user_email">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">密码</label>
        <div class="col-lg-3">
            <input type="password" class="form-control" name="user_password">
        </div>

    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">角色</label>
        <div class="col-lg-3">
            <script type="text/javascript">
                jQuery(document).ready(function($)
                {
                    $("#multi-select").multiSelect({
                        afterInit: function()
                        {
                            // Add alternative scrollbar to list
                            this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar();
                        },
                        afterSelect: function()
                        {
                            // Update scrollbar size
                            this.$selectableContainer.add(this.$selectionContainer).find('.ms-list').perfectScrollbar('update');
                        }
                    });
                });
            </script>
            <select class="form-control" multiple="multiple" id="multi-select" name="role[]">
                {$info.role ?? ''}
            </select>
        </div>

    </div>

    <div class="form-group ">

        <div class="col-md-3 col-md-offset-2">
            <p class="help-block help-block-error">

            </p>
        </div>
    </div>


    <div class="form-actions">
        <a class="col-lg-2"> </a>
        <!--<button type="submit" class="btn btn-primary active" >保存</button>-->
        <button type="button" class="btn btn-primary ajax-post " autocomplete="off">
            保存
        </button>
        <a class="btn btn-default active" href="{:Url('admin/index')}">返回</a>
    </div>

