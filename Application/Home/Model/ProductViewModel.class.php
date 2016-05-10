<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 查看领取单详情（普通员工和采购员只能查到本人的领取单）
     * shli 4.24
     */
    class ProductViewModel extends ViewModel{

        public $viewFields = array(

            'warehouse'             => array('warehouse_id','warehouse_number'),
            'inventory'             => array('_on' =>'warehouse.warehouse_id = inventory.warehouse_id','product_id','count'),
        );
    }