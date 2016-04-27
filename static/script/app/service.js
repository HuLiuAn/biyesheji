/**
 * Created by huminghui on 2016/4/24.
 */
//List
app.factory('$Bs_List', ['$q', '$state','$http','$Bs_API' ,function ($q, $state,$http,$Bs_API) {
    var _$Bs_List = {};
    _$Bs_List.get = function () {
        var param = getParam($state.params);
        var baseUrl = $Bs_API.getApi($state.$current.self.Handler);
        //var Handler =eval($state.$current.self.Handler);//注入函数名
        return Handler(baseUrl, param);
    };
    return _$Bs_List;

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
    function Handler(baseUrl, data) {
        var defer = $q.defer();
        var url = $Bs_API.concat(baseUrl, data);//TODO 联调后取消注释，否则分页失败
        //var url=baseUrl;
        $http.get(url).success(function (result) {
            if (typeof result == "string") {
                defer.reject(result);
                return;
            }
            var results={
                list:result.list,
                page:result.page,
                size:10,
                count:result.total
            };
            if (results) {
                defer.resolve(results);
            }
        }).error(
            defer.reject
        );
        return defer.promise;
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