/**
 * Created by huminghui on 2016/4/24.
 */
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
        console.log("ʧ����")

    });
});
app.controller('menuCtrl', function ($scope) {
    $scope.orderMemu = [{
        name: '��������',
        href: 'orderApply'
    }, {
        name: '��ⶩ��'
        //href: '/orderApply'
    }, {
        name: '��������'
        //href: '/orderApply'
    }, {
        name: '�˻�����'
        //href: '/orderApply'
    }];

    $scope.hehe="sdfs"
    $scope.orderMemu1 = [{
        name: '��������',
        href: 'orderApply'
    }, {
        name: '��ⶩ��'
        //href: '/orderApply'
    }, {
        name: '��������'
        //href: '/orderApply'
    }, {
        name: '�˻�����'
        //href: '/orderApply'
    }];
    //�ύ��������
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