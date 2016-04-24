var app = angular.module('myApp', ['ui.router']);
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
            controller:'menuCtrl'
        })
        .state('main.orderApply', {
            url: 'orderApply',
            templateUrl: 'views/orderApply.html'
            //controller:'menuCtrl'
        }).state('main.user-info', {
            url: 'user/info',
            templateUrl: 'views/user/info.html',
            controller: function ($scope, $http) {
                //获取用户信息
                $http.get('user/info').success(function (data) {
                    //var use
                    $scope.user = data;
                }).error(function (data) {
                    $scope.user = {
                        name: '获取失败',
                        phone: '获取失败',
                        type: '未知'
                    }
                });
                $scope.changeKey = function () {
                    console.log('changeKey');
                    $http.post('user/changekey',{
                        old:'XX',
                        new:"ddd"
                    }).success(function (data) {

                    }).error(function (data) {

                    });
                }
                $scope.changeInfo = function () {
                    console.log('changeInfo');
                }
            }
        });
    $urlRouterProvider.otherwise('/')
}]);

app.controller('loginCtrl', function ($scope, $http) {
    $scope.id = "";
    $scope.password = "";
    //this code providing a feature that we
    $scope.data = $scope;
    $scope.submit = function () {
        console.log($scope.account);
        console.log($scope.key);
    };
    //'/getUser'
    var obj = $http.get('/serv/hehe.json');
    obj.success(function (data) {
        console.log(data);
    }).error(function (data) {
        console.log("失败了")

    });
});
app.controller('menuCtrl', function ($scope) {
    $scope.orderMemu = [{
        name: '新增订单',
        href: 'orderApply'
    }, {
        name: '入库订单'
        //href: '/orderApply'
    }, {
        name: '购货订单'
        //href: '/orderApply'
    }, {
        name: '退货订单'
        //href: '/orderApply'
    }];

    $scope.hehe="sdfs"
    $scope.orderMemu1 = [{
        name: '新增订单',
        href: 'orderApply'
    }, {
        name: '入库订单'
        //href: '/orderApply'
    }, {
        name: '购货订单'
        //href: '/orderApply'
    }, {
        name: '退货订单'
        //href: '/orderApply'
    }];
    //提交新增订单
    //$scope.data = $scope;
    $scope.addOrder = function () {
        console.log($scope.productType);
        console.log($scope.productName);
        console.log($scope.productPrice);
        console.log($scope.productQuantity);
        //console.log($scope.productSupplier);
    };
    console.log($scope.orderMemu1);

});




