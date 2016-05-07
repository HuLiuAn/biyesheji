<?php
namespace Home\Controller;
use Think\Controller;

class PurchaseController extends Controller
{

    /**
     * 添加供应商
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addSupplier()
    {

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        header('Content-Type:text/html; charset=utf-8');

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


        $supplier = M('supplier');
        $supplier_product = M('supplierproduct');
        //保存供应商，并获取供应商ID
        $data = array(
            'supplier_name' => $arr->name,
            'supplier_contact' => $arr->contact,
            'supplier_phone' => $arr->phone,
            'supplier_address' => $arr->address,
        );
        $sp_data['supplier_id'] = $supplier->data($data)->add();
        // var_dump($s);
        if ($sp_data['supplier_id']) {
            foreach ($arr->product as $product) {
                $sp_data['product_id'] = $product->product_id;
                $sp_data['supplierproduct_price'] = $product->supplierproduct_price;
                $supplier_product->data($sp_data)->add();
            }
            $st = array('status' => 1);
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {
            $st = array('status' => 0);
            $this->ajaxReturn(json_encode($st), 'JSON');
        }

    }


    /**
     * 向tb_product表添加商品信息
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addProduct()
    {

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

        //调用Application/Home/Common/function.php中自定义方法imgUpload()获取图片名称
        //$imgupload = imgUpload();

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

        $data['product_name'] = $arr->product_name;
        $data['product_barcode'] = $arr->product_barcode;
        $data['product_photogroup'] = json_encode($arr->product_photogroup);
        $data['product_photo'] = $arr->product_photo;
        $data['properties'] = $arr->product_properties;
        $product = M('product');
        //添加商品成功
        if ($arr->product_id) {
            //如果有ID，则存。
            $map['product_id'] = $arr->product_id;
            if ($product->where($map)->save($data)) {
                $st['status'] = "1";
                $this->ajaxReturn(json_encode($st), 'JSON');
            } else {
                //添加商品失败
                $st['status'] = "0";
                $this->ajaxReturn(json_encode($st), 'JSON');
            }
        }
        if ($product->add($data)) {

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {
            //添加商品失败
            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }

    }


    /**
     * 显示product详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showProductDetail()
    {

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

        //调用Application/Home/Common/function.php中自定义方法imgUpload()获取图片名称
        //$imgupload = imgUpload();

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

        if (empty($arr->product_id)) {
            //没有ID直接返回失败
            $result['status'] = "0";
            $this->ajaxReturn(json_encode($result), 'JSON');
        }

        $map['product_id'] = $arr->product_id;
        $product = M('product');
        //添加商品成功
        $result = $product->where($map)->find();
        if ($result) {
            $result['status'] = "1";
            $this->ajaxReturn(json_encode($result), 'JSON');
        } else {
            //添加商品失败
            $result['status'] = "0";
            $this->ajaxReturn(json_encode($result), 'JSON');
        }

    }


    /**
     * 显示商品列表 and 搜索商品
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function searchProduct()
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
        if (empty($arr->page)) {
            //没有页数，默认显示第一页
            $page = 0;
        }

        $sP = M('product');
        $sPData['page'] = $arr->page;
        if (!empty($arr->barcode) || !empty($arr->name)) {
            //只要有一个搜索条件，就选择搜索模式
            $map['product_barcode'] = array('like', "%" . $arr->barcode . "%");
            $map['product_name'] = array('like', "%" . $arr->name . "%");
            $sPData["total"] = $pCount = $sP->where($map)->count();
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("product_id asc")->select();

        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("product_id asc")->select();

        }
        $this->ajaxReturn($sPData);
    }


    /**
     * 添加商品到供应商
     * 并且设置该供应商的商品价格
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addProToSupplier()
    {


        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $get['supplier_id'] = session('supplier_id');
        $get['product_id'] = session('product_id');
        $get['supplierproduct_price'] = I('price');

        $sP = M('supplierproduct');
        $result = $sP->data($get)->add();
        if ($result) {

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');

        } else {

            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');

        }
    }


    /**
     * 显示所有商品，供新增供应商时选择
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function getAllProductList()
    {

        if (!session('?user_id')) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        $sP = M('product');
        $map['product_name'] = array('like', "%" . I('name') . "%");
        $sPData['list'] = $sP->where($map)->order("product_id asc")->select();
        $sPData['status'] = "1";
        $this->ajaxReturn($sPData);
    }



    /**
     * 编辑商品价格
     *
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    /*public function editProPrices(){

    }*/


