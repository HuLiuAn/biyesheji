<?php
    namespace Home\Controller;
    use Think\Controller;
    class WareHouseController extends Controller{
        
          /**
         * 新增仓库
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function addWareHouse(){
            
            $json = file_get_contents("php://input");
            $arr = json_decode($json);
            //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
            if ($arr->session_id) {
                session_id($arr->session_id);
                session_start();
            }
            if (!session('?user_id')) {
                $userInfo['status'] = "0";
                $userInfo['session_id'] = "0";
                $this->ajaxReturn(json_encode($userInfo), 'JSON');
                return;
            }
            
            $wH = M('warehouse');
            
            $data = array(
                
                'warehouse_number'      => I('name'),
                'warehouse_address'     => I('address'),
            );
            $is_success = $wH->data($data)->add();
            
            if ($is_success){
            
                $st = array ('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
            }else {
            
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
        }
        
        
        
        /**
         * 修改仓库信息
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function modifyWareHouse(){
            
            $json = file_get_contents("php://input");
            $arr = json_decode($json);
            //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
            if ($arr->session_id) {
                session_id($arr->session_id);
                session_start();
            }
            if (!session('?user_id')) {
                $userInfo['status'] = "0";
                $userInfo['session_id'] = "0";
                $this->ajaxReturn(json_encode($userInfo), 'JSON');
                return;
            }
        
            $wH = M('warehouse');
            $map['warehouse_id'] = session('warehouse_id');
            $data = array(
        
                'warehouse_number'      => I('name'),
                'warehouse_address'     => I('address'),
            );
            if ($wH->where($map)->find()){
                $wH->where($map)->save($data);
            $st = array ('status'=>1);
            $this->ajaxReturn (json_encode($st),'JSON');
        }else {
        
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
        }
        
        
        /**
         * 查找仓库
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function queryWareHouse(){
            
            $json = file_get_contents("php://input");
            $arr = json_decode($json);
            //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
            if ($arr->session_id) {
                session_id($arr->session_id);
                session_start();
            }
            if (!session('?user_id')) {
                $userInfo['status'] = "0";
                $userInfo['session_id'] = "0";
                $this->ajaxReturn(json_encode($userInfo), 'JSON');
                return;
            }
            
            
        }
        
        
        /**
         * 仓库调拨
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function queryWareHouse(){
        
            $json = file_get_contents("php://input");
            $arr = json_decode($json);
            //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
            if ($arr->session_id) {
                session_id($arr->session_id);
                session_start();
            }
            if (!session('?user_id')) {
                $userInfo['status'] = "0";
                $userInfo['session_id'] = "0";
                $this->ajaxReturn(json_encode($userInfo), 'JSON');
                return;
            }
        
        
        }
        
        
        
        
    }