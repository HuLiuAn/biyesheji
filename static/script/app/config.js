/**
 * Created by huminghui on 2016/4/24.
 */
var app = angular.module('myApp', ['ui.router']);
app.config(['$stateProvider', '$urlRouterProvider', function ($stateProvider, $urlRouterProvider) {
    //������ַ

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
                //��ȡ�û���Ϣ
                $http.get('user/info').success(function (data) {
                    //var use
                    $scope.user = data;
                }).error(function (data) {
                    $scope.user = {
                        name: '��ȡʧ��',
                        phone: '��ȡʧ��',
                        type: 'δ֪'
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
        }) .state('main.home', {
            url: 'home',
            templateUrl: 'views/home.html'
        }) .state('main.good-list', {
            url: 'good/list',
            templateUrl: 'views/good/list.html'
        });
    $urlRouterProvider.otherwise('/')
}]);
