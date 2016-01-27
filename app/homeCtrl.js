app.controller('homeCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data) {
    $scope.selectedList="";
    $scope.getAllCourses = function () {
        Data.get('courses').then(function (data) {
            $rootScope.courses = data.data;
            if (data.status == "success") {
                $scope.allCourses = $rootScope.courses;
            }
        });
        $scope.selectedList="courses";
    };
    //$scope.getAllCourses();
    $scope.getAllTeachers = function () {
        Data.get('teachers').then(function (data) {
            $rootScope.teachers = data.data;
            if (data.status == "success") {
                $scope.allTeachers = $rootScope.teachers;
            }
        });
        $scope.selectedList="teachers";
    };
    $scope.goToLogin = function () {
        $location.path("/login");
    };
    $scope.goToSignup = function () {
        $location.path("/signup");
    };
    $scope.goToCourseDetails = function (selectedCourse) {
        $location.path("/courses/" + selectedCourse);
    };
});