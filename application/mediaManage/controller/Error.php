<?php
namespace app\mediaManage\controller;


use app\supervise\controller\BaseController;


class Error extends BaseController
{
	public function __construct(\think\Request $request){
		parent::__construct();
	}

	public function _empty(\think\Request $request)
	{
		$controller = $request->controller();
		$action = $request->action();
		
		
		//传递所有角色组  需要添加系统权限查询
		$auth =  new \mediamanage\Base();
		$auth = $auth->autoload($controller,$action);
		if($auth){
			if(isset($auth['code'])){

			    if(isset($auth['url']) && $auth['url']=='history.back(-1)'){
                    $back_url = $_SERVER['HTTP_REFERER'];
                    $auth['url'] = $back_url;
                }

				return json($auth);
			}elseif(isset($auth['file'])){
				return $auth['file'];
			}
			$this->view->engine->layout(false);
			return $this->fetch($auth[0],$auth[1]);
		}
		return abort(404,'页面不存在');
	}
	


}

