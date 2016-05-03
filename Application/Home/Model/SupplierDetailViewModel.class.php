<?php
    namespace Home\Model;
    use Think\Model\ViewModel;
    /**
     * 用于修改供应商基本信息以及其提供的商品价格
     * shli 4.24
     */
    class SupplierDetailViewModel extends ViewModel{
    
        public $viewFields = array(
    
            'supplierproduct'       => array('supplier_id','product_id','supplierproduct_price'),
            'supplier'              => array('_on' =>'supplierproduct.supplier_id = supplier.supplier_id','supplier_name','supplier_contact','supplier_phone','supplier_address'),
        );
    }