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
    var API = {
        logout: "sds",//退出
        change_key: "../index.php/Home/Staff/modifyPassword",//修改密码
        change_info: "../index.php/Home/Staff/modifyUserInfo",//修改信息
        get_info: "../index.php/Home/Staff/showUserDetail",//获取个人信息,
        receive_product_list: "../index.php/Home/Staff/showProductList",
        receive_product_detail: "../index.php/Home/Staff/showProductDetail",
        add_to_cart: "../index.php/Home/Staff/addProToReceiveOrder",
        receive_list: '../index.php/Home/Staff/queryReceiveOrder',
        receive_detail: "../index.php/Home/Staff/showReceiveOrderDetail",
        "product-manage-list": "serv/baseproductlist.json",
        new_product: "serv",
        product_detail: "serv/baseproduct.json",
        upload_picture:"../index.php/Home/Upload/picture"
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
app.run(function ($rootScope, $location, $http) {
    $http.get('../index.php/Home/Staff/checkLogin').success(function (data) {
        console.log(data);
        try
        {
            var user = JSON.parse(data);
            if (user && user.status == 1) {
                $rootScope.USERLOGIN = JSON.parse(data);
            } else {
                alert('尚未登陆，请重新登陆！');
                window.location = 'login.html';
            }
        }
        catch (e)
        {
            alert('抱歉，目前系统维护中！');
            window.location = 'login.html';
        }

    }).error(function () {
        alert('网络错误，请重新登陆！');
        window.location = 'login.html';
    })
});
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
            controller: function ($scope, $http, $Bs_API, $rootScope) {
                //获取用户信息
                $scope.user = {
                    user_id: $rootScope.USERLOGIN.user_id,
                    user_name: $rootScope.USERLOGIN.user_name
                };
                $scope.role = [
                    '超级管理员', '管理员', '采购员', '员工'
                ];
                $http.get($Bs_API.getApi('get_info')).success(function (data) {
                    //var use
                    $scope.user = JSON.parse(data)
                    $scope.info = JSON.parse(data);
                }).error(function (data) {
                    $Bs_API.loading('网络错误，信息获取失败！', 1);
                });
                $scope.editToggle = function () {
                    $scope.edit = !$scope.edit;
                    if ($scope.edit) {
                        $scope.info = extend($scope.user);
                    }

                };

                $scope.save = function () {
                    $http.post($Bs_API.getApi('change_info'), $scope.info).success(function (data) {
                        //var use
                        $scope.user = extend($scope.info);
                    }).error(function (data) {

                    });
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
            controller: function ($scope, $http, $Bs_API) {
                //获取用户信息
                $scope.key = {};

                $scope.changeKey = function () {

                    if (!validation()) {
                        console.log('密码不一致')
                        return;
                    }

                    $http.post($Bs_API.getApi('change_key'), {
                        old: 'XX',
                        new: "ddd"
                    }).success(function (data) {

                    }).error(function (data) {

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
            url: 'good/history/:page?state',
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
            url: 'provider/list/:page?search',
            templateUrl: 'views/provider/list.html',
            controller: 'goodProviderListCtrl',
            Handler: "receive_list"
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
            url: 'order/list/:page?search',
            templateUrl: 'views/order/list.html',
            controller: 'goodOrderListCtrl',
            Handler: "receive_list"
        }).state('main.order-detail', {
            url: 'order/detail/:id',
            templateUrl: 'views/order/detail.html',
            controller: 'goodOrderDetailCtrl'
        }).state('main.order-new', {
            url: 'order/new',
            templateUrl: 'views/order/new.html',
            controller: 'goodOrderNewCtrl'
        }). //仓库管理
        state('main.hub-list', {
            url: 'hub/list/:page?search',
            templateUrl: 'views/hub/list.html',
            controller: 'goodHubListCtrl',
            Handler: "receive_list"
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
            url: 'inout/list/:page?search',
            templateUrl: 'views/inout/list.html',
            controller: 'goodInoutListCtrl',
            Handler: "receive_list"
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
            url: 'check/order/:page?search',
            templateUrl: 'views/check/order.html',
            controller: 'goodCheckOrderListCtrl',
            Handler: "receive_list"
        }).state('main.check-good', {
            url: 'check/good/:page?search',
            templateUrl: 'views/check/good.html',
            controller: 'goodCheckGoodListCtrl',
            Handler: "receive_list"
        }).state('main.check-order-detail', {
            url: 'check/order-detail/:id',
            templateUrl: 'views/check/order-detail.html',
            controller: 'goodCheckOrderDetailCtrl'
        }).state('main.check-good-detail', {
            url: 'check/good-detail/:id',
            templateUrl: 'views/check/good.html',
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