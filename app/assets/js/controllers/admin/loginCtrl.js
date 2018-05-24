var app = angular.module('ngQuiz');
app.controller('admin.loginCtrl', ['$scope','$http','$rootScope','$state', function($scope,$http,$rootScope,$state){
	$scope.thisPage = 'admin';
	$scope.isAdmin = true;
	$http.get('http://localhost/stan/server/v1/adminSession').then(function(res){
    		if(res.data.admin_id !== ''){
    			$state.go('admin.dashboard');
    		}
	});
	$scope.doLogin = function(details){
		$http.post('http://localhost/stan/server/v1/adminLogin', details).then(function(res){
			//u can actually give this function a name and then call it else where
			//console.log(JSON.stringify(res));
			if(res.data.status === 'success'){
				$rootScope.showAlert(res.data.status,res.data.message,res.data.status);
				$state.go('admin.dashboard')
			} else{
				$rootScope.showAlert(res.data.status,res.data.message,res.data.status);
			}
		});
	}
}])