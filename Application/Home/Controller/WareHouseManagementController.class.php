<?php
namespace Home\Controller;

use Think\Controller;

class WareHouseManagementController extends Controller
{

    /**
     * 查询订单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function queryOrderList()
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
        if ($arr->page) {
            //没有页数，默认显示第一页
            $page = 0;
        }

        $sP = M('order');
        $sPData['page'] = $arr->page;
        if (!empty($arr->purchaser_name)) {
            $map['USER1.user_name'] = array('like', "%" . $arr->purchaser_name . "%");
        }
        if (!empty($arr->auditor_name)) {
            $map['USER2.user_name'] = array('like', "%" . $arr->auditor_name . "%");
        }
        if (!empty($arr->order_number)) {
            $map['order_number'] = array('like', "%" . $arr->order_number . "%");
        }
        if ($arr->order_state === "0" || !empty($arr->order_state)) {
            $map['order_state'] = $arr->order_state;
        }
        if (!empty($arr->start_time) && !empty($arr->end_time)) {
            $map['order_time'] = array(array('gt', strtotime($arr->start_time)), array('lt', strtotime($arr->end_time) + 3600 * 24 - 1));
        } else if (!empty($arr->start_time)) {
            $map['order_time'] = array('gt', strtotime($arr->start_time));
        } else if (!empty($arr->end_time)) {
            $map['order_time'] = array('lt', strtotime($arr->end_time) + 3600 * 24 - 1);
        }
        if (!empty(count($map))) {
            //只要有一个搜索条件，就选择搜索模式
            $sPData["total"] = $sP->join(' __USER__ USER1 ON USER1.user_id = __ORDER__.purchaser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __ORDER__.auditor_id', 'LEFT')
                ->where($map)
                ->count();
            $sPData['list'] = $sP->join(' __USER__ USER1 ON USER1.user_id = __ORDER__.purchaser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __ORDER__.auditor_id', 'LEFT')
                ->field('tb_order.*, USER1.user_name as purchaser_name,USER2.user_name as auditor_name')
                ->where($map)
                ->select();
        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->join(' __USER__ USER1 ON USER1.user_id = __ORDER__.purchaser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __ORDER__.auditor_id', 'LEFT')
                ->field('tb_order.*, USER1.user_name as purchaser_name,USER2.user_name as auditor_name')
                ->select();
        }
        $this->ajaxReturn($sPData);
    }


    /**
     * 显示订单详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showOrderDetail()
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


        $map['order_id'] = $arr->order_id;
        $map['supplier_id'] = $arr->supplier_id;
        $sOD = D('DealOrderView');

        $divide = 15;
        $page = ($arr->page - 1) * $divide;

        $sData['page'] = $arr->page;
        $sData['total'] = $sOD->where($map)->count();
        $sData['list'] = $sOD->where($map)->field('order_id,supplier_id', true)->limit($page, $divide)->order('orderdetail_id asc')->select();

        $this->ajaxReturn($sData);
    }


    /**
     * 查询领取单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */

    public function queryReceiveOrder()
    {

        // if(!IS_AJAX)
        //      E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        header('Content-Type:text/html; charset=utf-8');//防止出现乱码

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

        $sP = M('receiveorder');
        $sPData['page'] = $arr->page;

        $sPData['status'] = "0";

        //TODO 查询条件太多，有点乱
        if (!empty($arr->receiveorder_number) || !empty($arr->date) || !empty($arr->admituser_number) || !empty($arr->receiveuser_number) || !empty($arr->receiveorder_state)) {

            $pN['user_number'] = array('like', "%" . $arr->admituser_number . "%");
            $aN['user_number'] = array('like', "%" . $arr->receiveuser_number . "%");

            //只要有一个搜索条件，就选择搜索模式
            $map['receiveorder_number'] = array('like', "%" . $arr->receiveorder_number . "%");
            //TODO 按照日期范围查询应该怎么匹配？
            $map['receiveorder_date'] = array('like', "%" . $arr->date . "%");
            $map['receiveuser_id'] = M('user')->where($pN)->find();
            $map['admituser_id'] = M('user')->where($aN)->find();
            $map['receiveorder_state'] = $arr->receiveorder_state;
            $sPData["total"] = $sP->where($map)->count();
            $sPData['status'] = "1";
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("receiveorder_id asc")->select();

        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("receiveorder_id asc")->select();
        }
        $this->ajaxReturn($sPData);

    }


    /**
     * 查看领取单详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showReceiveOrderDetail()
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


        $map['receiveorder_id'] = $arr->receiveorder_id;
        $rOD = D('ReceiveDetailView');

        $divide = 15;
        $page = ($arr->page - 1) * $divide;

        $sData['page'] = $arr->page;
        $sData['total'] = $rOD->where($map)->count();
        $sData['list'] = $rOD->where($map)->field('receiveorder_id', true)->limit($page, $divide)->order('receiveorderdetail_id asc')->select();

        $this->ajaxReturn($sData);
    }


    /**
     * 搜索调拨单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */

    public function queryAllocationList()
    {

        // if(!IS_AJAX)
        //      E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        header('Content-Type:text/html; charset=utf-8');//防止出现乱码

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

        $sP = M('allocationorder');
        $sPData['page'] = $arr->page;
        if (!empty($arr->outwarehouse_number)) {
            $map['WARE1.warehouse_number'] = array('like', "%" . $arr->outwarehouse_number . "%");
        }
        if (!empty($arr->inwarehouse_number)) {
            $map['WARE2.warehouse_number'] = array('like', "%" . $arr->inwarehouse_number . "%");
        }
        if (!empty($arr->allocate_number)) {
            $map['allocationorder_number'] = array('like', "%" . $arr->allocate_number . "%");
        }
        if (!empty($arr->start_time) && !empty($arr->end_time)) {
            $map['allocationorder_time'] = array(array('gt', strtotime($arr->start_time)), array('lt', strtotime($arr->end_time) + 3600 * 24 - 1));
        } else if (!empty($arr->start_time)) {
            $map['allocationorder_time'] = array('gt', strtotime($arr->start_time));
        } else if (!empty($arr->end_time)) {
            $map['allocationorder_time'] = array('lt', strtotime($arr->end_time) + 3600 * 24 - 1);
        }
        if (!empty(count($map))) {
            //只要有一个搜索条件，就选择搜索模式
            $sPData["total"] = $sP->join(' __WAREHOUSE__ WARE1 ON WARE1.warehouse_id = __ALLOCATIONORDER__.outwarehouse_id', 'LEFT')
                ->join(' __WAREHOUSE__ WARE2 ON WARE2.warehouse_id = __ALLOCATIONORDER__.inwarehouse_id', 'LEFT')
                ->join(' __USER__  ON __USER__.user_id = __ALLOCATIONORDER__.user_id', 'LEFT')
                ->where($map)
                ->count();
            $sPData['list'] = $sP->join(' __WAREHOUSE__ WARE1 ON WARE1.warehouse_id = __ALLOCATIONORDER__.outwarehouse_id', 'LEFT')
                ->join(' __WAREHOUSE__ WARE2 ON WARE2.warehouse_id = __ALLOCATIONORDER__.inwarehouse_id', 'LEFT')
                ->join(' __USER__  ON __USER__.user_id = __ALLOCATIONORDER__.user_id', 'LEFT')
                ->field('tb_allocationorder.*, WARE1.warehouse_number as outwarehouse_number,WARE2.warehouse_number as inwarehouse_number,user_name')
                ->where($map)
                ->select();
        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->join(' __WAREHOUSE__ WARE1 ON WARE1.warehouse_id = __ALLOCATIONORDER__.outwarehouse_id', 'LEFT')
                ->join(' __WAREHOUSE__ WARE2 ON WARE2.warehouse_id = __ALLOCATIONORDER__.inwarehouse_id', 'LEFT')
                ->join(' __USER__  ON __USER__.user_id = __ALLOCATIONORDER__.user_id', 'LEFT')
                ->field('tb_allocationorder.*, WARE1.warehouse_number as outwarehouse_number,WARE2.warehouse_number as inwarehouse_number,user_name')
                ->select();
        }
        $this->ajaxReturn($sPData);
    }


    /**
     * 显示调拨单详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */

    public function showAllocationDetail()
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


        $map['allocationorder_id'] = $arr->allocationorder_id;
        if (empty($arr->allocationorder_id)) {
            $userInfo['status'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }
        $rOD = M('allocationorder');
        $sData['result'] = $rOD->join(' __WAREHOUSE__ WARE1 ON WARE1.warehouse_id = __ALLOCATIONORDER__.outwarehouse_id', 'LEFT')
            ->join(' __WAREHOUSE__ WARE2 ON WARE2.warehouse_id = __ALLOCATIONORDER__.inwarehouse_id', 'LEFT')
            ->join(' __USER__  ON __USER__.user_id = __ALLOCATIONORDER__.user_id', 'LEFT')
            ->join(' __ALLOCATIONORDERDETAIL__  ON __ALLOCATIONORDERDETAIL__.allocationorder_id = __ALLOCATIONORDER__.allocationorder_id', 'LEFT')
            ->field('tb_allocationorder.*, WARE1.warehouse_number as outwarehouse_number,WARE2.warehouse_number as inwarehouse_number,user_name,product_id,allocationorderdetail_count')
            ->find();
        $map2['product_id'] = $sData['result']['product_id'];
        $rOD = M('product')->where($map2)->find();
        $sData['result']['product_name']=$rOD['product_name'];
        $sData['status'] = "1";
        $this->ajaxReturn($sData);

    }


    /**
     * 审核
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */

    public function review()
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

        $map = $arr->number;

        $is_order = "TROL";
        $is_receive = "TOAL";

        $st['status'] = "0";
        if (explode($is_order, $map)) {
            $st['status'] = "1";
            $result = M('order')->where($arr->id)->save($arr->state);

            //如果审核通过，修改入库商品库存
            if ($result == 1) {

                //TODO   修改所有入库商品库存
                $rOD['receiveorderdetail_id'] = M('receiveorderdetail')->where($arr->id)->select();

            }
        }

        if (explode($is_receive, $map)) {
            $st['status'] = "1";
            $result = M('receiveorder')->where($map)->save($arr->state);
        }

        $this->ajaxReturn(json_encode($st), 'JSON');


    }
}