    /**
     * 将商品从供应商提供商品列表中删除
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function delProFromSupplier()
    {

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $get['supplier_id'] = session('supplier_id');
        $get['product_id'] = session('product_id');

        $sP = M('supplierproduct');
        $result = $sP->where($get)->delete();
        if ($result) {

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');

        } else {

            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');

        }
    }


    /**
     * 搜索供应商
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function searchSupplier()
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

        $sP = M('supplier');
        $sPData['page'] = $arr->page;
        if (!empty($arr->contact) || !empty($arr->name) || !empty($arr->phone)) {
            //只要有一个搜索条件，就选择搜索模式
            $map['supplier_contact'] = array('like', "%" . $arr->contact . "%");
            $map['supplier_name'] = array('like', "%" . $arr->name . "%");
            $map['supplier_phone'] = array('like', "%" . $arr->phone . "%");
            $sPData["total"] = $pCount = $sP->where($map)->count();
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("supplier_id asc")->select();

        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("supplier_id asc")->select();
        }
        $this->ajaxReturn($sPData);
    }


    /**
     * 显示供应商详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showSupplierDetail()
    {

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

        //调用Application/Home/Common/function.php中自定义方法imgUpload()获取图片名称
        //$imgupload = imgUpload();

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

        if (empty($arr->supplier_id)) {
            //没有ID直接返回失败
            $result['status'] = "0";
            $this->ajaxReturn(json_encode($result), 'JSON');
        }

        $map['supplier_id'] = $arr->supplier_id;
        $supplier = M('supplier');
        //获取供应商
        $result = $supplier->where($map)->find();
        if ($result) {
            //获取商品列表
            $spMap['supplier_id'] = $result['supplier_id'];
            $Sp = M('supplierproduct');
            $result['products'] = $Sp->join('__PRODUCT__ ON __SUPPLIERPRODUCT__.product_id = __PRODUCT__.product_id')->where($spMap)->select();
            $result['status'] = "1";
            $this->ajaxReturn(json_encode($result), 'JSON');
        } else {
            //获取供应商失败
            $result['status'] = "0";
            $this->ajaxReturn(json_encode($result), 'JSON');
        }

    }

    /**
     * 编辑供应商信息
     * 修改基本信息和商品价格
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function editSupplier()
    {
        $json = file_get_contents("php://input");
        $arr = json_decode($json);
        //上面的代码，适用于前台POST过来的是JSON，而不是表单。然后I（）方法不用。
        if ($arr->session_id) {
            session_id($arr->session_id);
            session_start();
        }
        if (!session('?user_id') || !$arr->supplier_id) {
            $userInfo['status'] = "0";
            $userInfo['session_id'] = "0";
            $this->ajaxReturn(json_encode($userInfo), 'JSON');
            return;
        }

        $supplier = M('supplier');
        $supplier_product = M('supplierproduct');
        //保存供应商，并获取供应商ID
        $data = array(
            'supplier_name' => $arr->supplier_name,
            'supplier_contact' => $arr->supplier_contact,
            'supplier_phone' => $arr->supplier_phone,
            'supplier_address' => $arr->supplier_address,
        );
        $smap['supplier_id'] = $arr->supplier_id;
        $supplier->where($smap)->data($data)->save();
        // var_dump($s);

        //删除旧的，添加新的。
        $supplier_product->where($smap)->delete();
        foreach ($arr->product as $product) {
            $smap['product_id'] = $product->product_id;
            $smap['supplierproduct_price'] = $product->supplierproduct_price;
            $supplier_product->data($smap)->add();
        }
        $st = array('status' => 1);
        $this->ajaxReturn(json_encode($st), 'JSON');

    }


    /**
     * 在订单界面返回供应商ID和名字，用于为订单选择唯一供应商
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showSupplierList()
    {

        // if(!IS_AJAX)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $search = I('search');
        $content = I('content');

        $sL = M('supplier');

        switch ($content) {

            case('supplier_name'):   //按供应商名字搜索
                $condition['supplier_name'] = array('like', "%{$content}%");
                $sLresult = $sL->where($condition)->select();
                break;
            case(''):  //获取全部供应商
                $sLresult = $sL->select();
                break;

        }

        //$sLresult = $sL->where($condition)->select();
        $sLcount = $sLresult->count();
        if ($sLcount == 0) {

            $this->error('您所查询的供应商不存在，请重试....');
        }

        //每页10个
        $divide = 10;

        //偏移量$page ,页数*每页显示的记录条数
        $page = (I('page') - 1) * $divide;

        $sData['page'] = I('page');
        $sData['total'] = $sLcount;
        $sData['list'] = $sLresult->field('supplier_id,supplier_name')->limit($page, $divide)->order('supplier_id asc')->select();

        $this->ajaxReturn($sData);

    }


    /**
     * 在订单界面，确定供应商之后，列表显示该供应商可供采购的商品信息
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showSupplierProList()
    {

        // if(!IS_AJAX)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $map['supplier_id'] = session('supplier_id');
        $search = I('search');
        $content = I('content');

        $sL = D('SupplierProductView')->where($map)->select();

        switch ($search) {

            case('product_name'):   //按商品名字搜索
                $condition['product_name'] = array('like', "%{$content}%");
                break;
            case(''):  //获取全部供应商
                $condition['supplier_id'] = $sL['supplier_id'];
                break;

        }

        $sLresult = $sL->where($condition)->select();
        $sLcount = $sLresult->count();
        if ($sLcount == 0) {

            $this->error('您所查询的商品不存在，请重试....');
        }

        //每页10个
        $divide = 10;

        //偏移量$page ,页数*每页显示的记录条数
        $page = (I('page') - 1) * $divide;

        $sData['page'] = I('page');
        $sData['total'] = $sLcount;
        $sData['list'] = $sLresult->field('supplier_id', true)->limit($page, $divide)->order('product_id asc')->select();

        $this->ajaxReturn($sData);

    }


    /**
     * 为采购订单选择入库仓库
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showWareHouse()
    {

        // if(!IS_AJAX)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $search = I('search');
        $content = I('content');

        $sL = M('warehouse');

        switch ($search) {

            case('warehouse_number'):   //按仓库名字搜索
                $condition['warehouse_number'] = array('like', "%{$content}%");
                $sLresult = $sL->where($condition)->select();
                break;
            case(''):  //获取全部仓库
                $sLresult = $sL->select();
                break;

        }

        //$sLresult = $sL->where($condition)->select();
        $sLcount = $sLresult->count();
        if ($sLcount == 0) {

            $this->error('您所查询的供应商不存在，请重试....');
        }

        //每页10个
        $divide = 10;

        //偏移量$page ,页数*每页显示的记录条数
        $page = (I('page') - 1) * $divide;

        $sData['page'] = I('page');
        $sData['total'] = $sLcount;
        $sData['list'] = $sLresult->field('warehouse_address', true)->limit($page, $divide)->order('warehouse_id asc')->select();

        $this->ajaxReturn($sData);
    }


    /**
     * 查询订单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */

