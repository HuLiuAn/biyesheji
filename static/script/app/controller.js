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

    $scope.hehe = "sdfs"
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
    //console.log($scope.orderMemu1);

});
app.controller('homeCtrl', function ($scope) {
    $scope.info = [{
        name: '订单',
        href: 'orderApply',
        icon: "ion-bag",
        background: "bg-aqua"
    }, {
        name: '供应商',
        href: 'orderApply',
        icon: "ion-person",
        background: "bg-maroon"
    }, {
        name: '商品',
        href: 'orderApply',
        icon: "ion-tshirt",
        background: "bg-yellow"
    }, {
        name: '报表',
        href: 'orderApply',
        icon: "ion-pie-graph",
        background: "bg-blue"
    }, {
        name: '仓库',
        href: 'orderApply',
        icon: "ion-stats-bars",
        background: "bg-green"
    }, {
        name: '采购',
        href: 'orderApply',
        icon: "ion-android-cart",
        background: "bg-teal"
    }];


});
app.controller('goodListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodCartCtrl', function ($scope) {

    $scope.cartlist = {
        0: {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        1: {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        2: {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        3: {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
    };
    $scope.add = function (index) {
        $scope.cartlist[index].amount++;
    };
    $scope.del = function (index) {
        delete   $scope.cartlist[index];
    };
    $scope.minus = function (index) {
        var amount = --$scope.cartlist[index].amount;
        if (amount < 1) {
            $scope.del(index);
        }
    };
    $scope.submit = function () {
        //提交
    }
});
app.controller('goodHistoryCtrl', function ($scope) {
    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;
    });
    $scope.cartlist = [
        {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
        ,
        {
            name: "apple",
            icon: "style/img/user7-128x128.jpg",
            description: "  26\" Mongoose Dolomite Men\'s 7-speed, Navy Blue.",
            amount: 10
        }
    ];
});
app.controller('goodDetailCtrl', function ($scope) {
    $scope.addToCart = function () {
        console.log('假如购物车')
    };
    $scope.data = {
        pictures: [],
        description: "这是商品描述",
        barcode: "132421432153312432421",
        specify: [],
        properties: {}
    };
    $scope.pro={
        a:{
            title:"名称",
            value:"apple"
        },
        b:{
            title:"大小",
            value:"10KG 20KG 30KG"
        },c:{
            title:"大范德萨",
            value:"apple"
        },
        d:{
            title:"宿舍",
            value:"apple"
        },
        e:{
            title:"地方",
            value:"阿凡达放大阿凡达三分"
        },
        f:{
            title:"那天",
            value:"发的发放打三分大赛分"
        }
    };

    $scope.add = function () {
      if($scope.data.amount){
          $scope.data.amount++;
      }else{
          $scope.data.amount=1;
      }
    };
    $scope.minus = function () {
        if($scope.data.amount){
            $scope.data.amount--;
        }else{
            $scope.data.amount=0;
        }
    };
    //图片滚动
    $scope.myInterval = 1000;
    $scope.noWrapSlides = false;
    $scope.active = 0;
    var slides = $scope.slides = [];
    var currIndex = 0;

    $scope.addSlide = function () {
        var newWidth = 600 + slides.length + 1;
        slides.push({
            image: 'http://lorempixel.com/' + newWidth + '/300',
            text: ['Nice image', 'Awesome photograph', 'That is so cool', 'I love that'][slides.length % 4],
            id: currIndex++
        });
    };

    $scope.randomize = function () {
        var indexes = generateIndexesArray();
        assignNewIndexesToSlides(indexes);
    };

    for (var i = 0; i < 4; i++) {
        $scope.addSlide();
    }

    // Randomize logic below

    function assignNewIndexesToSlides(indexes) {
        for (var i = 0, l = slides.length; i < l; i++) {
            slides[i].id = indexes.pop();
        }
    }

    function generateIndexesArray() {
        var indexes = [];
        for (var i = 0; i < currIndex; ++i) {
            indexes[i] = i;
        }
        return shuffle(indexes);
    }

    // http://stackoverflow.com/questions/962802#962890
    function shuffle(array) {
        var tmp, current, top = array.length;

        if (top) {
            while (--top) {
                current = Math.floor(Math.random() * (top + 1));
                tmp = array[current];
                array[current] = array[top];
                array[top] = tmp;
            }
        }

        return array;
    }
});
app.controller('goodHisDetailCtrl', function ($scope) {

});

app.controller('goodManageListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodManageDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodManageNewCtrl', function ($scope) {

});

app.controller('goodProviderListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodProviderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodProviderNewCtrl', function ($scope) {

});

app.controller('goodOrderListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodOrderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodOrderNewCtrl', function ($scope) {

});


app.controller('goodHubListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodHubDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodHubNewCtrl', function ($scope) {

});

app.controller('goodInoutListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodInoutDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodInoutNewCtrl', function ($scope) {

});


app.controller('goodCheckOrderListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodCheckOrderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});

app.controller('goodCheckGoodListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});
app.controller('goodCheckGoodDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});

