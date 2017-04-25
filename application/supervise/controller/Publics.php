<?php
namespace app\supervise\controller;

use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use thinkcms\auth\Auth;


class Publics extends Controller
{
    private $post;

    public function __construct(\think\Request $request)
    {
        parent::__construct($request);
        $this->post = $request->post();
    }

    /**
     * 登入
     */
    public function login()
    {
        if ($this->request->isPost()) {
            $post   = $this->post;

            $validate = [
                ['name|用户名','require|max:25'],
                ['login_password|密码','require']
            ];

            //验证
            $result = $this->validate($post,$validate);

            if (true !== $result) {
                return $this->error($result);
            }

            $data = [
                'user_name'      => $post['name'],
                'user_password'  => md5($post['login_password']),
            ];

            $list =  Db::name('admin')->where($data)->find();
            if($list){

                Auth::login($list['id'],$list['user_name']);

                //手动加入日志
                $auth = new Auth();
                $auth->createLog('管理员<spen style=\'color: #1dd2af;\'>[ {name} ]</spen>偷偷的进入后台了,','后台登录');
                return $this->redirect('index/index');
            }else{
                return $this->error('账户或密码错误');
            }
        }

        return $this->fetch();
    }
    /**
     * 退出视图
     */
    public function logout()
    {
        Auth::logout();
        $this->redirect('publics/login');
    }

    public function crontab(){
        Cache::set('a',date('Y-m-d H:i:s'));
    }

    /**
     * 清空缓存
     */
    public function clear(){
        Cache::clear();
        echo '缓存清除成功';
    }
}
