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
        }
    };


    return _$Bs_API;
});
var app = angular.module('myApp', ['bs.api', 'ui.router', 'ui.bootstrap']);
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
                    $http.post('user/changekey', {
                        old: 'XX',
                        new: "ddd"
                    }).success(function (data) {

                    }).error(function (data) {

                    });
                };
                $scope.changeInfo = function () {
                    console.log('changeInfo');
                }
            }
        }).state('main.home', {
            url: 'home',
            templateUrl: 'views/home.html',
            controller: 'homeCtrl'
        }).state('main.good-list', {
            url: 'good/list/:page?search',
            templateUrl: 'views/good/list.html',
            controller: 'goodListCtrl',
            Handler: {
                number: 1,
                list: 'good.list'
            }
        }).state('main.good-cart', {
            url: 'good/cart',
            templateUrl: 'views/good/cart.html',
            controller: 'goodCartCtrl'
        }).state('main.good-his', {
            url: 'good/history/:page',
            templateUrl: 'views/good/history.html',
            controller: 'goodHistoryCtrl',
            Handler: {
                number: 1,
                list: 'good.list'
            }
        }).state('main.good-detail', {
            url: 'good/detail/:id',
            templateUrl: 'views/good/detail.html',
            controller: 'goodDetailCtrl'
        }).state('main.good-his-detail', {
            url: 'good/history/detail/:id',
            templateUrl: 'views/good/history-detail.html',
            controller: 'goodHisDetailCtrl'
        });
    $urlRouterProvider.otherwise('/')
}]);
