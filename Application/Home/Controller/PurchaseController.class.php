<?php
    namespace Home\Controller;
    use Think\Controller;
    class PurchaseController extends Controller {
        
        /**
         * 添加供应商
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function addSupplier(){
    
            // if(!IS_POST)
            //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
                  
           
        }
    
    
        /**
         * 编辑供应商信息
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function editSupplier(){
    
        }
    
    
        /**
         * 添加商品
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function addProduct(){
    
            // if(!IS_POST)
            //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
            
            //调用Application/Home/Common/function.php中自定义方法imgUpload()获取图片名称
            $product_add = imgUpload();
            $data = array(
                'product_name'        => I('product_name'),
                'product_barcode'     => I('product_barcode'),
                //TODO 如何获取商品组图？
                'product_photogroup'  => I('product_photogroup'),
                'product_photo'       => $product_add,
                //TODO 获取商品属性信息
            );
            
            $product = D('productView');
            
            //添加商品成功
            if ($product->add($data)){
                
                $st = array ('status'=>1);
                $this->ajaxReturn (json_encode($st),'JSON');
            }else {
                //添加商品失败
                $st = array ('status'=>0);
                $this->ajaxReturn (json_encode($st),'JSON');
            }
            
        }
    
    
        /**
         * 搜索商品
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function searchProduct(){
    
            $page = I('page');
            $search = I('search');
            $content = I('content');
            
            $sP = M('product');
            
            switch ($search){
                case ('name'):
                    $condition = array('like',"%{$content}%");
                    break;
                case ('barcode'):
                    $condition = $content;
                    break;
                case (''):
                    $condition = $sP;
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
            //TODO 需要向前台返回商品属性 使用D方法实例化模型类
            $sPData['list'] = $sPresult->Field('product_id,product_barcode',true)->limit($page, $divide)->order("product_id asc")->select();
            $sPData["total"] = $sPCount;
            $this->ajaxReturn($sPData);
        }
    
    
        /**
         * 添加商品到供应商
         * 并且设置该供应商的商品价格
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function addProToSupplier(){
    
        }
    
    
        /**
         * 编辑商品价格
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function editProPrices(){
    
        }
    
    
        /**
         * 将商品从供应商提供商品列表中删除
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function delProFromSupplier(){
    
        }
    
    
        /**
         * 搜索供应商
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function searchSupplier(){
    
        }
    
    
    
        /**
         * 显示订单列表
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function showOrderList(){
    
        }
    
    
        /**
         * 查询订单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function queryOrder(){
    
        }
    
    
        /**
         * 显示订单详情
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function showOrderDetail(){
    
        }
    
    
        /**
         * 新增订单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function addOrder(){
    
        }
    
    
        /**
         * 编辑订单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function editOrder(){
    
        }
    
    
        /**
         * 删除订单
         * @access public
         * @param void
         * @return void
         *
         * author: shli
         * date: 2016.04.12
         */
        public function deleteOrder(){
    
        }
    }

?>
