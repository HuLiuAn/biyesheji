<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    class AddOrderViewModel extends ViewModel{
        
        /**
         * 新增订单
         * author: shli
         */
        
        public $viewFields = array(
            
            'order'                     =>array('order_number','order_date','sumvalue'=>'order_totalprice','purchaser_id','order_state','supplierproduct_id'),
            'orderdetail'               => array('_on' => 'order_order_id = orderdetail.order_id','product_id','warehouse_id','product_count','value'=>'product_totalprice'),
           
        ); 
        
    }