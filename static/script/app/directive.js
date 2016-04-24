/**
 * Created by huminghui  on 2016/3/13.
 */
app.directive('bsSider', function () {
    //永远都会返回一个对象

    return {
        //定义，这个指令是什么，元素？类？注释？属性？,用restrict
        restrict: "E",
        //模版，template,templateUrl
        //template:"<div>sdafdsafdsa</div>"
        templateUrl: "views/template/sider.html",
        scope: {},//定义scope,把作用域隔离开
        //那我作用域的函数，逻辑什么的，放哪里,放link，类似controller:区别，link无法注入服务,link参数是固定，4个参数
        link: function ($scope, el, attr) {  //el是jquery的$,$('#heh')

            $scope.menu = {
                home: {
                    name: '主页',
                    href: 'home'
                },
                account: {
                    name: '账户管理',
                    href: 'user/info',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
                        name: '基本信息',
                        href: 'user/info'
                    }, {
                        name: '修改密码'
                        //href: '/orderApply'
                    }]
                },
                good: {
                    name: '领取商品',
                    href: 'good/list/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
                        name: '商品列表',
                        href: 'good/list/1'
                    }, {
                        name: '领取清单',
                        href: 'good/cart'
                    }, {
                        name: '领取记录',
                        href: 'good/history/1'
                    }]
                },
                goodmanager: {
                    name: '商品管理',
                    href: 'good-manage/list/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
                        name: '商品列表',
                        href: 'good-manage/list/1'
                    }, {
                        name: '新增商品',
                        href: 'good-manage/new'
                    }]
                },
                order: {
                    name: '订单管理',
                    href: 'work/mine/vm/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
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
                    }]
                },
                chart: {
                    name: '报表管理',
                    href: 'work/mine/vm/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
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
                    }]
                },
                instore: {
                    name: '入库管理',
                    href: 'work/mine/vm/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
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
                    }]
                },
                outstore: {
                    name: '出库管理',
                    href: 'work/mine/vm/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
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
                    }]
                },
                receive: {
                    name: '领取管理',
                    href: 'work/mine/vm/1',
                    icon: 'fa fa-table',
                    base: "order",
                    subMenu: [{
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
                    }]
                }
            };
            //console.log(el.children('#ddd'));
            //提交新增订单
            $scope.data = $scope;
            $scope.addOrder = function () {
                console.log($scope.productType);
                console.log($scope.productName);
                console.log($scope.productPrice);
                console.log($scope.productQuantity);
                //console.log($scope.productSupplier);
            };
        }
    }
});
app.directive('bsPagination', function ($stateParams, $location, $state, $Bs_List) {

    return {
        restrict: 'E',
        scope: {},
        replace: true,
        template: '<div> <div ng-if="!hasData&&failload" style="text-align: center;vertical-align: middle"> <span style=" line-height: 80px;"> ------------ 网络错误 ----------- </span> </div> <div ng-if="hasData==false&&!failload" style="text-align: center;vertical-align: middle"> <span style=" line-height: 80px;"> ------------当前无数据----------- </span> </div> <uib-pagination ng-show="hasData" total-items="bigTotalItems" ng-model="currentPage" max-size="4" previous-text="<<" next-text=">>" class="pagination-sm pull-right" rotate="false" ng-change="pageChanged()"></uib-pagination> </div>',
        link: function ($scope, attr, el) {
            $scope.currentState = $state.$current.self.name;
            $scope.failload = false;

            //获取查询参数
            $Bs_List.get().then(function (data) {
                //console.log(data);
                $scope.bigTotalItems = data.count;
                $scope.$emit('PageLoaded', data.list);
                $scope.currentPage = $stateParams.page;
                $scope.hasData = data.list.length;
            }, function (data) {
                $scope.hasData = false;
                $scope.failload = true;
            });
            $scope.$on('PageWillChange', function (e, data) {
                var searchdata = data;
                searchdata.page = 1;
                $state.go($scope.currentState, searchdata);
            });
            $scope.pageChanged = function () {
                $state.go($scope.currentState, {page: $scope.currentPage});
            };
            $scope.reload = function () {
                $state.reload();
            };

        }
    };
});
app.directive('bsUpload', function () {
    //永远都会返回一个对象

    return {
        //定义，这个指令是什么，元素？类？注释？属性？,用restrict
        restrict: "E",
        //模版，template,templateUrl
        template: '<p><input type="file" name="upload" id="upload" /><button ng-click="upload()">上传</button></p>',
        //templateUrl: "views/template/sider.html",
        scope: {},//定义scope,把作用域隔离开
        //那我作用域的函数，逻辑什么的，放哪里,放link，类似controller:区别，link无法注入服务,link参数是固定，4个参数
        link: function ($scope, el, attr) {  //el是jquery的$,$('#heh')
           var up= el.children('#upload');
            //console.log(up)
            up.uploadify({
                height: 30,
                'auto': false,
                swf: 'plugins/upload/uploadify.swf',
                uploader: '/uploadify/uploadify.php',
                width: 120
            });
            $scope.upload = function () {
                console.log('upload')
              up.uploadify('upload')
            };
        }
    }
});