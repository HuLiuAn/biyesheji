/**
 * Created by E440 on 2016/3/13.
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
        link: function ($scope,el,attr) {  //el是jquery的$,$('#heh')
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
            //console.log($scope.orderMemu);

        }
    }
});