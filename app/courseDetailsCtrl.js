app.controller('courseDetailsCtrl', function ($scope, $rootScope, $routeParams, $location, $http, Data, filterFilter) {
    
    var courseId = $routeParams.courseId;
    
    $scope.selectedCourse = filterFilter($rootScope.courses, { ID: courseId })[0];
    $scope.goToHome = function () {
        $location.path('/');
    };
    //$scope.courses = $rootScope.courses;
    //$scope.login = $rootScope.login
    
   

});