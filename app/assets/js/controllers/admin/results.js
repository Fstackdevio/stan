var app = angular.module('ngQuiz');

app.controller('adminCtrl.downloadResultsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'Download Results';
}])

app.controller('adminCtrl.viewResultsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'View Results';
}])