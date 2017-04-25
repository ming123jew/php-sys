<?php
namespace app\supervise\controller;



use think\Controller;
use thinkcms\auth\Auth;


class BaseController extends Controller
{

    public $uid;

    public function __construct()
    {
        parent::__construct();
        $auth                   = new Auth();
        $auth->noNeedCheckRules = ['supervise/index/index','supervise/index/home'];
        $auth->log              = true;                 // v1.1版本  日志开关默认true
        $user                   = $auth::is_login();

        if($user){//用户登录状态
            $this->uid = $user['uid'];
            if(!$auth->auth()){
                return $this->error("你没有权限访问！");
            }
        }else{
            return $this->error("您还没有登录！",url("publics/login"));
        }
    }




}
