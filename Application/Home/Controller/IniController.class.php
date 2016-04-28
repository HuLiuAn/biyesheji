<?php
namespace Application\Home\Controller;
use Think\Controller;
class IniController extends Controller{

    /*
     * 访问系统登录页
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.8
     */
     public function initialize(){
       
        //检查用户是否登录
        if(session('?user_id')){
            //跳转到首页
            $this->display('Index/index');
        }
        else {
            //跳转到登录页面
            $this->error('你还没有登录，赶快去登录吧',$this->display('Staff/login'),1);
        }
        /*配置URL为普通模式*/
        //C('URL_MODEL',0);    
    }
    
}
?>