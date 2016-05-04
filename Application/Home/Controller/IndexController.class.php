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
        echo 'hello';
        //$this->display(T('static://login'));   //先进入首页
        
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
    public function check(){
        
     $login['status'] = 0;//登陆状态，0为未登录
     
     if(session('?user_id')){//已经登陆
         $id=session('user_id');
         $login['name']=M('User')->where("user_id='$id'")->getField('user_name,user_department' );
         $login['status'] = 1;
     }
     
     $this->ajaxReturn($login);
     
     }
    
}