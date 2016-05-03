<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 供应商商品表
     * 显示供应商拥有的商品及其价格
     * shli 4.24
     */
    class SupplierProductViewModel extends ViewModel{
    
        public $viewFields = array(
    
            'supplierproduct'       => array('supplier_id','product_id','supplierproduct_price'),
            'product'               => array('_on' =>'supplierproduct.product_id = product.product_id','product_name','properties'),
        );
    }