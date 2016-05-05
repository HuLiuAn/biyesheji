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
            $this->error("你还没有登录，快去登录吧",U('Staff/Login'),1);
        }else{

            $this->success("",U('Staff/checkLogin'),1);

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