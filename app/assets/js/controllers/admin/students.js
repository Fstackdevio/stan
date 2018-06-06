var app = angular.module('ngQuiz');

//create ctrl
app.controller('adminCtrl.addStdCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.thisPage = 'Add Student';
	$scope.std = {};
	
	$scope.addStudent = function(std){
		var student = {
			username: document.getElementById('username').value,
			firstname: std.firstName,
			lastname: std.lastName,
			othername: std.otherName,
			fullname: std.firstName + ' ' + std.lastName,
			level: std.level,
			reg_number: std.reg_number,
			department: std.department
		};
		$http.post('http://localhost/stan/serverv2/public/addStudent', student).then(function(res){
			if(res.data.status == "success"){
				$rootScope.showAlert(res.data.status,res.data.message,'Success');
			} else {
				$rootScope.showAlert(res.data.status,res.data.message,'Error');
			}
		})
	}
}])

//read ctrl
app.controller('adminCtrl.viewStdCtrl', ['$scope','$rootScope','$http','DTOptionsBuilder','$timeout', function($scope,$rootScope,$http,DTOptionsBuilder,$timeout){
	$rootScope.thisPage = 'View Student';
	// DataTables configurable options
    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(7).withBootstrap()
        //.withPaginationType('full_numbers')
        .withOption('bLengthChange', false);
	$http.get('http://localhost/stan/serverv2/public/getStudents').then(function(res){
		$scope.studentsList = res.data.students;
		// console.log(res);
	});

	$scope.viewMore = function(id){
		 $scope.currentStd = id;
		 for (var i = $scope.studentsList.length - 1; i >= 0; i--) {
		 	if($scope.studentsList[i]._id == id){
		 		$scope.currentStdDetails = $scope.studentsList[i];
		 	}
		 }
	};

	$scope.test = 0;

	//delete function
	$scope.doDeleteStd = function(index,id,resource){
		$scope.url = 'http://localhost/stan/serverv2/public/deleteStd/'+id;
		swal({
			title: 'Warning',
			text: 'Are you sure you want to delete?',
			type: 'warning',
			confirmButtonText: 'Yes, delete',
			confirmButtonColor: "#DD6B55",
			cancelButtonText: 'No, Cancel',
			closeOnConfirm: false,   
	        closeOnCancel: false,
	        showCancelButton: true
		}, 
		function(isConfirm){
			if(isConfirm){
				$scope.studentsList.splice(index,1);
				$http.delete($scope.url,resource).then(function(res){
					//console.log(res.data.status);
					if(res.data.status == "success"){
						$rootScope.showAlert('success','Student was deleted successfully','Deleted');
					} else{
						$rootScope.showAlert('error','An error occured while deleting','Error');
					}
				});
				$timeout(function(){
					$scope.this = 1;
				}, 100);
			} else{
				$rootScope.showAlert('error','Student record not deleted','Cancelled');
			};
		});
	};
}])

//edit ctrl
app.controller('adminCtrl.editStdCtrl', ['$scope','$rootScope','$stateParams','$http', function($scope,$rootScope,$stateParams,$http){
	$rootScope.thisPage = "Edit Student";
	$scope.id = $stateParams.data;

	$http.get('http://localhost/stan/serverv2/public/getStudents').then(function(res){
		$scope.allStudents = res.data.students;
		for (var i = $scope.allStudents.length - 1; i >= 0; i--) {
			if($scope.allStudents[i]._id == $scope.id[0]){
				$scope.currentStudent = $scope.allStudents[i];
				//console.log($scope.exam);
			}
		}
	});

	$scope.saveStdEdit = function(resource){
		$scope.url = 'http://localhost/stan/serverv2/public/editStudent/'+$scope.id;
		// console.log($scope.url);
		var username = document.getElementById('username').value;
		resource.username = username;
		console.log(JSON.stringify(resource));
		$http.put($scope.url, resource).then(function(res){
			console.log(res.data);
			if(res.data.status === "Success"){
				$rootScope.showAlert("success",res.data.message,res.data.status);
				$state.go('admin.viewStudent')
			}else if(res.data.status === "Error"){
				$rootScope.showAlert("error",res.data.message,res.data.status);
			}else{
				$rootScope.showAlert(res.data.status,res.data.message,res.data.status);
			}
		})
	}
}]);


//download ctrl
app.controller('adminCtrl.downloadStdCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Download Students' Broadsheet";
}])