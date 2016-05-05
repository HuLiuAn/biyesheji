<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    /**
     *网站首页
     *@access public
     *param void
     *return void
     *
     *author:shli
     *date:2016.4.8
     */
    public function index(){

        //$this->display(T('static://login'));   //先进入首页

        //$login['status'] = 1;//登陆状态，0为未登录

        if(!session('?user_id')){//已经登陆
            $this->display('./static/login.html');
        }else{

            $this->display('./static/index.html');

        }

        //$this->ajaxReturn($login);


    }
    
    
    /**
     *检查登录状态
     *@access public
     *param void
     *return void
     *
     *author:shli
     *date:2016.4.8
     */

    
}