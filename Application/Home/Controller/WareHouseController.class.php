<?php
namespace Home\Controller;

use Think\Controller;

class WareHouseController extends Controller
{

    /**
     * 新增仓库
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addWareHouse()
    {

        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        $wH = M('warehouse');

        $data = array(

            'warehouse_number' => $arr->warehouse_number,
            'warehouse_address' => $arr->warehouse_address,
            'warehouse_maxcount' => $arr->warehouse_maxcount,
        );
        if ($arr->warehouse_id) {
            $map['warehouse_id'] = $arr->warehouse_id;
            $is_success = $wH->where($map)->save($data);
        } else {
            $is_success = $wH->data($data)->add();
        }


        if ($is_success) {

            $st = array('status' => 1);
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {

            $st = array('status' => 0);
            $this->ajaxReturn(json_encode($st), 'JSON');
        }
    }


    /**
     * 修改仓库信息
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function modifyWareHouse()
    {

        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        $wH = M('warehouse');
        $map['warehouse_id'] = $arr->warehouse_id;
        $re = $wH->where($map)->find();
        if ($re) {
            $re['status'] = 1;
            $this->ajaxReturn(json_encode($re), 'JSON');
        } else {
            $re['status'] = 0;
            $this->ajaxReturn(json_encode($re), 'JSON');
        }
    }


    /**
     * 查找仓库
     * 向前台返回仓库ID和名称
     * 用户查询仓库调用该接口
     * 调拨时选择出入库仓库调用该接口，
     * 且一张调拨单拥有唯一的入库和出库仓库,
     * 出入库仓库不能相同
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function queryWareHouse()
    {

        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }


        //每页10个
        $divide = 10;
        //查询偏移量$page, 页数*每页显示的数量
        $page = ($arr->page - 1) * $divide;
        //表格
        if (empty($page)) {
            //没有页数，默认显示第一页
            $page = 0;
        }

        $sP = M('warehouse');
        $sPData['page'] = $arr->page;
        if (!empty($arr->number) || !empty($arr->address)) {
            //选择搜索模式
            $map['warehouse_number'] = array('like', "%" . $arr->number . "%");
            $map['warehouse_address'] = array('like', "%" . $arr->address . "%");
            $sPData["total"] = $sP->where($map)->count();
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("warehouse_id asc")->select();
        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("warehouse_id asc")->select();

        }
        $sPData['status'] = "1";
        if (empty($sPData)) {
            $sPData['status'] = "0";
            $this->ajaxReturn($sPData);
        }
        $this->ajaxReturn($sPData);
    }


    /**
     * 选择需要进行调拨的商品
     * 必须先选择入库和出库仓库，才能选择可进行调拨的商品
     * 返回数据：
     * product_id:商品id
     * product_name:商品名称
     * properties:商品属性
     * inhubpro_capacity:入库仓库商品最大容量
     * in_count:入库仓库商品现有库存
     * out_count:出库仓库商品现有库存:
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function allocateProduct()
    {

        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        $map['inwarehouse_id'] = $arr->inwarehouse_id;
        $map['outwarehouse_id'] = $arr->outwarehouse_id;

        // $i['inwarehouse_id'] = $arr->inwarehouse_id;
        //$i['product_id'] = $arr->product_id;
        //$o['outwarehouse_id'] = $arr->outwarehouse_id;
        //$o['product_id'] = $arr->product_id;

        //$inventory = M('inventory');
        //$sPData['in_count']  = $inventory->where($i)->field('count')->find();
        //$sPData['out_count']  = $inventory->where($o)->field('count')->find();


        $sPData['status'] = "1";
        if (empty($arr->inwarehouse_id) && empty($arr->outwarehouse_id)) {
            $sPData['status'] = "0";
            $this->ajaxReturn($sPData);
        }
        //每页10个
        $divide = 10;
        //查询偏移量$page, 页数*每页显示的数量
        $page = ($arr->page - 1) * $divide;
        //表格
        if (empty($page)) {
            //没有页数，默认显示第一页
            $page = 0;
        }

        $sP = D(' AllocateProductView');
        $sPData['page'] = $arr->page;
        if (!empty($arr->barcode) || !empty($arr->name)) {
            //只要有一个搜索条件，就选择搜索模式
            $map['product_barcode'] = array('like', "%" . $arr->barcode . "%");
            $map['product_name'] = array('like', "%" . $arr->name . "%");
            $sPData["total"] = $sP->where($map)->count();
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("product_id asc")->select();

        } else {
            $sPData["total"] = $sP->where($map)->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("product_id asc")->select();

        }
        $this->ajaxReturn($sPData);


    }


    /**
     * 新增调拨单
     * 仓库调拨不需要审核，一旦生成调拨单，则默认商品已经调拨成功
     * 获取参数：
     * count:商品调拨数量
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addAllocate()
    {

        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        // $aAO = D('AddAllocationOrderView');
        $aAO = M('allocationorder');
        $aAD = M('allcationorderdetail');
        $inventory = M('inventory');

        //$i['inwarehouse_id'] = $arr->inwarehouse_id;
        //$i['product_id'] = $arr->product_id;
        // $o['outwarehouse_id'] = $arr->outwarehouse_id;
        //$o['product_id'] = $arr->product_id;

        $st['status'] = "0";
        if (empty($arr->inwarehouse_id) && empty($arr->outwarehouse_id) && empty($arr->product->count)) {

            $this->ajaxReturn(json_encode($st), 'JSON');
        }


        /* 选择一个随机的方案 */
        mt_srand((double)microtime() * 1000000);
        //生成调拨单号
        $data['allocationorder_number'] = 'TACO' . date('Ymd') . str_pad(mt_rand(1, 99999), 4, '0', STR_PAD_LEFT);
        $data['allocationorder_date'] = date('Y-m-d', time());
        $data['user_id'] = $arr->user_id;
        $data['inwarehouse_id'] = $arr->inwarehouse_id;
        $data['outwarehouse_id'] = $arr->outwarehouse_id;
        // $data['product_id']                     = $arr->product_id;
        //$data['count']                           = $arr->count;

