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
            toastr.error('余量不足,领取失败');
            return;
        }
        if (!parseInt($scope.data.amount)) {
            toastr.error('请输入领取数量');
            return;
        }
        $http.post($Bs_API.getApi('add_to_cart'), {
            "product_id": $state.params.id,
            "amount": parseInt($scope.data.amount)
        }).success(function (data) {
            toastr.success('领取成功');
        }).error(function () {
            toastr.error('领取失败,请检查网络');
        });
    };
    $http.post($Bs_API.getApi('receive_product_detail'), {
        product_id: $state.params.id
    }).success(function (data) {
        if (data.status == 1) {
            $scope.data = data.result;
            rollPic(JSON.parse(data.result.product_photogroup));
            if (data.result.property) {
                builtProperty(JSON.parse(data.result.property));
            }

        } else {
            toastr.error('获取失败');
        }

    }).error(function () {
        toastr.error('获取失败！请检查网络');
    });
    function builtProperty(pro){

    }
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
        toastr.error('获取失败！请检查网络');
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
            toastr.error("获取失败");
        } else {
            for (var i = data.product_photogroup.length; i < 6; i++) {
                data.product_photogroup[i] = "";
            }
            $scope.data = data;
            $scope.images = data.product_photogroup;
            $scope.image = data.product_photo;
        }

    }).error(function () {
        toastr.error('获取失败！请检查网络');
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
            toastr.success('成功');
            $state.go('main.good-manage-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
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
            toastr.success('成功');
            $state.go('main.good-manage-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
        });
    }
});