    public function searchOrder()
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


        $map['order_id'] = session('order_id');
        $sOD = D('DealOrderView');

        $divide = 15;
        $page = (I('page') - 1) * $divide;

        $sData['page'] = I('page');
        $sData['tatal'] = $sOD->count();
        $sData['list'] = $sOD->where($map)->field('*')->limit($page, $divide)->order('orderdetail_id asc')->select();

        $this->ajaxReturn($sData);
    }


    /**
     * 在订单中，为某一个商品选择入库仓库
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    /* public function showWareHouse(){

         // if(!IS_AJAX)
         //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

         $search = I('search');
         $content =I('content');

         $aO = M('warehouse');

         switch ($search){

             case('warehouse_number'):   //按仓库名字搜索
                 $condition['warehouse_number'] = array('like',"%{$content}%");
                 break;
             case(''):  //获取全部仓库名字
                 $condition['warehouse_id'] = $aO['warehouse_id'];
                 break;

         }

         $aOresult = $aO->where($condition)->select();
         $aOcount = $aOresult->count();
         if ($aOcount == 0){

             $this->error('您所查询的仓库不存在，请重试....');
         }

         //每页10个
         $divide = 10;

         //偏移量$page ,页数*每页显示的记录条数
         $page = (I('page')-1) * $divide;

         $aData['page'] = I('page');
         $aData['total'] = $aOcount;
         $aData['list'] = $aOresult->field('warehouse_id,warehouse_nUMBER')->limit($page,$divide)->order('warehouse_id asc')->select();

         $this->ajaxReturn($aData);


     }*/


    /**
     * 新增订单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function addOrder()
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


        $aO = D('AddOrderView');

        $sP = M('supplierproduct');
        $map['supplier_id'] = session('supplier_id');
        $map['product_id'] = session('product_id');
        $sPtemp = $sP->where($map)->select();


        $aData = array(

            'product_id' => session('product_id'),
            'warehouse_id' => session('warehouse_id'),
            //TODO 将一个变量的值付给另一个变量的方法是否正确？
            'supplierproduct_id' => $sPtemp['supplierproduct_id'],

            'count' => session('count'),
            'purchaser_id' => session('orderuser_id'),
            'value' => session('value'),
            'sumvalue' => session('sumvalue'),

        );

        /* 选择一个随机的方案 */
        mt_srand((double)microtime() * 1000000);
        //生成订单号
        $rCInfo['order_number'] = 'TOAL' . date('Ymd') . str_pad(mt_rand(1, 99999), 4, '0', STR_PAD_LEFT);
        $rCInfo['order_date'] = date('Y-m-d', time());
        $rCInfo['order_state'] = 0;
        $rC->add($rCInfo);

        if ($rC->where($rCInfo)->find()) {

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {

            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }


    }


    /**
     * 删除订单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    /* public function deleteOrder(){

     }*/
}

?>
