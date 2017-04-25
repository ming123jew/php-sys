<?php
namespace app\basedemo\controller;
use think\Controller;

/**
 * @desc   投票前台页面
 * @author ming123jew
 *
 */
class Index extends Controller
{
    private static $loader;
    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require VENDOR_PATH . 'composer/ClassLoader.php';
        }
    }
	public function _empty(\think\Request $request)
	{
		$controller = $request->controller();
		$action = $request->action();

		if (!class_exists('\basedemo\Base')){
		    //如果不是composer安装组件, 则用调用composer类进行自动加载命名空间的方式;
            if (null !== self::$loader) {
                return self::$loader;
            }
            spl_autoload_register(array('app\basedemo\controller\Index', 'loadClassLoader'), true, true);
            self::$loader = $loader = new \Composer\Autoload\ClassLoader();
            spl_autoload_unregister(array('app\basedemo\controller\Index', 'loadClassLoader'));
            $loader->setPsr4('basedemo\\', VENDOR_PATH.'/ming123jew/basedemo');
            $loader->register(true);

            $auth =  new \basedemo\Base();

        }else{
            $auth =  new \basedemo\Base();
        }


		$auth = $auth->autoload2($controller,$action);
	
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
