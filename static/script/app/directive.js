/**
 * Created by huminghui on 2016/3/13.
 */
app.directive('bsSider', function ($rootScope, $location, $http, $Bs_API) {
        //永远都会返回一个对象
        var supermenu = {
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
                    name: '修改密码',
                    href: 'user/change'
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
                    //}, {
                    //    name: '领取清单',
                    //    href: 'good/cart'
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
            provider: {
                name: '供应商',
                href: 'provider/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '供应商列表',
                    href: 'provider/list/1'
                }, {
                    name: '新增供应商',
                    href: 'provider/new'
                }]
            },
            order: {
                name: '订单管理',
                href: 'order/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '采购',
                    href: 'order/new/select_supplier'
                }, {
                    name: '订单查询',
                    href: 'order/list/1'
                }]
            },
            //chart: {
            //    name: '报表管理',
            //    href: 'work/mine/vm/1',
            //    icon: 'fa fa-table',
            //    base: "order",
            //    subMenu: [{
            //        name: '新增订单',
            //        href: 'orderApply'
            //    }, {
            //        name: '入库订单'
            //        //href: '/orderApply'
            //    }, {
            //        name: '购货订单'
            //        //href: '/orderApply'
            //    }, {
            //        name: '退货订单'
            //        //href: '/orderApply'
            //    }]
            //},
            hub: {
                name: '仓库管理',
                href: 'hub/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '新增仓库',
                    href: 'hub/new'
                }, {
                    name: '仓库列表',
                    href: 'hub/list/1'
                }]
            },
            inout: {
                name: '调拨管理',
                href: 'inout/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '仓库调拨',
                    href: 'inout/new'
                }, {
                    name: '查看调拨单',
                    href: 'inout/list/1'
                }]
            },
            check: {
                name: '审核',
                href: 'check/order/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '采购订单',
                    href: 'check/order/1'
                }, {
                    name: '领取单',
                    href: 'check/good/1'
                }]
            }
        };
        var staffmenu = {
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
                    name: '修改密码',
                    href: 'user/change'
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
                    //}, {
                    //    name: '领取清单',
                    //    href: 'good/cart'
                }, {
                    name: '领取记录',
                    href: 'good/history/1'
                }]
            }
        };
        var purchasemenu = {
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
                    name: '修改密码',
                    href: 'user/change'
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
                    //}, {
                    //    name: '领取清单',
                    //    href: 'good/cart'
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
            provider: {
                name: '供应商',
                href: 'provider/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '供应商列表',
                    href: 'provider/list/1'
                }, {
                    name: '新增供应商',
                    href: 'provider/new'
                }]
            },
            order: {
                name: '订单管理',
                href: 'order/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '采购',
                    href: 'order/new/select_supplier'
                }, {
                    name: '订单查询',
                    href: 'order/list/1'
                }]
            },
        };
        var warehousemenu = {
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
                    name: '修改密码',
                    href: 'user/change'
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
                    //}, {
                    //    name: '领取清单',
                    //    href: 'good/cart'
                }, {
                    name: '领取记录',
                    href: 'good/history/1'
                }]
            },
            hub: {
                name: '仓库管理',
                href: 'hub/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '新增仓库',
                    href: 'hub/new'
                }, {
                    name: '仓库列表',
                    href: 'hub/list/1'
                }]
            },
            inout: {
                name: '调拨管理',
                href: 'inout/list/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '仓库调拨',
                    href: 'inout/new'
                }, {
                    name: '查看调拨单',
                    href: 'inout/list/1'
                }]
            },
            check: {
                name: '审核',
                href: 'check/order/1',
                icon: 'fa fa-table',
                base: "order",
                subMenu: [{
                    name: '采购订单',
                    href: 'check/order/1'
                }, {
                    name: '领取单',
                    href: 'check/good/1'
                }]
            }
        };
        var qqq = $http.get('../index.php/Home/Staff/checkLogin');
        var s = [
            '超级管理员', '管理员', '采购员', '员工'
        ];
        return {
            //定义，这个指令是什么，元素？类？注释？属性？,用restrict
            restrict: "E",
            //模版，template,templateUrl
            //template:"<div>sdafdsafdsa</div>"
            templateUrl: "views/template/sider.html",
            scope: {},//定义scope,把作用域隔离开
            //那我作用域的函数，逻辑什么的，放哪里,放link，类似controller:区别，link无法注入服务,link参数是固定，4个参数
            link: function ($scope, el, attr) { //el是jquery的$,$('#heh')
                qqq.success(function (data) {
                    console.log(data);
                    try {
                        var user = JSON.parse(data);
                        if (user && user.status == 1) {
                            $rootScope.USERLOGIN = JSON.parse(data);
                            //console.log( $rootScope.USERLOGIN )
                            switch ($rootScope.USERLOGIN.user_role) {
                                case "0":
                                    $scope.menu = supermenu;
                                    break;
                                case "1":
                                    $scope.menu = staffmenu;
                                    break;
                                case "2":
                                    $scope.menu = purchasemenu;
                                    break;
                                case "3":
                                    $scope.menu = warehousemenu;
                                    break;
                                default:

                            }
                        } else {
                            alert('尚未登陆，请重新登陆！');
                            window.location = 'login.html';
                        }
                    }
                    catch (e) {
                        alert('抱歉，目前系统维护中！');
                        window.location = 'login.html';
                    }

                }).error(function () {
                    alert('网络错误，请重新登陆！');
                    window.location = 'login.html';
                });
                $scope.menu =  supermenu;;
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
    }
)
;
app.directive('bsPagination', function ($stateParams, $location, $state, $Bs_List, $Bs_API) {

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
                $Bs_API.loading('网络错误', 1);
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
app.directive('bsUpload', function ($Bs_API) {
    //永远都会返回一个对象

    return {
        //定义，这个指令是什么，元素？类？注释？属性？,用restrict
        restrict: "E",
        template: '<p><input type="file" name="upload" /><a href="" class="btn btn-danger" ng-click="del()">删除</a><a href="" class="btn btn-warning" ng-click="back()">还原</a></p>',
        scope: {
            image: "="
        },
        link: function ($scope, el, attr) { //el是jquery的$,$('#heh')
            var up = el.find('input[name=upload]');
            var time = new Date().getTime().toString();
            up.attr('id', time);
            var image = $scope.image;
            $scope.name = attr['name'];
            up.uploadify({
                height: 100,
                multi: false,
                buttonImage: image,// 'style/img/photo4.jpg',
                swf: 'plugins/upload/uploadify.swf',
                uploader: $Bs_API.getApi('upload_picture'),
                onUploadSuccess: onUploadSuccess,
                onUploadError: onUploadError,
                width: 120
            });

            var watch = $scope.$watch('image', function (newValue, oldValue, scope) {
                if (!newValue) {
                    return;
                }
                changeImage(newValue);
                image = newValue;
                watch();
            });
            setTimeout(watch, 5000);

            function onUploadSuccess(file, data, response) {
                $Bs_API.loading('文件' + file.name + '上传成功 ');
                var s = JSON.parse(data);
                var url = image = '.' + s['url'];
                changeImage(image);
                $scope.$emit('FileUploadFinish', s['id']);
            }

            function onUploadError(file, errorCode, errorMsg, errorString) {
                $Bs_API.loading('文件' + file.name + ' 上传失败: ' + errorString, 1);
                //changeImage($scope.image);
            }

            function changeImage(url) {
                var btn = el.find('#' + time + "-button");
                btn.css("background-image", " url('" + url + "')");
            }

            $scope.back = function () {
                changeImage($scope.image);
                $scope.$emit('FileUploadFinish', $scope.image);
            };
            $scope.del = function () {
                changeImage('default.jpg');
                $scope.$emit('FileUploadFinish', 'default.jpg');
            }
        }
    }
});
app.directive('bsBarcode', function () {
    return {
        restrict: "E",
        template: '<div></div> ',
        scope: {
            code: "="
        },
        link: function ($scope, el, attr) { //el是jquery的$,$('#heh')
            var div = el.children('div');
            var watch = $scope.$watch('code', function (newValue, oldValue, scope) {
                if (!newValue) {
                    return;
                }
                div.barcode(newValue, "ean13");//如果没有成功，则是newValue长度不够
                watch();
            });
            setTimeout(watch, 5000);

        }
    }
});
app.directive('bsSearch', function ($state) {
    return {
        restrict: "E",
        replace: true,
        template: '<div class="box-tools" style="width:400px;"> <div class="input-group input-group-sm" > <span class="input-group-addon" ng-if="hasSearch"> 当前搜索：<a href="" ng-repeat="(key,value) in searchParams" ng-click="noSearch(key)">{{value+";"}}</a> </span> <input  id="typeahead" type="text" ng-model="data.search" placeholder="search" class="form-control " uib-typeahead="address for address in getLocation($viewValue)" typeahead-template-url="{{typeaheadtemplate}}" typeahead-loading="loadingLocations" typeahead-on-select="searchSelected($item)" typeahead-no-results="noResults" class="form-control"> <div class="input-group-btn"> <button type="submit" name="submit" ng-click="search()" class="btn btn-warning btn-flat"> <i class="fa fa-search"></i> </button> </div> </div> </div> ',
        link: function ($scope, el, attr) { //el是jquery的$,$('#heh')

            if (attr.template) {
                $scope.typeaheadtemplate = attr.template;
            } else {
                $scope.typeaheadtemplate = "uib/template/typeahead/typeahead-match.html";
            }

            $scope.data = {};
            $scope.search = function () {
                //console.log('click search');
                $scope.$broadcast('PageWillChange', $scope.data);
            };


            var field;
            var value;
            if (attr.search) {
                var sss = attr.search.split(':');
                field = sss[0];
                value = sss[1];
            }

            //获取字段的值
            var params = $state.params;
            $scope.searchParams = {};
            for (var i in params) {
                if (i != 'page' && params[i]) {
                    $scope.hasSearch = true;
                    $scope.searchParams[i] = params[i];
                }
            }

            $scope.noSearch = function (f) {
                $scope.data[f] = "";
                $scope.search();
            };
            $scope.searchSelected = function ($item) {

                if (value) {
                    $scope.data.search = $item[value];
                    $scope.data[$item[field]] = $item[value];
                }
                $scope.search();
            };
            $scope.getLocation = function (val) {
                if (value) {
                    for (var ii in $scope.searchField) {
                        $scope.searchField[ii][value] = val;
                    }
                }
                return $scope.searchField;
            };
        }
    }
});
app.directive('bsCount', function ($state) {
    return {

        restrict: "E",
        scope: {
            bsvalue: "="
        },
        template: '  <a ng-click="minus()" style="height: 26px;width: 10px; margin: 0;"  ' +
        '  class="btn btn-smamll btn-default">-</a>     ' +
        '   <input type="text"    style="width: 60px;"  ' +
        '  data-max="4980" class="amountInput"   ' +
        ' ' +
        '    ng-model="bsvalue" ' +
        '   autocomplete="off">    ' +
        '    <a ng-click="add()" style="height: 26px;width: 10px; margin: 0;"    ' +
        'class="btn btn-smamll btn-default">+</a>'
        ,
        link: function ($scope, el, attr) {
            //$scope.value = {};
            $scope.add = function (index) {
                if (!$scope.bsvalue) {
                    $scope.bsvalue = 1;
                    return;
                }
                $scope.bsvalue++;
            };
            $scope.minus = function (index) {
                if (!$scope.bsvaluet) {
                    $scope.bsvalue = 0;
                    return;
                }

                var amount = --$scope.bsvalue
                if (amount < 1) {
                    $scope.bsvalue = 0;
                }
            };
        }
    }

});

app.directive('bsNotspace', function ($state) {
    return {

        restrict: "A",
        link: function ($scope, el, attr) {
            el.on('keydown', function (e) {
                if (e.keyCode == 32) {
                    return false;
                }
            })
        }
    }

});
