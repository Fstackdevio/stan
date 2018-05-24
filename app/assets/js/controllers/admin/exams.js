var app = angular.module('ngQuiz');

app.controller('adminCtrl.addExamsCtrl', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	$rootScope.thisPage = 'Add Exam';
	$scope.exam = {};
	$scope.instructionDisabled = true;
	$scope.exam.disabled = true;
	$scope.createExam = function(details){
		var exam = {
			name: details.title,
			pwd: details.password,
			duration: details.duration,
			instructions: details.instructions,
			disabled: details.disabled,
			unit: details.units,
			instructor: details.instructor
		};
		$http.post('http://localhost/stan/server/v1/addExam', exam).success(function(res){
			if(res.status == 'success'){
				$rootScope.showAlert(res.status,res.message,'Success');
				$scope.exam = '';
			} else {
				$rootScope.showAlert(res.status,res.message,'Error');
			}
		})
	};
}])

app.controller('adminCtrl.viewExamsCtrl', ['$scope','$rootScope','$http','DTOptionsBuilder','$timeout', function($scope,$rootScope,$http,DTOptionsBuilder,$timeout){
	$rootScope.thisPage = 'View Exams';
	// DataTable options
    $scope.dtOptions = DTOptionsBuilder.newOptions().withDisplayLength(7).withBootstrap().withOption('bLengthChange', true);

	$http.get('http://localhost/stan/server/v1/getExams').then(function(res){
		$scope.examsList = res.data.exams;
	});

	//delete function
	$scope.doDeleteExam = function(index,id,resource){
		$scope.url = 'http://localhost/stan/server/v1/deleteExam/'+id;
		//console.log($scope.url);
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
				$scope.examsList.splice(index,1);
				$http.delete($scope.url,resource).then(function(res){
					//console.log(res.data);
					if(res.data.status == "success"){
						$rootScope.showAlert('success','Exam was deleted successfully','Deleted');
					} else{
						$rootScope.showAlert('error','An error occured while deleting','Error');
					}
				});
				$timeout(function(){
					$scope.this = 1;
				}, 100);
			} else{
				$rootScope.showAlert('error','Exam not deleted','Cancelled');
			};
		});
	};
}]);

app.controller('adminCtrl.downloadExamsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Download Exams' Info";
}])

app.controller('adminCtrl.editExamsCtrl', ['$scope','$rootScope','$stateParams','$http', function($scope,$rootScope,$stateParams,$http){
	$rootScope.thisPage = "Edit Exams";
	$scope.exam = {};
	$scope.exam.disabled = true;
	$scope.id = $stateParams.data;

	$http.get('http://localhost/stan/server/v1/getExams').then(function(res){
		$scope.examsList = res.data.exams;
		for (var i = $scope.examsList.length - 1; i >= 0; i--) {
			if($scope.examsList[i]._id == $scope.id){
				$scope.exam = $scope.examsList[i];
				//console.log($scope.exam);
			}
		}
	});

	$scope.saveExamEdit = function(id,resource){
		// console.log('save btn clicked '+ id);
		$scope.url = 'http://localhost/stan/server/v1/editExam/'+$scope.id;
		//console.log($scope.url);
		console.log(JSON.stringify(resource));
		$http.put($scope.url, resource).then(function(res){
			console.log(res.data);
			if(res.data.status === "Success"){
				$rootScope.showAlert("success",res.data.message,res.data.status);
			}else if(res.data.status === "Error"){
				$rootScope.showAlert("error",res.data.message,res.data.status);
			}else{
				$rootScope.showAlert(res.data.status,res.data.message,res.data.status);
			}
		})
	}
}])