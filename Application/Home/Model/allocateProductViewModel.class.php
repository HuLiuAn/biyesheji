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

            'product'            => array('product_id','product_name','properties'),
            'inventory'         => array('_on' => 'product.product_id = inventory.product_id','warehouse_id','count')

        );
    }

