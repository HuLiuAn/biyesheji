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
        $data = array(

            'supplier_name' => I('name'),
            'supplier_contact' => I('contact'),
            'supplier_phone' => I('phone', '/^(13|15|18)(\d{9})|^6(\d{4,5})$/', 3),
            'supplier_address' => I('address'),
        );

        if ($supplier->data($data)->add()) {

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

        $data = array(
            'product_name' => I('product_name'),
            'product_barcode' => I('product_barcode'),
            'product_photogroup' => I('product_photogroup'),
            'product_photo' => I('product_photo'),
            'properties' => I('product_properties'),

        );

        $product = M('product');


        //添加商品成功
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
        if (empty($page)) {
            //没有页数，默认显示第一页
            $page = 0;
        }

        $sP = M('product');
        $sPData['page'] = $arr->page;
        if (!empty($arr->barcode) || !empty($arr->name)) {
            //只要有一个搜索条件，就选择搜索模式
            $map['product_barcode'] = array('like', "%".$arr->barcode."%");
            $map['product_name'] = array('like', "%".$arr->name."%");
            $sPData["total"] = $pCount = $sP->where($map)->count();
            $sPData['list'] = $sP->where($map)->Field('product_id', 'product_name', 'product_photo', 'properties')->limit($page, $divide)->order("product_id asc")->select();

        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->Field('product_id', 'product_name', 'product_photo', 'properties')->limit($page, $divide)->order("product_id asc")->select();

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

        // if(!IS_POST)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭
        //$page = I('page');

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

        $sP = M('supplier');

        switch ($search) {

            case ('name'):  //按名字搜索
                $condition['supplier_name'] = array('like', "%{$content}%");
                $sPresult = $sP->where($condition)->select();
                break;
            case ('contact'):  //按联系人搜索
                $condition['supplier_contact'] = array('like', "%{$content}%");
                $sPresult = $sP->where($condition)->select();
                break;
            case ('phone'):  //按联系人电话搜索
                $condition['supplier_phone'] = array('like', "%{$content}%");
                $sPresult = $sP->where($condition)->select();
                break;
            case (''):  //匹配所有供应商信息
                $sPresult = $sP->select();
                break;
        }

        //$sPresult = $sP->where($condition)->select();
        $sPcount = $sPresult->count();
        if ($sPcount == 0) {

            $this->error('您所查询的供应商不存在，请重试....');
        }

        //每页10个
        $divide = 10;
        //查询偏移量$page, 页数*每页显示的数量
        $page = (I("page") - 1) * $divide;
        //表格


        $sPData['page'] = I('page');
        $sPData['list'] = $sPresult->field('*')->limit($page, $divide)->order("product_id asc")->select();
        $sPData["total"] = $sPcount;
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

        $map = session('supplier_id');
        $sP = D('SupplierProductView');

        $sPresult = $sP->where($map)->select();

        $sPcount = $sPresult->count();

        //每页10个
        $divide = 10;
        //查询偏移量$page, 页数*每页显示的数量
        $page = (I("page") - 1) * $divide;
        //表格


        $sPData['page'] = I('page');
        $sPData['list'] = $sPresult->field('product_id,product_barcode', true)->limit($page, $divide)->order("product_id asc")->select();
        $sPData["total"] = $sPcount;
        $this->ajaxReturn($sPData);
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

        $data = array(

            'supplier_name' => I('supplier_name'),
            'supplier_contact' => I('supplier_contact'),
            'supplier_phone' => I('supplier_phone'),
            'supplier_address' => I('supplier_address')
        );

        $map['supplier_id'] = session('supplier_id');
        $map['product_id'] = session('product_id');

        $sD = D('SupplierDetailView');
        $sDedit = $sD->where($map)->find();

        $result = $sDedit->save($data);
        if ($result == $sDedit->save($data)) {

            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {

            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }

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
    public function queryOrder()
    {

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