        //新增调拨单并将调拨单id赋给变量
        $aAD_data['allocationorder_id'] = $aAO->data($data)->add();

        if ($aAD_data['allocationorder_id']) {

            //如果调拨单生成成功，向调拨单详情表中插入调拨商品记录
            foreach ($arr->product as $product) {
                $sp_data['product_id'] = $product->product_id;
                $sp_data['count'] = $product->count;
                $aAD->data($sp_data)->add();

                $i['warehouse_id'] = $arr->inwarehouse_id;
                $i['product_id'] = $product->product_id;
                $o['warehouse_id'] = $arr->outwarehouse_id;
                $o['product_id'] = $product->product_id;

                //修改该商品在出入库仓库库存数量
                $inventory->where($i)->setInc('count', $arr->count);
                $inventory->where($o)->setDec('count', $arr->count);

            }

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }
        $this->ajaxReturn(json_encode($st), 'JSON');

        //一个统计字段自动更新的例子
        //$Article = M("Article"); // 实例化Article对象
        // $Article->where('id=5')->setInc('view',1); // 文章阅读数加1
        // $Article->where('id=5')->setInc('view',1,60); // 文章阅读数加1， 并且延迟60秒更新（ 写入）

        //$data['in_count']  = $aAO->where($i)->setInc('in_count',$arr->count);
        //$data['out_count'] = $aAO->where($o)->setDec('out_count',$arr->count);

        //if($aAO->data($data)->add()){

        //   $st['status'] = "1";
        //    $this->ajaxReturn (json_encode($st),'JSON');
        // }

        //  $this->ajaxReturn (json_encode($st),'JSON');
    }


}