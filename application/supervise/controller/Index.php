<?php
namespace app\supervise\controller;


use app\supervise\model\AdminModel;
use thinkcms\auth\Auth;
use thinkcms\auth\library\Tree;
use thinkcms\auth\model\Menu;

class Index extends BaseController
{
    public $auth;

    private $config;


    public function __construct(\think\Request $request)
    {
        $this->menu     = Menu::all();


        $this->config  = [
            'filterID' => [],
        ];
        parent::__construct($request);
    }

    public function index()
    {
        $this->view->engine->layout('layouts/index','[__REPLACE__]');
        $this->assign([
            'menu'      => self::menu(),
        ]);

        return $this->fetch();
    }

    public function home()
    {

        return $this->fetch();
    }

    private function menu(){
        $menu       = Auth::menuCheck();
        $menuName   = '';
        $tree       = new Tree();
        $num        = 1;
        foreach ($menu as $k => $v) {
            if($v['parent_id']==0){
                $class       = $num==1?'class="active"':'';
                $menuName   .= ' <li '.$class.' aria-controls="nav'.$v['id'].'">
                                <a href="#"  role="tab" data-toggle="tab"  aria-expanded="true">
                                    '.$v['name'].'
                                </a>
                            </li>';
                $menu[$k]['display']    = $num==1?'black':'none';
                $num++;
            }

            $url    = $v['url_param']?'?'.$v['url_param']:'';
            $url    = url("{$v['app']}/{$v['model']}/{$v['action']}").$url;
            $url    = 'href="javascript:openapp(\''.$url.'\',\''.$v['id'].$v['model'].'\',\''.$v['name'].'\',true);"';
            $menu[$k]['icon']    = !empty($v['icon'])?$v['icon']:'fa-list';
            $menu[$k]['level']    = $tree->get_level($v['id'], $menu);
            $menu[$k]['url']      = $url;
        }

        $tree->init($menu);
        $tree->text =[
            'other' => "<li>
                            <a \$url> &nbsp;
                                <i class='fa fa-angle-double-right'></i>
                                <span class='menu-text'> \$name </span>
                            </a>
                        </li>",
            '0' => [
                '0' =>"<ul class='nav nav-list' style='display: \$display' id='nav\$id'>",
                '1' =>"</ul>",
            ],
            '1' => [
                '0' => "<li>
                        <a  \$url class='dropdown-toggle'>
                            <i class='fa \$icon '></i>
                            <span class='menu-text normal'> \$name </span>
                            <b class='arrow fa fa-angle-right normal'></b>
                        </a>
                        <ul  class='submenu'>",
                '1' => "</ul></li>",
            ],
            '3' => [
                '0' => "<li>
                            <a \$url class='dropdown-toggle'> <i class='fa fa-caret-right'>
                                </i> <span class='menu-text'> \$name </span>
                                <b class='arrow fa fa-angle-right'></b>
                            </a>
                            <ul  class='submenu'>",
                '1' => "</ul></li>",
            ]

        ];
        return ['menuName'=>$menuName,'menuHtml'=>$tree->get_authTree(0)];
    }


}
