app.controller('courseDetailsCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, filterFilter) {

    var courseId = $routeParams.courseId;

    $scope.selectedCourse = filterFilter($rootScope.courses, {ID: courseId})[0];
    $scope.goToHome = function () {
        $location.path('/');
    };
    $scope.getLessons = function () {
        Data.get('lessons', $scope.selectedCourse).then(function (data) {
            $rootScope.lessons = data.data;
            if (data.status == "success") {
                $scope.lessons = $rootScope.lessons;
            }
        });
    };
    //$scope.courses = $rootScope.courses;
    //$scope.login = $rootScope.login



});