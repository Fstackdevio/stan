var app = angular.module('ngQuiz');

app.controller('adminCtrl.addQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'Add Questions';
}])

app.controller('adminCtrl.viewQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = 'View Questions';
}])

app.controller('adminCtrl.downloadQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Download Questions' Info";
}])

app.controller('adminCtrl.editQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Edit Questions";
}])