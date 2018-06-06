var app = angular.module('ngQuiz');

app.directive('fileModel', ['$parse', function ($parse) {
	return {
	   restrict: 'A',
	   link: function(scope, element, attrs) {
		  var model = $parse(attrs.fileModel);
		  var modelSetter = model.assign;
		  
		  element.bind('change', function(){
			 scope.$apply(function(){
				modelSetter(scope, element[0].files[0]);
			 });
		  });
	   }
	};
 }]);

 app.service('fileUpload', ['$http', '$window', function ($http, $window) {
	this.uploadFileToUrl = function(file, uploadUrl){
	   var fd = new FormData();
	   fd.append('file', file);
	
	   $http.post(uploadUrl, fd, {
		  transformRequest: angular.identity,
		  headers: {'Content-Type': undefined}
	   }).then(function(response){
		   return response;
	   })
	}
 }]);


app.controller('adminCtrl.addQuestionsCtrl',  ['$scope','$http','$rootScope','$state','ExamData', 'fileUpload', function($scope,$http,$rootScope,$state,ExamData, fileUpload){
	$rootScope.thisPage = 'Add Questions test';
	$rootScope.exams = {};
	$scope.selectedExam = "Select a course";

	var cid = null;
	$http.get('http://localhost/cbt/serverv2/public/addQuestions').then(function(res){
		console.log(res.data.exams);
		$scope.subject = "";
		$scope.explanation = "";

		$rootScope.allExams = res.data.exams;
		$rootScope.getid = function(selected){
			for(var i in $rootScope.allExams){
				if(selected == $rootScope.allExams[i].name){
					if(selected == 'Select a course'){
						cid = '';	
					}else{
						cid = $scope.allExams[i]._id;
						// console.log(cid);
					}
				}
			}
		}
	})	

	$scope.save = function(){
		if($scope.subject === "" || $scope.explanation === "" || cid === "" || $scope.selectedExam === ""){
			var file = $scope.questionfile;
			// console.log('file is ' );
			// console.dir(file);
			var uploadUrl = "/cbt/uploads/upload.php";
			var response = fileUpload.uploadFileToUrl(file, uploadUrl);
			// console.log(response);
			var username = $scope.subject;
			var course_id = cid;
			var explanation = $scope.explanation;
			var fn = file.name;

			var data = JSON.stringify({
				filename : fn,
				username: username,
				course_id: course_id,
				explanation : explanation
			});
			console.log(data);
			$http.post("http://localhost/cbt/serverv2/public/addQuestions", data).then(function(response){
				if (response.data) { 
					console.log(response.data);
				} else {                
					console.log("error info");
				}
			})
		}else{
			// console.log("please all input are required");
			SweetAlert.swal('Error','please all input are required', 'Error'); 
		}
	}
}])

app.controller('adminCtrl.viewQuestionsCtrl', ['$scope','$http','$rootScope','$state','ExamData', function($scope,$http,$rootScope,$state,ExamData){
	$rootScope.thisPage = 'View Questions';
	$rootScope.exams = {};
	$scope.selectedExam = "Select a course";

	var cid = null;

	$http.get('http://localhost/cbt/serverv2/public/getExams').then(function(res){
		console.log(res.data.exams);
		$rootScope.allExams = res.data.exams;
		$rootScope.getid = function(selected){
			for(var i in $rootScope.allExams){
				if(selected == $rootScope.allExams[i].name){
					if(selected == 'Select a course'){
						cid = '';	
					}else{
						cid = $scope.allExams[i]._id;
					}
				}
			}
		}
	})


	$scope.getQuestions = function(){
		$scope.viewStudent= true;
		var data = JSON.stringify({
			course_id: cid
		});
		console.log(data);

		if(cid !== null){
			$http.post("http://localhost/cbt/serverv2/public/getQuestions", data).then(function(response){
				if (response.data) { 
					// $scope.students = response.data;
					console.log(response.data.questions);
					$scope.students = response.data.questions;
				} else {                
					SweetAlert.swal('Error','Couldnot Connect to Database', 'Error');  
				}
			})
		}else{
			console.log("server not collecting null value");
		}
	}
}])

app.controller('adminCtrl.downloadQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Download Questions' Info";
}])

app.controller('adminCtrl.editQuestionsCtrl', ['$scope','$rootScope', function($scope,$rootScope){
	$rootScope.thisPage = "Edit Questions";
}])