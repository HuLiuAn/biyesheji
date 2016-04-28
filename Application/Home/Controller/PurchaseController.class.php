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
    
            $product = M('product');
            
            $new('product_name') = I('product_name');
            $new('product_barcode') = I('product_barcode');
            $new('product_photogroup') = I('product_photogroup');
            $new('product_photo') = I('product_photo');
            
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
