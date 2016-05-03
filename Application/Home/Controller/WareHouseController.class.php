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
            
            
        }
        
        
        
        
    }