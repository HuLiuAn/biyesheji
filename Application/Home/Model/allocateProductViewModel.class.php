<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
/**
 * Created by PhpStorm.
 * User: shli
 * Date: 2016/5/4
 * Time: 21:16
 */
    class AllocateProductViewModel extends ViewModel{

        public $viewFields = array(

            'product'                => array('product_id','product_name','properties'),
            'inventory'             => array('_as' => 'inhubproinventory','_on' => 'product.product_id = inventory.product_id','warehouse_id' => 'inwarehouse_id','count' => 'in_count'),
            'inventory'             => array('_as' => 'outhubproinventory','_on' => 'product.product_id = inventory.product_id','warehouse_id' => 'outwarehouse_id','count' => 'out_count'),
            'warehousecapacity'    => array('_on' => 'product.product_id = warehouse.product_id','_on' => 'inhubproinventory.inwarehouse_id = warehousecapacity.warehouse_id','maxcount' => 'inhubpro_capacity'),
        );
    }

