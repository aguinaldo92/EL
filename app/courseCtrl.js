app.controller('courseCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    $scope.course = {};
    /*
    $scope.getCourses = function () {
        Data.get('courses').then(function (data) {
            $scope.courses = data.data;
            Data.toast(data);
            if (data.status == "success") {
                $location.path('courses');
            }
        });
    };
   */

});


/*
 *  solo per conoscenza, il file di authCtrl:
 *  
 *   //initially set those objects to null to avoid undefined error
 *      $scope.login = {};
    $scope.signup = {};
    
    $scope.doLogin = function (user) {
        Data.post('login', {
            user: user
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('courses');
            }
        });
    };
    $scope.signup = {email:'',password:'',nickname:''};
    $scope.signUp = function (user) {
        Data.post('signUp', {
            user: user
        }).then(function (results) {
            Data.toast(results);
            if (results.status == "success") {
                $location.path('dashboard');
            }
        });
    };
    $scope.logout = function () {
        Data.get('logout').then(function (results) {
            Data.toast(results);
            $location.path('login');
        });
    }
 */