var app = angular.module('ngQuiz');
app.controller('adminCtrl.dashCtrl', ['$scope','$rootScope','$http','$state', function($scope,$rootScope,$http,$state){
	$scope.testing = "hehe";
	$rootScope.thisPage = 'Dashboard';
	$scope.isMainAdmin = 0;
	$http.get('http://localhost/stan/server/v1/adminSession').then(function(res){
    	//console.log(JSON.stringify(res.data.admin_id));
    	if(res.status == 200){
    		if(res.data.admin_id == ''){
    			console.log('sorry not logged');
    			$rootScope.showAlert('error',"Sorry you're not logged in","Error");
    			$state.go('adminLogin');
    		} else{
				$rootScope.userInfo = res.data;
			};
		} else {
			console.log("An unknown error occured");
		};
	});
}])