<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 普通员工查看可领取的商品列表
     * shli 4.24
     */
    class ProductListViewModel extends ViewModel{
        
        public $viewFields = array(
            
            'product' => array('product_id','product_barcode','product_name','photo','property' => 'properties'),
            'inventory' => array('_on'=>'product.product_id=inventory.product_id','count'),
            'warehouse' => array('_on'=>'inventory.warehouse_id=warehouse.warehouse_id','warehouse_number'),
        );
    }