app.controller('goodProviderListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "名称",
        field: 'name',
        value: ''
    }, {
        flag: "联系人",
        field: 'contact',
        value: ''
    }, {
        flag: "电话",
        field: 'phone',
        value: ''
    }];

});
app.controller('goodProviderDetailCtrl', function ($scope, $Bs_API, $state, $http) {
    var count = 0;
    $http.post($Bs_API.getApi('detail_supplier'), {
        supplier_id: $state.params.id || 0
    }).success(function (data) {
        data = JSON.parse(data);
        if (!data.status) {
            toastr.error("获取失败");
        } else {
            data.supplier_phone = parseInt(data.supplier_phone);
            $scope.products = {};
            count = data.products.length;
            for (var i in data.products) {
                $scope.products[i] = data.products[i];
            }
            delete data.products;
            $scope.supplier = data;
        }

    }).error(function (data) {
        toastr.error('获取失败！请检查网络');
    });
    $scope.product = {};
    $scope.supplier = {};
    $scope.products = {};
    $scope.add = function () {
        var pro = $scope.product;
        if (!pro.product_name || !pro.supplierproduct_price) {
            return;
        }
        $scope.products[count] = pro;
        count++;
        $scope.product = {};
    };
    $scope.del = function (key) {
        delete $scope.products[key];
    };
    $scope.getLocation = function (val) {
        return $http.get($Bs_API.getApi('get_product_by_name'), {
            params: {
                name: val
            }
        }).then(function (response) {
            //console.log(response);
            return response.data['list'].map(function (item) {
                return item.product_id + "," + item.product_name
            });
        });
    };

    $scope.selected = function ($item, $model, $label, $event) {
        var s = $scope.product.product_name.split(',');
        $scope.product.product_name = s[1];
        $scope.product.product_id = s[0];
    };
    $scope.submit = function () {
        //提取ID
        var product = [];
        for (var i in  $scope.products) {
            product.push($scope.products[i]);
        }
        $scope.supplier.product = product;
        $http.post($Bs_API.getApi('edit_supplier'), $scope.supplier).success(function () {
            toastr.success('成功');
            $state.go('main.provider-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
        });
    }
});
app.controller('goodProviderNewCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.product = {};
    $scope.supplier = {};
    $scope.products = {};
    var count = 0;
    $scope.add = function () {
        var pro = $scope.product;
        if (!pro.product_name || !pro.supplierproduct_price) {
            return;
        }
        $scope.products[count] = pro;
        count++;
        $scope.product = {};
    };
    $scope.del = function (key) {
        delete $scope.products[key];
    };
    $scope.getLocation = function (val) {
        return $http.get($Bs_API.getApi('get_product_by_name'), {
            params: {
                name: val
            }
        }).then(function (response) {
            //console.log(response);
            return response.data['list'].map(function (item) {
                return item.product_id + "," + item.product_name
            });
        });
    };

    $scope.selected = function ($item, $model, $label, $event) {
        var s = $scope.product.product_name.split(',');
        $scope.product.product_name = s[1];
        $scope.product.product_id = s[0];
    };
    $scope.submit = function () {
        //提取ID
        var product = [];
        for (var i in  $scope.products) {
            product.push($scope.products[i]);
        }
        $scope.supplier.product = product;
        $http.post($Bs_API.getApi('new_supplier'), $scope.supplier).success(function () {
            toastr.success('成功');
            $state.go('main.provider-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
        });
    }
});

app.controller('goodOrderListCtrl', function ($scope, $state) {
    $scope.stateColor = [
        "label-warning", "label-success", "label-info", "label-primary", "label-danger"
    ];
    $scope.stateText = [
        "待审核", "审核通过", "退货", "待收货", "审核不通过"
    ];
    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "单号",
        field: 'order_number',
        value: ''
    }, {
        flag: "仓库审核通过人",
        field: 'auditor_name',
        value: ''
    }, {
        flag: "采购负责人",
        field: 'purchaser_name',
        value: ''
    }];

    $scope.dt = {
        start: $state.params.start_time ? new Date($state.params.start_time) : new Date(),
        end: $state.params.end_time ? new Date($state.params.end_time) : new Date(),
        state: $state.params.order_state
    };

    $scope.dateOptions1 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    $scope.dateOptions2 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    // Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }


    $scope.open1 = function () {
        if ($scope.dt.end) {
            $scope.dateOptions1.maxDate = new Date($scope.dt.end);
        }
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        if ($scope.dt.start) {
            $scope.dateOptions1.minDate = new Date($scope.dt.start);
        }
        $scope.popup2.opened = true;
    };

    $scope.popup1 = {
        opened: false
    };
    $scope.popup2 = {
        opened: false
    };
    $scope.search2 = function () {
        $scope.$broadcast('PageWillChange', {
            start_time: Format($scope.dt.start, "yyyy-MM-dd"),
            end_time: Format($scope.dt.end, "yyyy-MM-dd"),
            order_state: $scope.dt.state
            , purchaser_name: "", auditor_name: "", order_number: ""
        });
    };
    $scope.all = function () {
        $scope.$broadcast('PageWillChange', {
            order_number: "", start_time: "", end_time: "", purchaser_name: "", auditor_name: "", order_state: ""
        })
        ;
    }
    function Format(time, fmt) {
        if (!time || !fmt) {
            return ""
        }
        var o = {
            "M+": time.getMonth() + 1,                 //月份
            "d+": time.getDate(),                    //日
            "h+": time.getHours(),                   //小时
            "m+": time.getMinutes(),                 //分
            "s+": time.getSeconds(),                 //秒
            "q+": Math.floor((time.getMonth() + 3) / 3), //季度
            "S": time.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (time.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }
});
app.controller('goodOrderDetailCtrl', function ($scope, $http, $Bs_API, $state) {

    $scope.stateColor = [
        "label-warning", "label-success", "label-info", "label-primary", "label-danger"
    ];
    $scope.stateText = [
        "待审核", "审核通过", "退货", "待收货", "审核不通过"
    ];
    //allocationorder_id
    $http.post($Bs_API.getApi('order_detail'), {
        order_id: $state.params.id
    }).success(function (data) {
        //var use
        if (data && data.status && data.status == 1) {
            $scope.order = data.result;
        } else {
            toastr.error('系统维护中！');
        }
    }).error(function (data) {
        toastr.error('网络错误，信息获取失败！');
    });
});


app.controller('goodHubListCtrl', function ($scope) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "仓库编号",
        field: 'number',
        value: ''
    }, {
        flag: "地址",
        field: 'address',
        value: ''
    }];
});
app.controller('goodHubDetailCtrl', function ($scope, $Bs_API, $http, $state) {

    $http.post($Bs_API.getApi('edit_hub'), {
        warehouse_id: $state.params.id
    }).success(function (data) {
        //var use

        try {
            $scope.hub = JSON.parse(data);
            $scope.hub.warehouse_maxcount = parseInt($scope.hub.warehouse_maxcount);
        } catch (e) {
            toastr.error('抱歉，目前系统维护中！');
        }
    }).error(function (data) {
        toastr.error('网络错误，信息获取失败！');
    });

    $scope.hub = {};
    $scope.submit = function () {
        if (!$scope.hub.warehouse_number || !$scope.hub.warehouse_address || !$scope.hub.warehouse_maxcount) {
            toastr.error('数据未填完');
        }
        $http.post($Bs_API.getApi('new_hub'), $scope.hub).success(function () {
            toastr.success('成功');
            $state.go('main.hub-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
        });
    }
});
app.controller('goodHubNewCtrl', function ($scope, $Bs_API, $state, $http) {
    $scope.hub = {};
    $scope.submit = function () {
        if (!$scope.hub.warehouse_number || !$scope.hub.warehouse_address || !$scope.hub.warehouse_maxcount) {
            toastr.error('数据未填完');
        }
        $http.post($Bs_API.getApi('new_hub'), $scope.hub).success(function () {
            toastr.success('成功');
            $state.go('main.hub-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败');
        });
    }
});

app.controller('goodInoutListCtrl', function ($scope, $state) {

    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;
        //console.log(data);
    });
    $scope.dt = {
        start: $state.params.start_time ? new Date($state.params.start_time) : new Date(),
        end: $state.params.end_time ? new Date($state.params.end_time) : new Date()
    };

    $scope.dateOptions1 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    $scope.dateOptions2 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    // Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }


    $scope.open1 = function () {
        if ($scope.dt.end) {
            $scope.dateOptions1.maxDate = new Date($scope.dt.end);
        }
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        if ($scope.dt.start) {
            $scope.dateOptions1.minDate = new Date($scope.dt.start);
        }
        $scope.popup2.opened = true;
    };

    $scope.popup1 = {
        opened: false
    };
    $scope.popup2 = {
        opened: false
    };
    $scope.search2 = function () {
        $scope.$broadcast('PageWillChange', {
            start_time: Format($scope.dt.start, "yyyy-MM-dd"),
            end_time: Format($scope.dt.end, "yyyy-MM-dd")
            , outwarehouse_number: "", inwarehouse_number: "", allocate_number: ""
        });
    };
    $scope.all = function () {
        $scope.$broadcast('PageWillChange', {
            allocate_number: "", start_time: "", end_time: "", outwarehouse_number: "", inwarehouse_number: ""
        })
        ;
    }
    function Format(time, fmt) {
        if (!time || !fmt) {
            return ""
        }
        var o = {
            "M+": time.getMonth() + 1,                 //月份
            "d+": time.getDate(),                    //日
            "h+": time.getHours(),                   //小时
            "m+": time.getMinutes(),                 //分
            "s+": time.getSeconds(),                 //秒
            "q+": Math.floor((time.getMonth() + 3) / 3), //季度
            "S": time.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (time.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

    //获取当前页面
    $scope.searchField = [{
        flag: "单号",
        field: 'allocate_number',
        value: ''
    }, {
        flag: "入库仓库",
        field: 'inwarehouse_number',
        value: ''
    }, {
        flag: "出库仓库",
        field: 'outwarehouse_number',
        value: ''
    }];

});
app.controller('goodInoutDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    //allocationorder_id
    $http.post($Bs_API.getApi('allo_detail'), {
        allocationorder_id: $state.params.id
    }).success(function (data) {
        //var use
        if (data && data.status && data.status == 1) {
            $scope.alloc = data.result;
        } else {
            toastr.error('系统维护中！');
        }
    }).error(function (data) {
        toastr.error('网络错误，信息获取失败！');
    });
});
app.controller('goodInoutNewCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.product = {};
    $scope.alloc = {
        alloc_out: {},
        alloc_in: {}
    };
    $scope.products = {};
    var count = 0;
    $scope.add = function () {
        var pro = $scope.product;
        if (!pro.product_name || !pro.number || parseInt(pro.number) < 1) {
            return;
        }
        $scope.products[count] = pro;
        count++;
        $scope.product = {};
        $http.post($Bs_API.getApi('get_ware_capacity'), {
            product_id: pro.product_id,
            in_ware_id: $scope.alloc.alloc_in.id,
            out_ware_id: $scope.alloc.alloc_out.id
        }).success(function (data) {
            computeVulm(data, pro)
        }).error(function (data) {
            console.log(data);
        })
    };
    $scope.del = function (key) {
        delete $scope.products[key];
    };
    $scope.getPro = function (val) {
        return $http.get($Bs_API.getApi('get_product_by_name'), {
            params: {
                name: val
            }
        }).then(function (response) {
            //console.log(response);
            return response.data['list'].map(function (item) {
                return item.product_id + "," + item.product_name
            });
        });
    };

    $scope.selectedPro = function ($item, $model, $label, $event) {
        var s = $item.split(',');
        $scope.product.product_name = s[1];
        $scope.product.product_id = s[0];
    };
    $scope.submit = function () {
        //提取ID
        if (!$scope.alloc.alloc_in.id || !$scope.alloc.alloc_out.id) {
            toastr.error('未选择调出/入仓库！');
            return;
        }
        var product = [], temp;
        for (var i in  $scope.products) {
            if (!$scope.products[i].error) {
                temp = {
                    id: $scope.products[i].product_id,
                    number: $scope.products[i].number
                };
                product.push(temp);
                temp = {}
            }
        }
        if (product.length < 1) {
            toastr.error('没有可调拨的商品');
            return;
        }
        $scope.form = {};
        $scope.form.product = product;
        $scope.form.warehouse = {
            in_id: $scope.alloc.alloc_in.id,
            out_id: $scope.alloc.alloc_out.id
        };
        $http.post($Bs_API.getApi('new_allo'), $scope.form).success(function () {
            toastr.success('添加成功！');
            $state.go('main.inout-list', {page: 1});
        }).error(function () {
            toastr.error('添加失败！');
        });
    }
    $scope.getWare = function (val) {
        return $http.get($Bs_API.getApi('get_all_warehouse'), {
            params: {
                name: val
            }
        }).then(function (response) {
            return response.data['list'].map(function (item) {
                return item.warehouse_id + "," + item.warehouse_number + "," + item.warehouse_maxcount
            });
        });
    };
    $scope.selectedWare = function ($item, $model, $label, $event, target, comp, address) {
        var s = $item.split(',');
        if ($scope.alloc[comp].id == s[0]) {
            toastr.error('出入仓库不能相同！');
            $scope.alloc[target].number = '';
            $scope.alloc[target].id = '';
            $scope.alloc[target].max = '';
        } else {
            $scope.alloc[target].number = s[1];
            $scope.alloc[target].id = s[0];
            $scope.alloc[target].max = s[2];
        }
        console.log(address);
    };
    function computeVulm(data, pro) {
        //计算返回的数量
        pro.error = false;
        if (data.status == 1) {
            // 返货的result长度为0，1，2
            switch (data.result.length) {
                case 0:
                {
                    //没有记录，无法调拨
                    toastr.error('商品: ' + pro.product_name + '库存为0，无法调拨！');
                    pro.error = true;
                    break;
                }
                case 1:
                {
                    if (data.result[0].warehouse_id == $scope.alloc.alloc_out.id) {
                        pro.out_ware_has = data.result[0].maxcount - data.result[0].remindcount;
                        pro.in_ware_has = 0;
                        pro.in_ware_remain = $scope.alloc.alloc_out.max;
                        if (pro.number > pro.out_ware_has || pro.number > pro.in_ware_remain) {
                            pro.error = true;
                        }
                    } else {
                        pro.error = true;
                        toastr.error('商品: ' + pro.product_name + '入库存量为0，无法调拨！');
                    }
                    break;
                }
                case 2:
                {
                    if ((data.result[0].warehouse_id == $scope.alloc.alloc_out.id) && (data.result[1].warehouse_id == $scope.alloc.alloc_in.id)) {
                        pro.in_ware_has = data.result[1].maxcount - data.result[1].remindcount;
                        pro.in_ware_remain = data.result[1].remindcount;
                        pro.out_ware_has = data.result[0].maxcount - data.result[0].remindcount;
                        if (pro.number > pro.out_ware_has || pro.number > pro.in_ware_remain) {
                            pro.error = true;
                        }
                    } else if ((data.result[0].warehouse_id == $scope.alloc.alloc_out.id) && (data.result[1].warehouse_id == $scope.alloc.alloc_in.id)) {
                        pro.in_ware_has = data.result[0].maxcount - data.result[0].remindcount;
                        pro.in_ware_remain = data.result[0].remindcount;
                        pro.out_ware_has = data.result[1].maxcount - data.result[1].remindcount;
                        if (pro.number > pro.out_ware_has || pro.number > pro.in_ware_remain) {
                            pro.error = true;
                        }
                    } else {
                        pro.error = true;
                        toastr.error('商品: ' + pro.product_name + '库存数量有误，无法调拨！');
                    }

                    break;
                }
                default :
                {
                    pro.error = true;
                    toastr.error('商品: ' + pro.product_name + '库存数量有误，无法调拨！');
                }
            }
        } else {
            pro.error = true;
            toastr.error('无法获取商品: ' + pro.product_name + ' 库存情况！');
        }
    }
});


