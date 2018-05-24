var app = angular.module('ngQuiz');

app.controller('adminCtrl.adminHelpCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'Help Page';
}])