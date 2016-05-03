<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 添加商品到领取单
     * shli 4.24
     */
    class ReceiveViewModel extends ViewModel{
        
        public $viewFields = array(
            
            'receiveorderdetail' => array('product_id','warehouse_id','count'),
            'receiveorder'   => array('_on'=>'receiveorder.receiveorderdetail_id = receiveorderdetail.receiveorderdetail_id','receiveuser_id','receiveorder_number','receiveorder_date')，
            
        );
    }