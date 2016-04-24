/**
 * Created by huminghui on 2016/4/24.
 */
//List
app.factory('$Bs_List', ['$q', '$state','$http','$Bs_API' ,function ($q, $state,$http,$Bs_API) {
    var _$God_List = {};
    _$God_List.get = function () {
        //console.log(data);
        var param = getParam($state.params);
        var handlerNo = $state.$current.self.Handler.number;
        var baseUrl = $Bs_API.getUrl($state.$current.self.Handler.list);
        var Handler = getHandler(handlerNo);
        return Handler.getList(baseUrl, param);
    };
    return _$God_List;

    function getParam(stateparam) {
        var _param = {}, temp;
        for (var i in stateparam) {
            temp = stateparam[i];
            if (temp) {
                _param[i] = temp;
            }
        }
        return _param;
    }
    function getGoodList(baseUrl, data) {
        var defer = $q.defer();
        //var url = $Bs_API.concat(baseUrl, data);//TODO 联调后取消注释，否则分页失败
        var url=baseUrl;
        $http.get(url).success(function (result) {
            //console.log(data);
            if (typeof result == "string") {
                defer.reject(result);
                return;
            }
            //var results = listParse.parse(result);
            var results={
                list:result,
                page:2,
                size:10,
                count:1000
            };
            if (results) {
                defer.resolve(results);
            }
        }).error(
            defer.reject
        );
        return defer.promise;
    }
    function getHandler(handlerNo) {
        var han = {};
        switch (handlerNo) {
            case 1:
            {
                han.getList = getGoodList;
                break;
            }
            default :
            {
                han.getList = getGoodList;

            }
        }
        return han;
    }

    function isArray(v) {
        return toString.apply(v) === '[object Array]';
    }

    function getString(value) {
        return isArray(value) ? value.join(" ") : value;
    }

    function delNullValue(obj, pro) {
        if (!obj[pro]) {
            delete obj[pro];
        }
    }
}])
;