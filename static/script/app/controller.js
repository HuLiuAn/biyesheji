/**
 * Created by huminghui on 2016/4/24.
 */
app.controller('loginCtrl', function ($scope, $http) {
    $scope.id = "";
    $scope.password = "";
    //this code providing a feature that we
    $scope.data = $scope;
    $scope.submit = function () {
        ////console.log($scope.account);
        ////console.log($scope.key);
    };
    //'/getUser'
    var obj = $http.get('/serv/hehe.json');
    obj.success(function (data) {
        ////console.log(data);
    }).error(function (data) {
        ////console.log("失败了")

    });
});
app.controller('menuCtrl', function ($scope) {

});
app.controller('homeCtrl', function ($scope) {
    $scope.info = [{
        name: '订单',
        href: 'order/list/1',
        icon: "ion-bag",
        background: "bg-aqua"
    }, {
        name: '供应商',
        href: 'provider/list/1',
        icon: "ion-person",
        background: "bg-maroon"
    }, {
        name: '商品',
        href: 'good/list/1',
        icon: "ion-tshirt",
        background: "bg-yellow"
    }, {
        name: '报表',
        href: 'orderApply',
        icon: "ion-pie-graph",
        background: "bg-blue"
    }, {
        name: '仓库',
        href: 'hub/list/1',
        icon: "ion-stats-bars",
        background: "bg-green"
    }, {
        name: '采购',
        href: 'order/new',
        icon: "ion-android-cart",
        background: "bg-teal"
    }];


});
app.controller('goodListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "名称",
        field: 'name',
        value: ''
    }, {
        flag: "条形码",
        field: 'barcode',
        value: ''
    }];
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
app.controller('goodHistoryCtrl', function ($scope, $state) {
    $scope.$on('PageLoaded', function (e, data) {
        $scope.cartlist = data;
    });
    $scope.stateText = [
        "等待审核", "审核通过", "审核不通过"
    ];
    $scope.stateColor = [
        "label-info", "label-success", "label-danger"
    ];
    $scope.radioModel = $state.params.state;
    $scope.select = function () {
        $scope.$broadcast('PageWillChange', {
            state: $scope.radioModel
        });
    }
});
app.controller('goodDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.addToCart = function () {
        if ($scope.data.count && $scope.data.amount > $scope.data.count) {
            $Bs_API.loading('余量不足,领取失败', 1);
            return;
        }
        if (!parseInt($scope.data.amount)) {
            $Bs_API.loading('请输入领取数量', 1);
            return;
        }
        $http.post($Bs_API.getApi('add_to_cart'), {
            "product_id": $state.params.id,
            "amount": parseInt($scope.data.amount)
        }).success(function (data) {
            $Bs_API.loading('领取成功');
        }).error(function () {
            $Bs_API.loading('领取失败,请检查网络', 1);
        });
    };
    $http.get($Bs_API.getApi('receive_product_detail')).success(function (data) {
        $scope.data = data;
        rollPic(data.product_photogroup);
    }).error(function () {
        $Bs_API.loading('获取失败！请检查网络', 1);
    });

    $scope.pro = {
        a: {
            title: "名称",
            value: "apple"
        },
        b: {
            title: "大小",
            value: "10KG 20KG 30KG"
        }, c: {
            title: "大范德萨",
            value: "apple"
        },
        d: {
            title: "宿舍",
            value: "apple"
        },
        e: {
            title: "地方",
            value: "阿凡达放大阿凡达三分"
        },
        f: {
            title: "那天",
            value: "发的发放打三分大赛分"
        }
    };
    $scope.add = function () {
        if ($scope.data.amount) {
            if ($scope.data.count && $scope.data.amount < $scope.data.count) {
                $scope.data.amount++;
            }
        } else {
            $scope.data.amount = 1;
        }
    };
    $scope.minus = function () {
        if ($scope.data.amount) {
            $scope.data.amount--;
        } else {
            $scope.data.amount = 0;
        }
    };
    //图片滚动
    $scope.myInterval = 1000;
    $scope.noWrapSlides = false;
    $scope.active = 0;
    var slides = $scope.slides = [];

    $scope.addSlide = function (url, index) {
        var newWidth = 600 + slides.length + 1;
        slides.push({
            image: url,
            text: '',
            id: index
        });
    };

    $scope.randomize = function () {
        var indexes = generateIndexesArray();
        assignNewIndexesToSlides(indexes);
    };

    // Randomize logic below
    function rollPic(arr) {
        if (arr) {
            for (var i = 0; i < arr.length; i++) {
                $scope.addSlide(arr[i], i);
            }
        }
    }

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
app.controller('goodHisDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    $http.get($Bs_API.getApi('receive_detail')).success(function (data) {
        $scope.data = data;
    }).error(function () {
        $Bs_API.loading('获取失败！请检查网络', 1);
    });
    $scope.stateText = [
        "等待审核", "审核通过", "审核不通过"
    ];
    $scope.stateColor = [
        "label-info", "label-success", "label-danger"
    ];
});

