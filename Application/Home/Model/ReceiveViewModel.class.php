<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 添加商品到领取单
     * shli 4.24
     */
    class ReceiveViewModel extends ViewModel{
        
        public $viewFields = array(
            
            'receiveorderdetail'    => array('product_id','warehouse_id','count'),
            'receiveorder'          => array('_on'=>'receiveorder.receiveorder_id = receiveorderdetail.receiveorder_id','receiveuser_id','receiveorder_number','receiveorder_date','receiveorder_state'),
            'warehouse'             => array('_on'=>'warehouse.warehouse_id=receiveorder.warehouse_id','warehouse_number'),
           // 'inventory'             =>array('_on'=>'receiveorder.warehouse_id=inventory.warehouse_id','_on'=>'receiveorderdetail.product_id=inventory.product_id','inventory_count'=>'count'),
        );
    }