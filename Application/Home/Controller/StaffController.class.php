<?php
    namespace Home\Controller;
    use Think\Controller;
    class StaffController extends Controller{
        
        /**
         * 验证码图片生成函数
         * @access public
         * @param void
         * @return void
         *
         * author：shli
         * date:2016.4.8
         */
        function verifyCode(){
        
            $config = array(
                'fontSize' => 15,          // 验证码字体大小
                'length'   => 4,           // 验证码位数
                'useNoise' => True,        // 关闭验证码杂点
                'codeSet'  => '0123456789',// 设置验证码字符为纯数字
                'imageW'   => 120,         //验证码宽度
                'imageH'   => 35,          //验证码高度
                'useImgBg' => true,        //验证码背景图片
                
            );
            $verify =new \Think\Verify($config);
             
            $verify->entry();
        }
        
        
        
        /**
         * 验证码验证函数，供javascript文件中异步或同步调用
         * @access public
         * @param void
         * @return void
         *
         * author：shli
         * date:2016.4.8
         */
        function checkVerifyCode(){
        
            if(!IS_AJAX)
                E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        
            $verify = new \Think\Verify();
            $result = $verify->check(I('verifyCode','','trim'));
            if($result)
                $this->ajaxReturn(1);
            else
                $this->ajaxReturn(0);
        
        }

        
        
        /**
         * 检测用户是否登录
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.8
         */
        public function checkLogin(){

            //检查用户是否登录
            if(session('?user_id')){
                //返回信息
                 $st =session();
                 $st['status']=1;
                 $this->ajaxReturn (json_encode($st),'JSON');
            }
            else {
                //提示错误
              $st = array ('status'=>0);
              $this->ajaxReturn (json_encode($st),'JSON');
            }
        }  

        
        
        /**
         * 用户登录
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.8
         */
        public function login(){
            
            //if(!IS_AJAX)
             //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

            $map['user_number']   = I('usernumber');
            $map['user_password'] = I('password');
            if(!$map['user_number'] ||!$map['user_password'] ){
               $st = array ('status'=>0);
               $this->ajaxReturn (json_encode($st),'JSON');
             }
            $user = M('User');
            $result = $user->where($map)->find();
            
            if($result){

                session('user_id',             $result['user_id']);
               session('user_name',           $result['user_name']);
               session('user_department',     $result['user_department']);
                session('user_lastlogintime',  date('Y-m-d H:i',$result['user_lastlogintime']));
                $user->where( $map )->setField('user_lastlogintime',time());
                 $st = array ('status'=>1);
                 $this->ajaxReturn (json_encode($st),'JSON');
                }
             else{
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
             }
        }
        
        
        
        /**
         * 用户登出(主要是清除session数据）
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.8
         */
        public function logout(){
            
            session_unset();
            session_destroy();
            $this->success("您已退出登录",U('Home/Index/index'));    //退出后跳转至首页
        }
        
        
        
        /**
         * 显示用户详细信息
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.8
         */
        
        public function showUserDetail(){
          
            if(!session('?user_id'))
                $this->error('你还没有登录，赶快去登录吧',U('checkLogin'),1);
            
            $map['user_id'] =  session('user_id');
            $userInfo=M('User')->where('$map')->find();
            
            $this->assign('userInfo',$userInfo);
            $this->display('userDetail');
                
        }
        
        
        /**
         * 修改用户密码
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
         
        public function modifyPassword(){
            
            if(!IS_AJAX)
                E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            $map['user_id']      = session('user_id');
            $map['user_password']    = I('oldPassword','','md5');
            
            $user = M('User');
            $result = $user->where($map)->find();
            
            if(!$result)
               $this->ajaxReturn(0);
            else{
                $user->where($map)->setField('user_password',I('newPassword','','md5'));
                $this->ajaxReturn(1);
            }
        }
        
        
        /**
         * 用户忘记密码时用于设置新的用户密码
         * 调用短信运营商接口，发送短信验证码
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        
        public function getNewPassword(){
            if(!IS_AJAX)
                E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            
        }
        
        
        
        /**
         * 打开修改个人用户信息界面，
         * 只有手机号码一项可以修改
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
         
        public function showModifyUserInfo(){
        
            if(!IS_AJAX)
                E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        
            $map['user_id']      = session('user_id');
            $user = M('User');
            $userInfoTemp = $user->where($map)->find();
            $userInfo['user_phone'] = $userInfoTemp('user_phone');
            
            $this->assign('userInfo',$userInfo);
            $this->display('Staff/modifyUserInfo');
            
        }
        
        
        
        /**
         * 修改个人用户信息
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
         
        public function modifyUserInfo(){
        
            if(!IS_POST)
                E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            $rules = array(
               array('user_phone1','/^(13|15|18)(\d{9})|^6(\d{4,5})$/','请输入正确的手机号码',
                    0,'regex',1),
            );
            
            $user = M('User');
            
            if(!$user->validate($rules)>create())
                exit($user->getError());
            
            $map['user_id']    = session('user_id');
            $data['user_phone'] = I('user_phone');
            
            $user->where($map)->save($data);
            
            $this->redirect('Staff/showUserDetail');
        }
        
        
        /**
        * 展示商品列表
        * @access public
        * @param void
        * @return void
        *
        * author: shli
        * date: 2016.04.12
        */
        public function showProductList(){
            
            
        }
    }
?>