<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
/**
 * shli
 * 2016.5.5
 */
    class AddAllocationOrderViewModel extends ViewModel{

        public $viewFields = array(

            'allocationorder'                => array('allocationorder_number','inwarehouse_id','outwarehouse_id','user_id','allocationorder_date'),
            'allocationorderdetail'         => array('_on' => 'allocationorder.allocationorder_id = allocationorderdetail.allocationorder_id','count','product_id'),
            'inventory'                       => array('_as' => 'inhubproinventory','_on' => 'allocationorderdetail.product_id = inventory.product_id','warehouse_id' => 'inwarehouse_id','_on' => 'allocationorder.inwarehouse_id = inhubproinventory.inwarehouse_id','count' => 'in_count'),
            'inventory'                       => array('_as' => 'outhubproinventory','_on' => 'allocationorderdetail.product_id = inventory.product_id','warehouse_id' => 'outwarehouse_id','_on' => 'allocationorder.outwarehouse_id = outhubproinventory.outwarehouse_id','count' => 'out_count'),

        );
    }
