<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 普通员工查看可领取的商品列表
     * shli 4.24
     */
    class ProductListViewModel extends ViewModel{
        
        public $viewFields = array(

            'inventory' => array('inventory_id','warehouse_id','product_id','count'),
            'product' => array( '_on'=>'inventory.product_id=product.product_id','product_barcode','product_name','product_photo','properties'),
            'warehouse' => array('_on'=>'inventory.warehouse_id=warehouse.warehouse_id','warehouse_number'),
        );
    }

