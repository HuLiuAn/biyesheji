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
       /* function checkVerifyCode(){
        
           // if(!IS_AJAX)
               // E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        
            $verify = new \Think\Verify();
            $result = $verify->check(I('verifyCode','','trim'));
            if($result)
                $this->ajaxReturn(1);
            else
                $this->ajaxReturn(0);
        
        }*/

        
        
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

           // $map1['user_number']   = I('usernumber');
            //$map2['user_password'] = I('password');
            
            $map['user_number']   = I('usernumber');
            $map['user_password'] = I('password');
            
            $user = M('User');
            
            //$result1 = $user->where($map1)->find();
            //$result2 = $user->where($map2)->find();
            
            $result = $user->where($map)->find();
            if (($result['user_number'] and $result['user_password']) == 0){
                
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
            
            /*if ($result1['user_number'] != $map1['user_number']){
                
                //工号错误
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
                
            }else if ($result2['user_password']!= $map2['user_password']){
                
                //密码错误
                $st = array ('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
            }*/
            
            
           // if($result['user_password'] != $map['user_password'] ){
             //   //密码错误
               // $st = array ('status'=>1);
                //echo $map['user_password'];
                //$this->ajaxReturn (json_encode($st),'JSON');
           // }
            
            /* $verify = I('verify','');
             if(!check_verify($verify)){
                 
                 //验证码错误
                 $st = array ('status'=>2);
                 $this->ajaxReturn (json_encode($st),'JSON');
                 }
                  */
             
            //$user = M('User');
            //$result = $user->where($map)->find();
            
            //$result = $user->where($map1 AND $map2)->find();
            if($result){
                    

                session('user_id',             $result['user_id']);
                session('user_name',           $result['user_name']);
                session('user_department',     $result['user_department']);
                session('user_lastlogintime',  date('Y-m-d H:i',$result['user_lastlogintime']));
                $user->where( $map)->setField('user_lastlogintime',time());
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
            //$this->success("您已退出登录",T('static://login'));    //退出后跳转至登录页
            $this->success(T('static://login'));
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
            //$userInfo=M('User')->where($map)->find();
            //TODO password要去掉，再返回给用户
             $userInfo = M('User')->field('user_id,user_password',true)->select();
             $this->ajaxReturn (json_encode($userInfo),'JSON');
            //$this->assign('userInfo',$userInfo);
            //$this->display('userDetail');
                
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
            
           // if(!IS_AJAX)
                //E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            $map['user_id'] = session('user_id');
            $map['user_password'] = I('oldPassword','','md5');
            //$new['user_password'] = I('newpassword','','md5');
            
            $user = M('User');
            $result = $user->where($map)->find();
            
            //如果原密码和数据库信息不匹配，则返回错误信息
            if ($result['user_password'] != $map['user_password']){
                
                $st = array('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
            //如果原密码和数据库信息不匹配，则返回错误信息
           // if(!$result['user_password']){

                //$st = array('status'=>0);
                //$this->ajaxReturn (json_encode($st),'JSON');
            //}
            
            
            else{
                
                $user->where($map)->setField('user_password',I('newPassword','','md5'));               
                $st = array('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
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
           // if(!IS_AJAX)
               // E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            
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
        
         //   if(!IS_AJAX)
              //  E("页面不存在");     //防止URL直接访问，开发阶段可关闭

            $map['user_id'] = session('user_id');
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
            //TODO 这里要接收用户手机号码，通过session判断是哪个用户，然后更新数据，返回更新状态 {status:0/1}
           // if(!IS_POST)
             //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            //定义自动验证规则
            //$rules = array(
              // array('user_phone','/^(13|15|18)(\d{9})|^6(\d{4,5})$/','请输入正确的手机号码',
                //    0,'regex',1),
            //);
            
            $user = M('User');
            
            //使用ThinkPHP的自动验证方法
            //if(!$user->validate($rules)>create()){
                
              //  $st = array ('status'=>0);
                //$this->ajaxReturn (json_encode($st),'JSON');
            //}
                
            
            $map['user_id']    = session('user_id');
            $data['user_phone'] = I('user_phone');
            
            $user->where($map)->save($data);
            
            //$this->redirect('Staff/showUserDetail');
            
            if($user['user_phone'] != $data['user_phone']){
                
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
            
            else {
                
                $st = array ('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
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
            //TODO 这里是一个服务端分页的例子

     //   $divide = 6;
     //   $page = (I("page") - 1) * $divide;
     //   $gM = M("fb_ground");
     //   $gCount = $gM->where("is_hot = 1")->count();
    //    $gData['ground'] = $gM->where("is_hot = 1")->limit($page, $divide)->order("order_num asc")->field(" id,ground_name,icon_01,promotion,rate,praise")->select();
   //     foreach ($gData['ground'] as &$vi) {
     //       $vi["image"] = get_cover_url($vi["icon_01"]);
//            $vi['rate']=round( $vi['rate'],1);
   //         unset($vi["icon_01"]);
//            $vi["total_page"] = $gCount / 3;
      //  }
        $gData["total"] = $gCount % $divide > 0 ? ($gCount + ($divide - $gCount % $divide)) / $divide : $gCount / $divide;
    //    $this->ajaxReturn($gData);

        //每页10个
        $divide = 10;
        //查询偏移量$page, 页数*每页显示的数量
        $page = (I("page") - 1) * $divide;
        //表格
        $gM = D("ProductListView");
        $gCount = $gM->count();
        $gData['page']=I('page');
        $gData['list'] = $gM->Field('product_id,product_barcode',true)->limit($page, $divide)->order("product_id asc")->select();
        $gData["total"] = $gCount;
        $this->ajaxReturn($gData);
        }
        
        
        /**
         * 搜索商品
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.26
         */
        public function searchProduct(){
        
           // if(!IS_AJAX)
             //      E("页面不存在");     //防止URL直接访问，开发阶段可关闭
           header('Content-Type:text/html; charset=utf-8');//防止出现乱码
           
           $sP = D('ProductListView');
           $search = I('search');
           $content = I('content');
           switch ($search){
               
               case ('name'): //按商品名称进行查询
                   $condition['product_name'] = array('like',"%{$content}%");
                   break;
               case ('barcode'): //按商品条形码进行查询
                   $condition['product_barcode'] = $content;
                   break;
           }
           $sPresult = $sP->where($condition)->select();
           $sPcount = $sPresult->count();
           if ($sPcount == 0){
               
               $this->error('您所查询的商品不存在，请重试....');
           }
           
           //每页10个
           $divide = 10;
           //查询偏移量$page, 页数*每页显示的数量
           $page = (I("page") - 1) * $divide;
           //表格
          
          
           $sPData['page']=I('page');
           $sPData['list'] = $sPresult->Field('product_id,product_barcode',true)->limit($page, $divide)->order("product_id asc")->select();
           $sPData["total"] = $sPCount;
           $this->ajaxReturn($sPData);
           
        }
        
        
        /**
         * 展示商品详情
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.26
         */
        public function showProductDetail(){
        
            header('Content-Type:text/html; charset=utf-8');//防止出现乱码
            
            $get['product_name'] = I('product_name');
            $get['warehouse_number'] = I('warehouse_number');
            
            $pD = D('ProductDetail');
            $proInfo = $pD->whrer($get)->select();
            
            $this->ajaxReturn($proInfo);
        }
        
        
        /**
         * 添加商品到领取单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.26
         */
        public function addProToReceiveOrder(){
        
            // if(!IS_POST)
            //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
        }
        
        
        /**
         * 搜索领取单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.26
         */
        public function queryReceiveOrder(){
        
            // if(!IS_AJAX)
             //      E("页面不存在");     //防止URL直接访问，开发阶段可关闭
           header('Content-Type:text/html; charset=utf-8');//防止出现乱码
           
           $qR = M('receiveorder');
           $search = I('search');
           $content = I('content');
           switch ($search){
               
               case ('date'): //按领取单生成日期搜索
                   $condition['receiveorder_date'] = $content;
                   break;
               case ('number'): //按领取单号搜索
                   $condition['receiveorder_number'] = $content;
                   break;
			   case ('state'): //按领取单状态搜索
                   $condition['receiveorder_state'] = $content;
                   break;
           }
           $qRresult = $qR->where($condition)->select();
           $qRcount = $qRresult->count();
           if ($qRcount == 0){
               
               $this->error('您所查询的领取单不存在，请重试....');
           }
           
           //每页10个
           $divide = 10;
           //查询偏移量$page, 页数*每页显示的数量
           $page = (I("page") - 1) * $divide;
           //表格
          
          
           $qRData['page']=I('page');
           $qRData['list'] = $qRresult->Field('receiveuser_id',true)->limit($page, $divide)->order("receiveorder_id asc")->select();
           $qRData["total"] = $qRCount;
           $this->ajaxReturn($qRData);
           
        }
        
        
        /**
         * 编辑领取单：只能编辑未经审核的领取单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function editReceiveOrder(){
        
        }
        
        
        /**
         * 删除领取单:只能删除未经审核的领取单
         * 0:待审核
         * 1：审核通过
         * 2：审核不通过
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function deleteReceiveOrder(){
            
            $get['receiveorder_id'] = session('receiveorder_id');
            
            $temp = M('receiveorder');
            
            $state = $temp->$temp->where($get)->find();
            
            //只能删除未经审核的领取单
            if ($state['receiveorder_state'] == 0){
                
                $temp->where($get)->delete();
				$st = array ('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
				
            }
			else {
				
				$st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
			} 
        }
        
        
        /**
         * 查看领取单详情
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function showReceiveOrderDetail(){
        
            
        }
        
        
        /**
         * 查看领取单列表
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function showReceiveOrderList(){
        
           
            // if(!IS_POST)
            //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        	//每页10个
            $divide = 10;
            //查询偏移量$page, 页数*每页显示的数量
            $page = (I("page") - 1) * $divide;
            //表格
            $receive = M('receiveorder');
			$rCount = $receive->count();
			$rData['page'] = I('page');
			$rData['list'] = $receive->Field('receiveorder_id,receiveorder_number,receiveorder_date,receiveorder_state')->limit($page, $divide)->order("receiveorder_id asc")->select();
			$rData['total'] = $rCount;
            $this->ajaxReturn($rData);
        }
    }
    
    
    
?>