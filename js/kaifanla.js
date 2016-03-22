/**
 * Created by Administrator on 2016/1/7.
 */
angular.module("kaifanla", ['ng', 'ngRoute', 'ngAnimate'])
    .controller('parentCtrl', function ($scope, $location) {
        $scope.jump = function (routeUrl) {
            $location.path(routeUrl);
        }
    })
    .controller('startCtrl', function () {

    })
    .controller('mainCtrl', function ($scope, $http) {

        $scope.dishList = [];
        $http.get('data/dish_listbypage.php?start=0').success(function (data) {
            $scope.dishList = $scope.dishList.concat(data);
        });
        $scope.loadMore = function () {
            $http.get('data/dish_listbypage.php?start=' + $scope.dishList.length).success(function (data) {
                $scope.dishList = $scope.dishList.concat(data);
                $scope.hasMore = false;
                if (data.length < 5) {
                    $scope.hasMore = true;
                }

            });
        }
        //监视搜索框中的内容是否改变--监视kw Model变量
        $scope.$watch('kw', function () {
            if ($scope.kw) {
                $http.get('data/dish_listbykw.php?kw=' + $scope.kw).success(function (data) {
                    $scope.dishList = data;
                })
            }
        })

    })
    .controller('detailCtrl', function ($scope,$routeParams, $http) {
        $http.get('data/dish_listbydid.php?did='+$routeParams.did).success(function (data) {
            $scope.details = data;

        })
    })
    .controller('orderCtrl', function ($scope,$http,$routeParams,$rootScope) {

        $scope.order = {};
        $scope.order.did = $routeParams.did;
        //$scope.order.phone = '13501234567';
       // $scope.order.sex = '1';
       // $scope.order.user_name = '大旭';
       // $scope.order.addr = '万寿路108号';

        $scope.submitOrder = function(){
            //提交订单之前把用户输入的电话号码保存在全局范围内
            $rootScope.phone = $scope.order.phone;
            //把客户端输入的数据转换为“请求参数”格式——k=v&k=v
            var str = jQuery.param($scope.order);

            //发起异步的XHR请求
            //$http.get('data/order_add.php?'+str).success(fn)
            $http.post('data/order_add.php', str).
                success(function(data){
                    //console.log('读取到服务器返回的响应数据：');
                    console.log(data);
                    $scope.result = data[0];
                })
        }

    })
    .controller('myorderCtrl', function ($scope,$http,$rootScope) {
        $http.get('data/order_listbyphone.php?phone='+$rootScope.phone).success(function (data) {
           $scope.myorder=data;
           // console.log(data);

        })
        //$scope.delete(function(){

        //});
    })
    .config(["$routeProvider", function ($routeProvider) {//调用module.config()配置路由字典
        $routeProvider
            .when('/start', {
                templateUrl: 'tpl/start.html',
                controller: 'startCtrl'
            })
            .when("/main", {
                templateUrl: 'tpl/main.html',
                controller: 'mainCtrl'
            })
            .when("/detail/:did", {
                templateUrl: 'tpl/detail.html',
                controller: 'detailCtrl'
            })
            .when("/order/:did", {
                templateUrl: 'tpl/order.html',
                controller: 'orderCtrl'
            })
            .when("/myorder", {
                templateUrl: 'tpl/myorder.html',
                controller: 'myorderCtrl'
            })
            .otherwise({//若URL中未提供路由地址或提供了不存在路由地址
                redirectTo: '/start'
            })
    }])
    .run(function($http){
        //设置$http.post请求的默认请求消息头部
        $http.defaults.headers.post={'Content-Type':'application/x-www-form-urlencoded'}
    })