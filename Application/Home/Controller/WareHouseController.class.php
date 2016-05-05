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
            
            $search = I('search');
            $content =I('content');
            
            $sL = M('warehouse');
            
            switch ($search){
            
                case('warehouse_number'):   //按仓库名字搜索
                    $condition['warehouse_number'] = array('like',"%{$content}%");
                    $sLresult = $sL->where($condition)->select();
                    break;
                case(''):  //获取全部仓库
                    $sLresult = $sL->select();
                    break;
            
            }
            
            //$sLresult = $sL->where($condition)->select();
            $sLcount = $sLresult->count();
            if ($sLcount == 0){
                 
                $this->error('您所查询的供应商不存在，请重试....');
            }
            
            //每页10个
            $divide = 10;
            
            //偏移量$page ,页数*每页显示的记录条数
            $page = (I('page')-1) * $divide;
            
            $sData['page'] = I('page');
            $sData['total'] = $sLcount;
            $sData['list'] = $sLresult->field('*')->limit($page,$divide)->order('warehouse_id asc')->select();
            
            $this->ajaxReturn($sData);
        }



        /**
         * 选择入库仓库需要补入的商品：商品的库存小于该商品在该的最大库存（可以选择入库仓库之前没有的商品）
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function allocateProduct()
        {

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
            $map = session('warehouse_id');
            $search = $arr->search;
            $content = $arr->content;

            $sL = D('AllocateProductView');

            switch ($search){

                case('product_name'):   //按商品名字搜索
                    $condition['product_name'] = array('like',"%{$content}%");
                    $sLresult = $sL->where($condition)->select();
                    break;
                case(''):  //获取全部商品
                    $sLresult = $sL->select();
                    break;

            }

            //$sLresult = $sL->where($condition)->select();
            $sLcount = $sLresult->count();
            if ($sLcount == 0){

                $this->error('您所查询的商品不存在，请重试....');
            }

           if($sLresult->where($map)->find())
               $alocatcount =

            //每页10个
            $divide = 10;

            //偏移量$page ,页数*每页显示的记录条数
            $page = ($arr->page-1) * $divide;

            $sData['page'] = $arr->page;
            $sData['total'] = $sLcount;

            //TODO 此处需要修改
            $sData['list'] = $sLresult->field('supplier_id',true)->limit($page,$divide)->order('product_id asc')->select();

            $this->ajaxReturn($sData);


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
            public function allocate(){

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