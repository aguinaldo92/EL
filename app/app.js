var app = angular.module('myApp', ['ngRoute', 'ngAnimate', 'toaster']);

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.
                when('/login', {
                    title: 'Login',
                    templateUrl: 'partials/login.html',
                    controller: 'authCtrl'
                })
                .when('/logout', {
                    title: 'Logout',
                    templateUrl: 'partials/login.html',
                    controller: 'logoutCtrl'
                })
                .when('/signup', {
                    title: 'Signup',
                    templateUrl: 'partials/signup.html',
                    controller: 'authCtrl'
                })
                .when('/dashboard', {
                    title: 'Dashboard',
                    templateUrl: 'partials/dashboard.html',
                    controller: 'authCtrl'
                })
                .when('/courses', {
                    title: 'Courses',
                    templateUrl: 'partials/courses.html',
                    controller: 'courseCtrl'

                })
                .when('/', { // da cambiare per redirigere alla home page del sito quando sarà pronta
                    title: 'Login',
                    templateUrl: 'partials/login.html',
                    controller: 'authCtrl',
                    role: '0'
                })
                .otherwise({
                    redirectTo: '/login'
                });
    }])
        .run(function ($rootScope, $location, Data) {
            $rootScope.$on("$routeChangeStart", function (event, next, current) {
                if ($rootScope.authenticated == null) {
                    $rootScope.authenticated = false;
                    Data.get('session').then(function (results) {
                        if (results.ID) {
                            $rootScope.authenticated = true;
                            $rootScope.ID = results.ID;
                            $rootScope.nickname = results.nickname;
                            $rootScope.email = results.email;
                        } else {
                            var nextUrl = next.$$route.originalPath;
                            if (nextUrl == '/signup' || nextUrl == '/login') {

                            } else {
                                $location.path("/login"); //all'inizio si viene indirizzati qui
                            }
                        }
                    });
                }
            });
        });

/* resolve: {
 courses: function (Data) {
 return Data.get('courses')
 }
 
 } */
    