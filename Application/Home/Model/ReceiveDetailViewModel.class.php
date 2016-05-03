<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 查看领取单详情（普通员工和采购员只能查到本人的领取单）
     * shli 4.24
     */
    class ReceiveDetailViewModel extends ViewModel{
    
        public $viewFields = array(
    
            'receiveorder'          => array('receiveorder_id','admituser_id'),
            'receiveorderdetail'    => array('product_id','count'),
            'product'               => array('_on' =>'receiveorderdetail.product_id = product.product_id','product_name','properties'),
            'warehouse'             => array('_on' =>'receiveorderdetail.warehouse_id = warehouse.warehouse_id','warehouse_number'),
        );
    }