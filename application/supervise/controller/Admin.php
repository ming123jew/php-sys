<?php
namespace app\supervise\controller;


use app\supervise\model\AdminModel;
use thinkcms\auth\model\AuthRole;
use thinkcms\auth\model\AuthRoleUser;


class Admin extends BaseController
{

    protected $param,$id,$post,$adminModel;
    protected $url  = 'admin/index';
    protected static $authRoleTable     = 'auth_role';
    protected static $authRoleUserTable = 'auth_role_user';


    public function __construct(\think\Request $request)
    {
		
        $this->param        = $request->param();
        $this->post         = $request->post();
        $this->adminModel   = new AdminModel();
        $this->id           = isset($this->param['id'])?intval($this->param['id']):'';
        parent::__construct();

    }



    /**
     * 列表
     */
    public function index()
    {
        $list = AdminModel::paginate(20);
        $this->assign([
            'list'  => $list,
            'page'  => $list->render()
        ]);
        return $this->fetch();
    }

    /**
     * 增加
     */
    public function add()
    {

        if($this->request->isPost()){


            $post           = $this->post;

            //验证
            $result = $this->validate($post,[
                ['user_name|用户名','require|unique:admin,user_name,'.$post['user_name'].',id'],
                ['user_email|邮箱','require|email'],
                ['user_password|密码','require'],
                ['role|角色','require'],
            ]);

            if (true !== $result) {
                return $this->error($result);
            }
            $role           = $post['role'];
            $post['user_password']  = md5(input($post['user_password']));
            $post['create_time']    = date("Y-m-d H:i:s");
            $post['role']           = implode(',',$role);
            $insert = $this->adminModel->create($post);//增加

            if($insert){

                //加入角色
                $authRoleUser = new AuthRoleUser();
                $authRoleUser->authRoleUserAdd($role,$insert['id']);

                return $this->success('增加成功',url($this->url));
            }else{
                return $this->error('增加失败');
            }

        }


        $info['role'] = self::role();

        $this->assign('info', $info);
        return $this->fetch();
    }

    /**
     * 修改
     */
    public function edit()
    {
        $id = $this->id;
        $info = $this->adminModel->get($id);
        if($this->request->isPost()){
            $post           = $this->post;

            //验证
            $result = $this->validate($post,[
                ['user_email|邮箱','require|email'],
                ['role|角色','require'],
            ]);
            if (true !== $result) {
                return $this->error($result);
            }

            $role           = $post['role'];

            $data = array(
                'user_email'    => $post['user_email'],
                'role'          => implode(',',$role)
            );

            $password = $post['user_password'];
            if(!empty($password)){
                $data['user_password'] = md5($password);
            }

            if($info->save($data)){//修改

                //加入角色
                $authRoleUser = new AuthRoleUser();
                $authRoleUser->authRoleUserAdd($role,$id);

                return $this->success('修改成功',url($this->url));

            }else{
                return $this->error('修改失败');
            }

        }



        $info['role'] = self::role($info['role']);

        $this->assign('info',$info);

        return $this->fetch();
    }

    /**
     * 删除
     */
    public function delete($id)
    {
        if(!$this->request->isAjax()){
            return abort(404, lang('404 denied access'));
        }else if($id==1){
            return $this->error('超级管理员不能删除');
        }

        if($this->adminModel->where(['id'=>$id])->delete()){

            //删除角色权限
            $authRoleUser = new AuthRoleUser();
            $authRoleUser->authRoleUserDelete($id);

            return $this->success('删除成功',url($this->url));
        }else{
            return $this->error('删除失败');
        }

    }

    /**
     * 管理员状态修改
     */
    public function status(){

        $param  = $this->param['param'];
        $id     = $this->param['id'];

        if(!$this->request->isAjax()){
            return abort(404, lang('404 denied access'));
        }else if(empty($id)){
            return $this->error(lang('Data cannot be empty'));
        }

        $ratify = $this->adminModel->allowField(['user_status'])->save(['user_status'=>$param],['id'=>['in',$id]]);

        if($ratify){
            return $this->success(lang('Success'),url($this->url));
        }else{
            return $this->error(lang('Failed'));
        }
    }

    private static function role($roleid = ''){
        $roleid = explode(',',$roleid);

        $role = AuthRole::column('name','id');
        $html = '';
        foreach($role as $k=>$v){
            $selected = in_array($k, $roleid)?'selected':'';

            $html   .= ' <option '.$selected.' value="'.$k.'">'.$v.'</option>';
        }

        return $html;
    }

}

?>