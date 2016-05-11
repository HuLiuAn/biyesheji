<?php
namespace Home\Controller;

use Think\Controller;

class StaffController extends Controller
{

    /**
     * 验证码图片生成函数
     * @access public
     * @param void
     * @return void
     *
     * author：shli
     * date:2016.4.8
     */
    function verifyCode()
    {

        $config = array(
            'fontSize' => 15,          // 验证码字体大小
            'length' => 4,           // 验证码位数
            'useNoise' => True,        // 关闭验证码杂点
            'codeSet' => '0123456789',// 设置验证码字符为纯数字
            'imageW' => 120,         //验证码宽度
            'imageH' => 35,          //验证码高度
            'useImgBg' => true,        //验证码背景图片

        );
        $verify = new \Think\Verify($config);

        $verify->entry();
    }



    /**
     * 验证码验证函数，供javascript文件中异步或同步调用
     * @access public
     * @param void
     * @return void
     *
     * author：shli
     * date:2016.4.8
     */
    /* function checkVerifyCode(){

        // if(!IS_AJAX)
            // E("页面不存在");     //防止URL直接访问，开发阶段可关闭

         $verify = new \Think\Verify();
         $result = $verify->check(I('verifyCode','','trim'));
         if($result)
             $this->ajaxReturn(1);
         else
             $this->ajaxReturn(0);

     }*/


    /**
     * 检测用户是否登录
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.8
     */
    public function checkLogin()
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

        //检查用户是否登录
        if (session('?user_id')) {
            //返回信息
            $st = session();
            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {
            //提示错误
            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }
    }