app.controller('goodCheckOrderListCtrl', function ($scope, $state) {

    $scope.stateColor = [
        "label-warning", "label-success", "label-info", "label-primary", "label-danger"
    ];
    $scope.stateText = [
        "待审核", "审核通过", "退货", "待收货", "审核不通过"
    ];
    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    //获取当前页面
    $scope.searchField = [{
        flag: "单号",
        field: 'order_number',
        value: ''
    }, {
        flag: "仓库审核通过人",
        field: 'auditor_name',
        value: ''
    }, {
        flag: "采购负责人",
        field: 'purchaser_name',
        value: ''
    }];

    $scope.dt = {
        start: $state.params.start_time ? new Date($state.params.start_time) : new Date(),
        end: $state.params.end_time ? new Date($state.params.end_time) : new Date(),
        state: $state.params.order_state
    };

    $scope.dateOptions1 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    $scope.dateOptions2 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    // Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }


    $scope.open1 = function () {
        if ($scope.dt.end) {
            $scope.dateOptions1.maxDate = new Date($scope.dt.end);
        }
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        if ($scope.dt.start) {
            $scope.dateOptions1.minDate = new Date($scope.dt.start);
        }
        $scope.popup2.opened = true;
    };

    $scope.popup1 = {
        opened: false
    };
    $scope.popup2 = {
        opened: false
    };
    $scope.search2 = function () {
        $scope.$broadcast('PageWillChange', {
            start_time: Format($scope.dt.start, "yyyy-MM-dd"),
            end_time: Format($scope.dt.end, "yyyy-MM-dd"),
            order_state: $scope.dt.state
            , purchaser_name: "", auditor_name: "", order_number: ""
        });
    };
    $scope.all = function () {
        $scope.$broadcast('PageWillChange', {
            order_number: "", start_time: "", end_time: "", purchaser_name: "", auditor_name: "", order_state: ""
        })
        ;
    }
    function Format(time, fmt) {
        if (!time || !fmt) {
            return ""
        }
        var o = {
            "M+": time.getMonth() + 1,                 //月份
            "d+": time.getDate(),                    //日
            "h+": time.getHours(),                   //小时
            "m+": time.getMinutes(),                 //分
            "s+": time.getSeconds(),                 //秒
            "q+": Math.floor((time.getMonth() + 3) / 3), //季度
            "S": time.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (time.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

});
app.controller('goodCheckOrderDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.stateColor = [
        "label-warning", "label-success", "label-info", "label-primary", "label-danger"
    ];
    $scope.stateText = [
        "待审核", "审核通过", "退货", "待收货", "审核不通过"
    ];
    //allocationorder_id
    $http.post($Bs_API.getApi('man_order_detail'), {
        order_id: $state.params.id
    }).success(function (data) {
        //var use
        if (data && data.status && data.status == 1) {
            $scope.order = data.result;
        } else {
            toastr.error('系统维护中！');
        }
    }).error(function (data) {
        toastr.error('网络错误，信息获取失败！');
    });
    $scope.reject = function () {
        $http.post($Bs_API.getApi('do_review'), {
            id: $state.params.id,
            type: 'order',
            state: 4
        }).success(function (data) {
            data = JSON.parse(data);
            if (data.status == 1) {
                toastr.success('审核成功！');
                $state.reload()
            } else {
                toastr.error('审核失败！');
            }

        }).error(function (data) {
            toastr.error('网络错误，提交失败！');
        });
    }
    $scope.pass = function () {
        $http.post($Bs_API.getApi('do_review'), {
            id: $state.params.id,
            type: 'order',
            state: 1
        }).success(function (data) {
            data = JSON.parse(data);
            if (data.status == 1) {
                toastr.success('审核成功！');
                $state.reload()
            } else {
                toastr.error('审核失败！');
            }

        }).error(function (data) {
            toastr.error('网络错误，提交失败！');
        });
    }
});

app.controller('goodCheckGoodListCtrl', function ($scope, $state) {

    $scope.stateText = [
        "等待审核", "审核通过", "审核不通过"
    ];
    $scope.stateColor = [
        "label-info", "label-success", "label-danger"
    ];
    $scope.$on('PageLoaded', function (e, data) {
        $scope.list = data;

    });
    $scope.dt = {
        start: $state.params.start_time ? new Date($state.params.start_time) : new Date(),
        end: $state.params.end_time ? new Date($state.params.end_time) : new Date(),
        state: $state.params.order_state
    };

    $scope.dateOptions1 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    $scope.dateOptions2 = {
        dateDisabled: disabled,
        formatYear: 'yy',
        maxDate: new Date(),
        minDate: new Date(2016, 01, 01),
        startingDay: 1
    };
    // Disable weekend selection
    function disabled(data) {
        var date = data.date,
            mode = data.mode;
        return mode === 'day' && (date.getDay() === 0 || date.getDay() === 6);
    }


    $scope.open1 = function () {
        if ($scope.dt.end) {
            $scope.dateOptions1.maxDate = new Date($scope.dt.end);
        }
        $scope.popup1.opened = true;
    };

    $scope.open2 = function () {
        if ($scope.dt.start) {
            $scope.dateOptions1.minDate = new Date($scope.dt.start);
        }
        $scope.popup2.opened = true;
    };

    $scope.popup1 = {
        opened: false
    };
    $scope.popup2 = {
        opened: false
    };
    $scope.search2 = function () {
        $scope.$broadcast('PageWillChange', {
            start_time: Format($scope.dt.start, "yyyy-MM-dd"),
            end_time: Format($scope.dt.end, "yyyy-MM-dd"),
            order_state: $scope.dt.state
            , purchaser_name: "", auditor_name: "", order_number: ""
        });
    };
    $scope.all = function () {
        $scope.$broadcast('PageWillChange', {
            order_number: "", start_time: "", end_time: "", purchaser_name: "", auditor_name: "", order_state: ""
        })
        ;
    }
    $scope.radioModel = $state.params.order_state;
    $scope.select = function () {
        $scope.$broadcast('PageWillChange', {
            order_state: $scope.radioModel,
            order_number: "",
            start_time: "",
            end_time: "",
            purchaser_name: "",
            auditor_name: ""
        });
    }
    function Format(time, fmt) {
        if (!time || !fmt) {
            return ""
        }
        var o = {
            "M+": time.getMonth() + 1,                 //月份
            "d+": time.getDate(),                    //日
            "h+": time.getHours(),                   //小时
            "m+": time.getMinutes(),                 //分
            "s+": time.getSeconds(),                 //秒
            "q+": Math.floor((time.getMonth() + 3) / 3), //季度
            "S": time.getMilliseconds()             //毫秒
        };
        if (/(y+)/.test(fmt))
            fmt = fmt.replace(RegExp.$1, (time.getFullYear() + "").substr(4 - RegExp.$1.length));
        for (var k in o)
            if (new RegExp("(" + k + ")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
        return fmt;
    }

});
app.controller('goodCheckGoodDetailCtrl', function ($scope, $http, $Bs_API, $state) {
    $scope.stateText = [
        "等待审核", "审核通过", "审核不通过"
    ];
    $scope.stateColor = [
        "label-info", "label-success", "label-danger"
    ];
    $http.post($Bs_API.getApi('man_receive_detail'), {
        receiveorder_id: $state.params.id
    }).success(function (data) {
        //var use
        if (data && data.status && data.status == 1) {
            $scope.order = data.result;
        } else {
            toastr.error('系统维护中！');
        }
    }).error(function (data) {
        toastr.error('网络错误，信息获取失败！');
    });
    $scope.reject = function () {
        $http.post($Bs_API.getApi('do_review'), {
            id: $state.params.id,
            type: 'receive',
            state: 4
        }).success(function (data) {
            data = JSON.parse(data);
            if (data.status == 1) {
                toastr.success('审核成功！');
                $state.reload()
            } else {
                toastr.error('审核失败！');
            }

        }).error(function (data) {
            toastr.error('网络错误，提交失败！');
        });
    }
    $scope.pass = function () {
        $http.post($Bs_API.getApi('do_review'), {
            id: $state.params.id,
            type: 'receive',
            state: 1
        }).success(function (data) {
            data = JSON.parse(data);
            if (data.status == 1) {
                toastr.success('审核成功！');
                $state.reload()
            } else {
                toastr.error('审核失败！');
            }

        }).error(function (data) {
            toastr.error('网络错误，提交失败！');
        });
    }
});

