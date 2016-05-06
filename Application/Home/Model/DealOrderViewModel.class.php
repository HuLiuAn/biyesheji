<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 获取订单详情
     * shli 4.24
     */
    class DealOrderViewModel extends ViewModel{
        
        public $viewFields = array(
           // 'order'             => array('order_id','sumvalue'=>'order_totalprice'),
           // 'orderdetail'       => array('_on' => 'order.order_id = orderdetail.order_id','orderdetail_id','count'=>'product_count','value'=>'product_totalprice'),
           // 'product'           => array('_on' => 'orderdetail.product_id = product_product_id','product_name','properties'),
           // 'supplierproduct'   => array('_on' => 'order.supplierproduct_id = supplierproduct.supplierproduct_id','product_price'=>'supplierproduct_price'),

            //'order'             => array('order_id','order_totalprice' => 'sumvalue'),
            'orderdetail'       => array('order_id','orderdetail_id','product_id','product_count' => 'count','product_totalprice' => 'value'),
            'product'           => array('_on' => 'orderdetail.product_id = product.product_id','product_name','properties'),
            'supplierproduct'   => array('supplier_id','_on' => 'orderdetail.product_id = supplierproduct.product_id','supplierproduct_price'=>'product_price'),
        );
    }