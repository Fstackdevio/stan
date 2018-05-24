var app = angular.module('ngQuiz');

app.controller('adminCtrl.downloadHistoryCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'Download History';
}])