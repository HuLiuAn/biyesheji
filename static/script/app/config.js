/**
 * Created by huminghui on 2016/4/24.
 */
//接口配置
angular.module('bs.api', []).factory('$Bs_API', function () {

    var listUrl = {
        good: {
            list: 'serv/goodlist'
        }

    };
    var base = "../index.php/Home/";
    var API = {
        logout: "sds",//退出
        change_key: base + "Staff/modifyPassword",//修改密码
        change_info: base + "Staff/modifyUserInfo",//修改信息
        get_info: base + "Staff/showUserDetail",//获取个人信息,
        receive_product_list: base + "Staff/showProductList",
        receive_product_detail: base + "Staff/showProductDetail",
        add_to_cart: base + "Staff/addProToReceiveOrder",
        receive_list: base + 'Staff/queryReceiveOrder',
        receive_detail: base + "Staff/showReceiveOrderDetail",
        "product-manage-list": base + "Purchase/searchProduct",
        new_product: base + "Purchase/addProduct",
        product_detail: base + "Purchase/showProductDetail",
        upload_picture: base + "Upload/picture",
        new_supplier: base + "Purchase/addSupplier",
        get_product_by_name: base + "Purchase/getAllProductList",
        supplier_list: base + "Purchase/searchSupplier",
        edit_supplier: base + "Purchase/editSupplier",
        detail_supplier: base + "Purchase/showSupplierDetail",
        order_supplier_list: base + "Purchase/getAllSupplierList",
        order_product_list: base + "Purchase/getProductListBySupplierId",
        order_hub_list: base + "Purchase/showWareHouse",
        order_list: base + "Purchase/searchOrder",
        order_detail: base + "Purchase/showOrderDetail",
        new_order: base + "Purchase/addOrder",
        new_hub: base + "WareHouse/addWareHouse",
        hub_list: base + "WareHouse/queryWareHouse",
        edit_hub: base + "WareHouse/modifyWareHouse",
        new_allo: base + "WareHouse/addAllocate",
        get_all_warehouse: base + "WareHouse/getAllWareHouseList",
        allo_list: base + "WareHouseManagement/queryAllocationList",
        allo_detail: base + "WareHouseManagement/showAllocationDetail",
        get_ware_capacity: base + "WareHouse/allocateProduct",
        man_order_list: base + "WareHouseManagement/queryOrderList",
        man_order_history: base + "WareHouseManagement/queryOrderListOfMine",
        man_order_detail: base + "WareHouseManagement/showOrderDetail",
        do_review: base + "WareHouseManagement/review",
        man_receive_list: base + "WareHouseManagement/queryReceiveOrder",
        man_receive_detail: base + "WareHouseManagement/showReceiveOrderDetail",
        get_all_ware: base + "Purchase/getAllWareHouseList"

    };
    var _$Bs_API = {
        getUrl: function (index) {
            //index= 'work.vm.pending'
            var s = index.split('.');
            var result = listUrl;
            for (var i = 0; i < s.length; i++) {
                result = result[s[i]];//逐层解析
            }
            return result;
        },
        concat: function (baseUrl, param) {
            var url = baseUrl;
            for (var i in param) {
                if (!/\?/.test(url)) {
                    url = url + '?' + i + "=" + param[i];
                } else {
                    url = url + '&' + i + "=" + param[i];
                }
            }
            return url;
        },
        getApi: function (name) {
            return API[name];
        },
        loading: loading
    };


    return _$Bs_API;

    //信息提示
    function loading(msg, type, time) {
        $('#loading-info').show();
        var content = $('#loading-content');
        if (!time || time < 500) {
            time = 1000;
        } else {

        }

        if (type) {
            content.addClass('loading-error');
            content.removeClass('loading-success');
        } else {
            content.removeClass('loading-error');
            content.addClass('loading-success');
        }
        content.text(msg);
        setTimeout(function () {
            $('#loading-info').hide();
        }, time)
    }
});
var app = angular.module('myApp', ['bs.api', 'ui.router', 'ui.bootstrap']);
//检查登陆信息
//app.run(function ($rootScope, $location, $http,$Bs_API) {
//    $http.get('../index.php/Home/Staff/checkLogin').success(function (data) {
//        console.log(data);
//        try {
//            var user = JSON.parse(data);
//            if (user && user.status == 1) {
//                $rootScope.USERLOGIN = JSON.parse(data);
//            } else {
//                alert('尚未登陆，请重新登陆！');
//                window.location = 'login.html';
//            }
//        }
//        catch (e) {
//            alert('抱歉，目前系统维护中！');
//            window.location = 'login.html';
//        }
//
//    }).error(function () {
//        alert('网络错误，请重新登陆！');
//        window.location = 'login.html';
//    })
//});
app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    //配置网址

    $stateProvider.state('login', {
            url: '/login',
            templateUrl: '/views/login.html',
            controller: 'loginCtrl'
        })
        .state('main', {
            url: '/',
            templateUrl: 'views/main.html',
            controller: 'menuCtrl'
        })
        .state('main.orderApply', {
            url: 'orderApply',
            templateUrl: 'views/orderApply.html'
            //controller:'menuCtrl'
        }).state('main.user-info', {
        url: 'user/info',
        templateUrl: 'views/user/info.html',
        controller: function ($scope, $http, $Bs_API, $rootScope, $state) {
            //获取用户信息
            //$scope.user = {
            //    user_id: $rootScope.USERLOGIN.user_id,
            //    user_name: $rootScope.USERLOGIN.user_name
            //};
            $scope.role = [
                '超级管理员', '管理员', '采购员', '员工'
            ];
            $http.get($Bs_API.getApi('get_info')).success(function (data) {
                //var use

                try {
                    $scope.user = JSON.parse(data);
                    $scope.info = JSON.parse(data);


                } catch (e) {
                    toastr.error('抱歉，目前系统维护中！', 1);
                }
            }).error(function (data) {
                toastr.error('网络错误，信息获取失败！', 1);
            });
            $scope.editToggle = function () {
                $scope.edit = !$scope.edit;
                if ($scope.edit) {
                    $scope.info = extend($scope.user);
                }

            };

            $scope.save = function () {
                if(!/^(13[0-9]|14[0-9]|15[0-9]|18[0-9])\d{8}$/i.test($scope.info.user_phone)){
                    toastr.error('请输入正确的手机号码！');
                    return;
                }
                $http.post($Bs_API.getApi('change_info'), $scope.info).success(function (data) {
                    //var use

                    try {
                        var final = JSON.parse(data);
                        if (final && final.status == 1) {
                            toastr.success('修改成功');
                            $state.go('main.user-info');
                            $scope.user = extend($scope.info);
                        } else {
                            toastr.error('修改失败！', 1);
                        }

                    }
                    catch (e) {
                        toastr.error('抱歉，目前系统维护中！');
                    }

                }).error(function (data) {
                    toastr.error('网络错误，信息获取失败！');
                });
                $scope.editToggle();
            };

            function extend(data) {
                var cp = {};
                for (var i in data) {
                    cp[i] = data[i];
                }
                return cp;
            }
        }
    }).state('main.user-change', {
        url: 'user/change',
        templateUrl: 'views/user/change.html',
        controller: function ($scope, $http, $Bs_API, $state) {
            //获取用户信息
            $scope.key = {};

            $scope.changeKey = function () {

                if (!validation()) {
                    toastr.error('两次新密码不一致');
                    return;
                }

                $http.post($Bs_API.getApi('change_key'), {
                    old: $scope.key.old,
                    new: $scope.key.new1
                }).success(function (data) {
                    try {
                        var final = JSON.parse(data);
                        if (final && final.status == 1) {
                           toastr.success('修改成功');
                            $state.go('main.user-info');
                        } else {
                            toastr.error('修改失败！');
                        }

                    }
                    catch (e) {
                        toastr.error('抱歉，目前系统维护中！');
                    }

                }).error(function (data) {
                    toastr.error('修改失败');
                });
            };


            function validation() {
                return ($scope.key.new1 && $scope.key.new2 && $scope.key.new1 == $scope.key.new2);
            }
        }
    }).state('main.home', {
        url: 'home',
        templateUrl: 'views/home.html',
        controller: 'homeCtrl'
    }).
    //商品领取
    state('main.re-product-list', {
        url: 'good/list/:page?barcode&name',
        templateUrl: 'views/good/list.html',
        controller: 'goodListCtrl',
        Handler: "receive_product_list"
    }).state('main.good-cart', {
        url: 'good/cart',
        templateUrl: 'views/good/cart.html',
        controller: 'goodCartCtrl'
    }).state('main.good-his', {
        url: 'good/history/:page?number&timestart&timeend&auditor&state',
        templateUrl: 'views/good/history.html',
        controller: 'goodHistoryCtrl',
        Handler: "receive_list"
    }).state('main.good-detail', {
        url: 'good/detail/:id',
        templateUrl: 'views/good/detail.html',
        controller: 'goodDetailCtrl'
    }).state('main.good-his-detail', {
        url: 'good/history/detail/:id',
        templateUrl: 'views/good/history-detail.html',
        controller: 'goodHisDetailCtrl'
    }).
    //商品管理
    state('main.good-manage-list', {
        url: 'good-manage/list/:page?barcode&name',
        templateUrl: 'views/goodmanage/list.html',
        controller: 'goodManageListCtrl',
        Handler: "product-manage-list"
    }).state('main.good-manage-detail', {
        url: 'good-manage/detail/:id',
        templateUrl: 'views/goodmanage/detail.html',
        controller: 'goodManageDetailCtrl'
    }).state('main.good-manage-new', {
        url: 'good-manage/new',
        templateUrl: 'views/goodmanage/new.html',
        controller: 'goodManageNewCtrl'
    }).
    //供应商管理
    state('main.provider-list', {
        url: 'provider/list/:page?name&contact&phone',
        templateUrl: 'views/provider/list.html',
        controller: 'goodProviderListCtrl',
        Handler: "supplier_list"
    }).state('main.provider-detail', {
        url: 'provider/detail/:id',
        templateUrl: 'views/provider/detail.html',
        controller: 'goodProviderDetailCtrl'
    }).state('main.provider-new', {
        url: 'provider/new',
        templateUrl: 'views/provider/new.html',
        controller: 'goodProviderNewCtrl'
    }).
    //订单管理
    state('main.order-list', {
        url: 'order/list/:page?order_number&start_time&end_time&purchaser_name&auditor_name&order_state',
        templateUrl: 'views/order/list.html',
        controller: 'goodOrderListCtrl',
        Handler: "order_list"
    }).state('main.order-detail', {
        url: 'order/detail/:id',
        templateUrl: 'views/order/detail.html',
        controller: 'goodOrderDetailCtrl'
    }).state('main.order-new', {
        url: 'order/new',
        templateUrl: 'views/order/new.html',
        controller: function ($scope) {
            $scope.formData = {};
        }
    }).
        state('main.order-new.profile', {
            url: '/select_supplier?id&name',
            templateUrl: 'views/order/select_supplier.html',
            controller: function ($scope, $http, $Bs_API, $state) {

                if ($state.params.id && $state.params.name) {
                    $scope.formData.supplier = $scope.supplier = {
                        supplier_id: $state.params.id,
                        supplier_name: $state.params.name
                    }
                } else {
                    $scope.formData.supplier = $scope.supplier = {};
                }
                $scope.next1 = function () {
                    if (!$scope.supplier.supplier_id) {
                        toastr.error("没有这个供应商");
                        return;
                    }
                    $state.go('main.order-new.interests', $scope.supplier);
                };

                $scope.getSupplier = function (val) {
                    return $http.get($Bs_API.getApi('order_supplier_list'), {
                        params: {
                            name: val
                        }
                    }).then(function (response) {
                        //console.log(response);
                        return response.data['list'].map(function (item) {
                            return item.supplier_id + "," + item.supplier_name
                        });
                    });
                };
                $scope.selected = function ($item, $model, $label, $event) {
                    var s = $scope.supplier.supplier_name.split(',');
                    $scope.supplier.supplier_name = s[1];
                    $scope.supplier.supplier_id = s[0];
                };
            }
        })

        // url will be /form/interests
        .state('main.order-new.interests', {
            url: '/select_product/:supplier_id/:supplier_name',
            templateUrl: 'views/order/select_product.html',
            controller: function ($scope, $http, $Bs_API, $state) {
                if ($state.params.supplier_id && $state.params.supplier_name) {
                    $scope.formData.supplier = $state.params;
                    $scope.state = {
                        id: $state.params.supplier_id,
                        name: $state.params.supplier_name
                    };
                    $http.post($Bs_API.getApi('order_product_list'), {
                        supplier_id: $scope.state.id
                    }).success(function (data) {
                        if (!data.status) {
                            toastr.error("获取失败");
                        } else {
                            if (data.list.length < 1) {
                                toastr.error("该供应商无商品");
                            } else {
                                $scope.list = data.list;
                            }
                        }
                    }).error(function () {
                        toastr.error('加载失败');
                    })
                } else {
                    toastr.error('请先选择供应商', 1)
                    $state.go('main.order-new.profile');
                }
                $scope.next2 = function () {
                    var selectproduct = [];
                    var total = 0;
                    var amount = 0;
                    for (var i in $scope.list) {
                        if ($scope.list[i].check) {
                            selectproduct.push($scope.list[i]);
                            amount += $scope.list[i].amount || 0;
                            total += parseFloat($scope.list[i].amount) * parseFloat($scope.list[i].supplierproduct_price);
                        }
                    }

                    $scope.formData.product = selectproduct;
                    $scope.formData.supplier.total = total;
                    if (selectproduct.length == 0) {
                        toastr.error('请先选择商品', 1)
                        return;
                    }
                    if (amount == 0) {
                        toastr.error('请输入商品数量', 1)
                        return;
                    }
                    $scope.state.data = JSON.stringify($scope.formData);
                    $state.go('main.order-new.payment', $scope.state);
                }
            }
        })

        // url will be /form/payment
        .state('main.order-new.payment', {
            url: '/order_detail/:id/:name?data',
            templateUrl: 'views/order/order_detail.html',
            controller: function ($scope, $state, $Bs_API, $http) {
                $scope.state = {
                    id: $state.params.id || $scope.formData.supplier_id,
                    name: $state.params.name || $scope.formData.supplier_name
                };
                if ($state.params.data) {
                    $scope.form = JSON.parse($state.params.data);
                } else if ($scope.formData) {
                    $scope.form = $scope.formData;
                } else {
                    toastr.error('数据已过期');
                    $state.go('main.order-new.payment', $scope.state);
                }

                $scope.submit = function () {
                    $http.post($Bs_API.getApi('new_order'), $scope.form).success(function (data) {
                        if(data.status==1){
                            toastr.success('成功');
                            $state.go('main.order-list', {page: 1});
                        }else {
                            toastr.error('添加失败');
                        }
                    }).error(function () {
                        toastr.error('添加失败');
                    });
                };
                $http.get($Bs_API.getApi('get_all_ware')
                ).success(function (data) {
                    if (!data.status) {
                        toastr.error("无法获取仓库");
                    } else {
                        if (data.list.length < 1) {
                            toastr.error("无法获取仓库");
                        } else {
                            $scope.list = data.list;
                        }
                    }
                }).error(function () {
                    toastr.error("无法获取仓库");
                })
            }
        }).


    //仓库管理
    state('main.hub-list', {
        url: 'hub/list/:page?number&address',
        templateUrl: 'views/hub/list.html',
        controller: 'goodHubListCtrl',
        Handler: "hub_list"
    }).state('main.hub-detail', {
        url: 'hub/detail/:id',
        templateUrl: 'views/hub/detail.html',
        controller: 'goodHubDetailCtrl'
    }).state('main.hub-new', {
        url: 'hub/new',
        templateUrl: 'views/hub/new.html',
        controller: 'goodHubNewCtrl'
    }). //挑拨管理
    state('main.inout-list', {
        url: 'inout/list/:page?outwarehouse_number&start_time&end_time&inwarehouse_number&allocate_number',
        templateUrl: 'views/inout/list.html',
        controller: 'goodInoutListCtrl',
        Handler: "allo_list"
    }).state('main.inout-detail', {
        url: 'inout/detail/:id',
        templateUrl: 'views/inout/detail.html',
        controller: 'goodInoutDetailCtrl'
    }).state('main.inout-new', {
        url: 'inout/new',
        templateUrl: 'views/inout/new.html',
        controller: 'goodInoutNewCtrl'
    }). //审核管理
    state('main.check-order', {
        url: 'check/order/:page?order_number&start_time&end_time&purchaser_name&auditor_name&order_state',
        templateUrl: 'views/check/order.html',
        controller: 'goodCheckOrderListCtrl',
        Handler: "man_order_list"
    }). state('main.check-order-mine', {
        url: 'check/order-mine/:page?order_number&start_time&end_time&purchaser_name&auditor_name&order_state',
        templateUrl: 'views/check/order-mine.html',
        controller: 'goodCheckOrderListCtrl',
        Handler: "man_order_history"
    }).state('main.check-good', {
        url: 'check/good/:page?order_number&start_time&end_time&purchaser_name&auditor_name&order_state',
        templateUrl: 'views/check/good.html',
        controller: 'goodCheckGoodListCtrl',
        Handler: "man_receive_list"
    }).state('main.check-order-detail', {
        url: 'check/order-detail/:id',
        templateUrl: 'views/check/order-detail.html',
        controller: 'goodCheckOrderDetailCtrl'
    }).state('main.check-good-detail', {
        url: 'check/good-detail/:id',
        templateUrl: 'views/check/good-detail.html',
        controller: 'goodCheckGoodDetailCtrl'
    });
    $urlRouterProvider.otherwise('/home')
}]);

//投影幕
app.run(function ($rootScope, $location) {
    $rootScope.$on('$stateChangeStart',
        function (event, toState, toParams, fromState, fromParams, options) {
            Pace.restart();
        });
});


app.filter('timeformat', function () {
    return function (input) {
        if (typeof input == "string") {
            return input;
        }
        var nowTime = new Date().getTime() / 1000;//当前时间戳
        var result = nowTime - input;//计算时间差
        //console.log(result);
        //计算出相差天数
        var days = Math.floor(result / (24 * 3600));
        if (days < 1) {
            //计算天数后剩余的毫秒数,计算出小时数
            var leave1 = result % (24 * 3600 );
            var hours = Math.floor(leave1 / 3600);
            if (hours < 1) {
                //计算小时数后剩余的毫秒数,计算相差分钟数
                var leave2 = leave1 % 3600;
                var minutes = Math.floor(leave2 / 60);
                if (minutes < 1) {
                    return "less one min ago";
                }
                return minutes + "mins ago";
            }
            return hours + "hours ago";

        }
        return days + "days ago";
    };

});

