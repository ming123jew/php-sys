<?php
namespace app\magazine\controller;


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
		
		
		$auth =  new \magazine\Base();
		$auth = $auth->autoload($controller,$action);
	
		if($auth){
			if(isset($auth['code'])){
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