    /**
     * 用户登录
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.8
     */
    public function login()
    {


        //if(!IS_AJAX)
        //   E("页面不存在");     //防止URL直接访问，开发阶段可关闭

        // $map1['user_number']   = I('usernumber');
        //$map2['user_password'] = I('password');


        $map['user_number'] = I('usernumber');
        $map['user_password'] = I('password');

        $user = M('user');

        //$result1 = $user->where($map1)->find();
        //$result2 = $user->where($map2)->find();

        $result = $user->where($map)->find();
        if (($result['user_number'] and $result['user_password']) == 0) {
            $st['session_id'] = "0";;
            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st));
        }

        /*if ($result1['user_number'] != $map1['user_number']){

            //工号错误
            $st = array ('status'=>0);
            $this->ajaxReturn (json_encode($st),'JSON');

        }else if ($result2['user_password']!= $map2['user_password']){

            //密码错误
            $st = array ('status'=>1);
            $this->ajaxReturn (json_encode($st),'JSON');
        }*/


        // if($result['user_password'] != $map['user_password'] ){
        //   //密码错误
        // $st = array ('status'=>1);
        //echo $map['user_password'];
        //$this->ajaxReturn (json_encode($st),'JSON');
        // }

        /* $verify = I('verify','');
         if(!check_verify($verify)){

             //验证码错误
             $st = array ('status'=>2);
             $this->ajaxReturn (json_encode($st),'JSON');
             }
              */

        //$user = M('User');
        //$result = $user->where($map)->find();

        //$result = $user->where($map1 AND $map2)->find();


        if ($result) {

            $time = date("Y-m-d H:i:s", time());
            //Session不能少
            session('user_id', $result['user_id']);
            session('user_name', $result['user_name']);
            session('user_department', $result['user_department']);
            session('user_role', $result['user_role']);
            session('user_lastlogintime', $result['user_lastlogintime']);

            $st['user_id'] = $result['user_id'];
            $st['user_name'] = $result['user_name'];
            $st['user_department'] = $result['user_department'];
            $st['user_role'] = $result['user_role'];
            //  $user['user_lastlogintime'] = $result['user_lastlogintime'];//$user变量已经用过
            // $user['user_role'] = $result['user_role'];

            $user->where($map)->setField('user_lastlogintime', $time);
            $st['session_id'] = session_id();
            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st));
        } else {
            $st['status'] = "0";
            $st['session_id'] = "0";;
            $this->ajaxReturn(json_encode($st));
        }

    }


    /**
     * 用户登出(主要是清除session数据）
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.8
     */
    public function logout()
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

        session_unset();
        session_destroy();
        //$this->success("您已退出登录",T('static://login'));    //退出后跳转至登录页
        $this->success(T('static://login'));
    }


    /**
     * 显示用户详细信息
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.8
     */

    public function showUserDetail()
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

        $map['user_id'] = session('user_id');
        //$userInfo=M('User')->where($map)->find();
        //TODO password要去掉，再返回给用户,不要用select，select返回的是多条数据，相当于数组。find是返回一条数据。
        $userInfo = M('user')->where($map)->field('user_id,user_password', true)->find();
        $this->ajaxReturn(json_encode($userInfo), 'JSON');
        //$this->assign('userInfo',$userInfo);
        //$this->display('userDetail');

    }


    /**
     * 修改用户密码
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */

    public function modifyPassword()
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

        $user = M('user');
        // if(!IS_AJAX)
        //E("页面不存在");     //防止URL直接访问，开发阶段可关闭

        $st['status'] = "0";

        $map['user_id'] = session('user_id');
        $map['user_password'] = $arr->old;
        $data['user_password'] = $arr->new;
        //$new['user_password'] = I('newpassword','','md5');

        $temp = $user->where($map)->find();
        if (!$temp) {
            $this->ajaxReturn(json_encode($st), 'JSON');
        }
        $final = preg_match('#[!#$%^&*(){}~`"\";:?+=<>/\[\]]+#', $arr->new) ? 0 : 1;
        //$final = $user->where($map)->save($data);

        if ($final) {
            $st['status'] = "1";
            $user->where($map)->save($data);
            $this->ajaxReturn(json_encode($st), 'JSON');
        }

        $this->ajaxReturn(json_encode($st), 'JSON');
    }


    /**
     * 用户忘记密码时用于设置新的用户密码
     * 调用短信运营商接口，发送短信验证码
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */

    public function getNewPassword()
    {
        // if(!IS_AJAX)
        // E("页面不存在");     //防止URL直接访问，开发阶段可关闭


    }


    /**
     * 打开修改个人用户信息界面，
     * 只有手机号码一项可以修改
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */


    public function showModifyUserInfo()
    {

        //   if(!IS_AJAX)
        //  E("页面不存在");     //防止URL直接访问，开发阶段可关闭

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

        $map['user_id'] = session('user_id');
        $user = M('user');
        $userInfoTemp = $user->where($map)->find();
        $userInfo['user_phone'] = $userInfoTemp['user_phone'];

        $this->assign('userInfo', $userInfo);
        $this->display('Staff/modifyUserInfo');

    }


    /**
     * 修改个人用户信息
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */

    public function modifyUserInfo()
    {


        //TODO 这里要接收用户手机号码，通过session判断是哪个用户，然后更新数据，返回更新状态 {status:0/1}

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
        $user = M('user');

        //使用ThinkPHP的自动验证方法
        //if(!$user->validate($rules)>create()){

        //  $st = array ('status'=>0);
        //$this->ajaxReturn (json_encode($st),'JSON');
        //}


        $map['user_id'] = session('user_id');
        $data['user_phone'] = $arr->user_phone;

        $final = preg_match('/^(13|15|18)(\d{9})|^6(\d{4,5})$/', $arr->user_phone) ? 1 : 0;
        //$final = $user->where($map)->save($data);
        $st['status'] = "1";
        if ($final == 0) {
            $st['status'] = "0";
            $this->ajaxReturn(json_encode($st), 'JSON');
        } else {

            $user->where($map)->save($data);
            $this->ajaxReturn(json_encode($st), 'JSON');
        }

    }


    /**
     * 展示商品列表
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    public function showProductList()
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

        $sL = D("ProductListView");

        $sPData['page'] = $arr->page;

        if (!empty($arr->barcode) || !empty($arr->name)) {

            $map['product_name'] = array('like', "%" . $arr->name . "%");
            $map['product_barcode'] = array('like', "%" . $arr->barcode . "%");
            $gData['total'] = $sL->where($map)->count();
            $gData['list'] = $sL->where($map)->limit($page, $divide)->order("product_id asc")->select();

        } else {

            //如果商品的库存为0，则不计入记录数
            $gData['total'] = M('inventory')->where('count')->count();
            $gData['list'] = $sL->where('count')->field('*')->limit($page, $divide)->order("product_id asc")->select();

        }
        $photo = M('photo');
        foreach ($gData['list'] as &$vi) {
            $s = json_decode($vi['photo']);
            $pmap['id'] = $s[0];
            $re = $photo->where($pmap)->find();
            $vi['product_photo'] = '.' . $re['image'];
        }
        $this->ajaxReturn($gData);
    }


    /**
     * 展示商品详情
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */
    public function showProductDetail()
    {

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

        // $get['product_name'] = I('product_name');
        //$get['warehouse_number'] = I('warehouse_number');

        $get['product_id'] = $arr->product_id;
//        $pD = D('ProductDetailView');

        $pD = D('ProductListView');
        $proInfo['status'] = "0";
        $proInfo['result'] = $pD->where($get)->find();


        if ($proInfo['result'] ) {
            $proInfo['status'] = "1";
            if ($proInfo['result']['photo'] ) {
                $image['id'] = array('in', json_decode($proInfo['result']['photo']));
                $proInfo['result']['photogroup'] = M('photo')->where($image)->select();
            }
            $this->ajaxReturn($proInfo);
        }
        $this->ajaxReturn($proInfo);

    }


    /**
     * 添加商品到领取单
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.26
     */
    public function addProToReceiveOrder()
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

        $st['status'] = "0";

        $rO = M('receiveorder');
        // $rOD = M('receiveorderdetail');


        /* 选择一个随机的方案 */
        mt_srand((double)microtime() * 1000000);
        //生成订单号
        $rCInfo['receiveorder_number'] = 'TROL' . date('Ymd') . str_pad(mt_rand(1, 99999), 4, '0', STR_PAD_LEFT);
        $rCInfo['receiveorder_date'] = date('Y-m-d', time());
        $rCInfo['receiveorder_state'] = 0;
        $rCInfo['receiveorder_time'] = time();
        $rCInfo['receiveuser_id'] = session('user_id');      //$arr->user_id;
        $rCInfo['product_id'] = $arr->product_id;
        $rCInfo['warehouse_id'] = $arr->warehouse_id;
        $rCInfo['receiveproduct_count'] = $arr->amount;

        if ($rO->data($rCInfo)->add()) {
            $st['status'] = "1";
            $this->ajaxReturn(json_encode($st), 'JSON');
        }
        $this->ajaxReturn(json_encode($st), 'JSON');


    }


    /**
     * 搜索领取单
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

        //$sPData['status'] = "0";

        $map['receiveuser_id'] = session('user_id');

        if (!empty($arr->receiveorder_number)) {
            $map['receiveorder_number'] = array('like', "%" . $arr->receiveorder_number . "%");
        }
        if (!empty($arr->start_time) && !empty($arr->end_time)) {
            $map['receiveorder_time'] = array(array('gt', strtotime($arr->start_time)), array('lt', strtotime($arr->end_time) + 3600 * 24 - 1));
        } else if (!empty($arr->start_time)) {
            $map['receiveorder_time'] = array('gt', strtotime($arr->start_time));
        } else if (!empty($arr->end_time)) {
            $map['receiveorder_time'] = array('lt', strtotime($arr->end_time) + 3600 * 24 - 1);
        }
        if (!empty($arr->state)) {

            $map['receiveorder_state'] = $arr->state;
        }
        if (!empty($map)) {
            //只要有一个搜索条件，就选择搜索模式
            $sPData["total"] = $sP->join(' __USER__ USER1 ON USER1.user_id = __RECEIVEORDER__.receiveuser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __RECEIVEORDER__.auditor_id', 'LEFT')
                ->join(' __PRODUCT__  ON __PRODUCT__.product_id = __RECEIVEORDER__.product_id', 'LEFT')->count();
            $sPData['list'] = $sP->join(' __USER__ USER1 ON USER1.user_id = __RECEIVEORDER__.receiveuser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __RECEIVEORDER__.auditor_id', 'LEFT')
                ->join(' __PRODUCT__  ON __PRODUCT__.product_id = __RECEIVEORDER__.product_id', 'LEFT')
                ->field('tb_receiveorder.*,tb_product.*, USER1.user_name as receiveuser_name,USER2.user_name as auditor_name')
                ->where($map)
                ->select();
            $sPData["total"] = $sP->where($map)->count();
            //$sPData['status'] = "1";
            $sPData['list'] = $sP->where($map)->limit($page, $divide)->order("receiveorder_id asc")->select();
        } else {
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->join(' __USER__ USER1 ON USER1.user_id = __RECEIVEORDER__.receiveuser_id', 'LEFT')
                ->join(' __USER__ USER2 ON USER2.user_id = __RECEIVEORDER__.auditor_id', 'LEFT')
                ->join(' __PRODUCT__  ON __PRODUCT__.product_id = __RECEIVEORDER__.product_id', 'LEFT')
                ->field('tb_receiveorder.*,tb_product.*, USER1.user_name as receiveuser_name,USER2.user_name as auditor_name')
                ->select();
            $sPData["total"] = $sP->count();
            $sPData['list'] = $sP->limit($page, $divide)->order("receiveorder_id asc")->select();
        }

        $photo = M('photo');
        foreach ($sPData['list'] as &$vi) {
            $s = json_decode($vi['photo']);
            $pmap['id'] = $s[0];
            $re = $photo->where($pmap)->find();
            $vi['product_photo'] = '.' . $re['image'];
        }
        $this->ajaxReturn($sPData);

    }



    /**
     * 编辑领取单：只能编辑未经审核的领取单
     * 暂时不实现
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */
    /*public function editReceiveOrder()
    {





    /**
     * 删除领取单:只能删除未经审核的领取单
     * 0:待审核
     * 1：审核通过
     * 2：审核不通过
     * 暂时不做这个功能，
     * 如果用户想取消领取单，
     * 私下联系审核员，
     * 更改状态为未通过审核
     * @access public
     * @param void
     * @return void
     *
     * author: shli
     * date: 2016.04.12
     */


    /* public function deleteReceiveOrder()
   {

       $get['receiveorder_id'] = session('receiveorder_id');

       $temp = M('receiveorder');

       $state = $temp->where($get)->find();

       //只能删除未经审核的领取单
       if ($state['receiveorder_state'] == 0) {

           $temp->where($get)->delete();
           $st = array('status' => 1);
           $this->ajaxReturn(json_encode($st), 'JSON');

       }
   }*/


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
        $rOD = M('receiveorder');


        $sData = $rOD->where($map)->find();

        $this->ajaxReturn($sData);
    }


}


?>