app.controller('goodManageListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        console.log(data);
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "名称",
        field: 'name',
        value: ''
    }, {
        flag: "条形码",
        field: 'barcode',
        value: ''
    }];
});
app.controller('goodManageDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.images = [];
    $scope.image = '';
    $scope.data = {};
    $http.post($Bs_API.getApi('product_detail'), {product_id: $state.params.id || "0"}).success(function (data) {
        data = JSON.parse(data);
        data.product_photogroup = JSON.parse(data.product_photogroup) || [];
        data.product_barcode = parseInt(data.product_barcode);
        if (!data.status) {
            $Bs_API.loading("获取失败", 1);
        } else {
            for (var i = data.product_photogroup.length; i < 6; i++) {
                data.product_photogroup[i] = "";
            }
            $scope.data = data;
            $scope.images = data.product_photogroup;
            $scope.image = data.product_photo;
        }

    }).error(function () {
        $Bs_API.loading('获取失败！请检查网络', 1);
    });

    var Upload = {};
    $scope.$on('FileUploadFinish', function (e, msg) {
        Upload[e.targetScope.name] = msg;
    });
    $scope.submit = function () {
        var photogroup = [];
        var len = 6;
        var temp;
        for (var i = 0; i < len; i++) {
            temp = "images['" + i + "']";
            if (Upload[temp]) {
                photogroup[i] = Upload[temp];
            } else {
                photogroup[i] = $scope.data.product_photogroup[i];
            }
        }
        $scope.data.product_photogroup = photogroup;

        if (Upload['image']) {
            $scope.data.product_photo = Upload['image'];
        }

        $http.post($Bs_API.getApi('new_product'), $scope.data).success(function () {
            $Bs_API.loading('成功');
            $state.go('main.good-manage-list', {page: 1});
        }).error(function () {
            $Bs_API.loading('添加失败', 1);
        });
    }
    $scope.edit = function () {
        $scope.isEdit = true;
    };
    $scope.cancel = function () {
        $scope.isEdit = false;
    }
});
app.controller('goodManageNewCtrl', function ($scope, $http, $Bs_API, $state) {

    $scope.images = [];
    $scope.image = '';//'style/img/photo4.jpg';
    $scope.data = {};

    var Upload = {};
    $scope.$on('FileUploadFinish', function (e, msg) {
        Upload[e.targetScope.name] = msg;
    });
    $scope.submit = function () {
        $scope.data.product_photogroup = [];
        var len = 6;
        var temp;
        for (var i = 0; i < len; i++) {
            temp = "images['" + i + "']";
            if (Upload[temp]) {
                $scope.data.product_photogroup.push(Upload[temp]);
            }
        }
        if (Upload['image']) {
            $scope.data.product_photo = Upload['image'];
        } else {
            if ($scope.data.product_photogroup.length > 0) {
                $scope.data.product_photo = $scope.data.product_photogroup[0];
            }
        }
        $http.post($Bs_API.getApi('new_product'), $scope.data).success(function () {
            $Bs_API.loading('成功');
            $state.go('main.good-manage-list', {page: 1});
        }).error(function () {
            $Bs_API.loading('添加失败', 1);
        });
    }
});

app.controller('goodProviderListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });

});
app.controller('goodProviderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
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

});
app.controller('goodOrderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
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

});
app.controller('goodHubDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
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

});
app.controller('goodInoutDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
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

});
app.controller('goodCheckOrderDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
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
});
app.controller('goodCheckGoodDetailCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.data = {};
    $scope.search = function () {
        ////console.log('click search')
        $scope.$broadcast('PageWillChange', $scope.data);
    };

    $scope.getLocation = function (val) {
        return ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Dakota', 'North Carolina', 'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming']
    };
});

