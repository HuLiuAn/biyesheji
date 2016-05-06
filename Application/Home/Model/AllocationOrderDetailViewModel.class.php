<?php

namespace Home\Model;
use Think\Model\ViewModel;
/**
 * Created by PhpStorm.
 * User: shli
 * Date: 2016/5/6
 * Time: 17:32
 */
class AllocationOrderDetailViewModel extends ViewModel{

    public $viewFields = array(

        'allocationorderdetail'               => array('allocationorder_id','product_id','count'),
        'product'                               => array('_on' => 'allocationorderdetail.product_id = product.product_id','product_name','properties'),
    );
}