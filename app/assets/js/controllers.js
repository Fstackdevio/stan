'use strict';
var app = angular.module('ngQuiz');

app.controller('ngQuiz', ['$scope','$rootScope','$http', function($scope,$rootScope,$http){
	
	$rootScope.app = {
		title: "QuizApp",
		schoolName: "GrayBots University",
		schoolLogo: "assets/images/graybot.png"
	};

	$rootScope.showAlert = function(type,msg,title){
		swal({
			type: type,
			text: msg,
			title: title
		})
	};
	$rootScope.chartOptions = {
		animate: 800,
		barColor:'#03A9F4',
		scaleColor: false,
		lineWidth: 2.5,
		lineCap: 'circle',
		size: 100
	};
}]);

app.controller('timerCtrl', ['$scope', function($scope){
	
}])

app.controller('loginCtrl', ['$scope','$http','$rootScope','$state','ExamData', function($scope,$http,$rootScope,$state,ExamData){

	$rootScope.exams = {};
	
	$scope.selectedExam = "Select a course";

	$http.get('http://localhost/stan/serverv2/public/session').then(function(res){
    	if(res.data._id !== ''){
    		$state.go('preview');
    	}
	});

	// $http.get('http://localhost/stan/server/v1/getExams').then(function(res){
	$http.get('http://localhost/stan/serverv2/public/getExams').then(function(res){
		// console.log(res);
		$rootScope.allExams = res.data.exams;
		$rootScope.showPassword = function(selected){
			for(var i in $rootScope.allExams){
				if(selected == $rootScope.allExams[i].name){
					if(selected == 'Select a course'){
						return '';	
					} else{
						return $scope.allExams[i].pwd;
					}
				}
			}
		};
	})

	

	$scope.pwd = '';

	/*ExamData.get().then(function(res){
		$rootScope.allExams = res.data;
		$rootScope.showPassword = function(selected){
			for(var i in $rootScope.allExams){
				if(selected == $rootScope.allExams[i].name){
					return $scope.allExams[i].pwd;
				}
			}
		};
	});*/

	/*****8**** the main login function ****8*****/
	$scope.login = function(form,selectedExam){
		if(form.password == $rootScope.showPassword(selectedExam)){
			$http.post('http://localhost/stan/serverv2/public/login', form)
			.then(function(res){
				if(res.data.status == "success"){
					//console.log("logged in");
					// var data = {
					// 	"id" : $rootScope.allExams[i]._id,
					// 	"name" : $rootScope.allExams[i].name,
					// 	"durationSec" : $rootScope.allExams[i].duration*60,
					// 	"duration" : rootScope.allExams[i].duration,
					// 	"unit" : $rootScope.allExams[i].unit,
					// 	"instruction" : $rootScope.allExams[i].instructions,
					// 	"instructor" : $rootScope.allExams[i].instructor
					// };

					for(var i=0; i<$rootScope.allExams.length; i++){
						console.log($rootScope.allExams[i].pwd);
						if(form.password == $rootScope.allExams[i].pwd){
							console.log($rootScope.allExams[i].duration);
							localStorage.setItem('examTime', JSON.stringify({time: $rootScope.allExams[i].duration, inSeconds:$rootScope.allExams[i].duration*60}));

							$http.post('http://localhost/stan/serverv2/public/setExam', {id: $rootScope.allExams[i]._id, name: $rootScope.allExams[i].name, durationSec: $rootScope.allExams[i].duration*60, duration: $rootScope.allExams[i].duration, unit: $rootScope.allExams[i].unit, instruction: $rootScope.allExams[i].instructions, instructor: $rootScope.allExams[i].instructor}).then(function(response){
								console.log(response);
							});
						};
					};



					$rootScope.showAlert(res.data.status,res.data.message,res.data.status);

					$state.go('preview');
				} else{
					console.log("login failed");
					console.log(res.data);
					$scope.authError = res.data.message;
					$scope.showAlert(res.data.status,res.data.message,res.data.status);
				}
			});
		} else {
			$rootScope.showAlert("error","Incorrect Password","error");
		}
	};

	$scope.showLoginHelp = function(){
		var helpText = "1. Your username is your firstname.surname e.g if your name is Michael Rice your username is 'michael.rice'.\n 2. Your password shows up as soon as you select a course";
		$rootScope.showAlert('info',helpText,'Help')
	}
}]);


/***8**** registration controller ****8****/
app.controller('regCtrl', ['$scope','$http', function($scope,$http){
	$scope.feedback = "not yet sent";
	$scope.addUser = function(user){
	$http.post('http://localhost/stan/serverv2/public/newStudent', user).then(function(res){
		console.log(res.data);
		$scope.feedback = res.data.message;
	})
}
}]);


/*****8**** exams page controller ****8*****/
app.controller('examPageCtrl', ['$scope','$rootScope','$http','quizHandler','$timeout','$state', function($scope, $rootScope,$http,quizHandler,$timeout,$state){
	$scope.currentCourse = "Chemistry";	
	$scope.examTime = JSON.parse(localStorage.getItem('examTime'));

	var userid = null; 
	var coursesessid = null;
	$http.get('http://localhost/stan/serverv2/public/examSession').then(function(resp){
    	if(resp.data.courseid == ''){
    		$state.go('login');
    	}else{
    		coursesessid = resp.data.message.id;
    	}
	})
	$http.get('http://localhost/stan/serverv2/public/session').then(function(res){
    	if(res.data._id == ''){
    		$state.go('login');
    	}else{
    		userid = res.data._id;
    	}
	});

	function randQuestion(){
		for(var i=0; i<=$scope.questionsLength; i+=1){
			$scope.question = $scope.allQuestions[$scope.randomNumber].question;
			$scope.answer = $scope.allQuestions[$scope.randomNumber].answer;
			$scope.id = $scope.allQuestions[$scope.randomNumber].id;
			$scope.options = $scope.allQuestions[$scope.randomNumber].options[0];			
			break;
		};//end for loop
	};
	
	$scope.currentQuestion = 1;

	$scope.next = function(){
		return $scope.currentQuestion += 1;
	};

	$scope.getPercentageRemaining = function(){
		return (t.total/$scope.examTime.inSeconds) / 10;
	};
	$scope.answered = [];

	$scope.exists = function(){
		if(qid == $scope.answered[i].length && oid == $scope.answered[i].oid){
			return true;
		} else {
			return false
		}
	}

	/*$scope.pickAnswer = function(qid,oid){
		if ($scope.answered.length === 0) {
			$scope.answered.push({qid: qid, oid:oid});
			console.log(JSON.stringify($scope.answered));
		} else {
			for (var i = 0; i < $scope.answered.length; i++) {
				if(qid == $scope.answered[i].qid){
					console.log('question exists ooo');
					if(oid == $scope.answered[i].oid){
						//console.log(JSON.stringify($scope.answered[i]) + "is the " + i + 'th element and its values are still: ' + $scope.answered[i].qid + " and " + $scope.answered[i].oid);
						console.log('already picked');
					} else {
						$scope.answered[i].oid = oid;
						console.log(JSON.stringify($scope.answered));
					}
				}else{
					//console.log('wow new question');
					$scope.answered.push({qid: qid, oid:oid});
					console.log(JSON.stringify($scope.answered));
				}
				break;
			}
			//console.log($scope.answered.length);
		}
    };*/

    //console.log(quizHandler.getQuestions.testData);

    $scope.selectOption = function(question,option,all) {
    	//console.log(question,option);
    	all.forEach(function(elem,index,array){
    		if(elem.id == question.id){
    			elem.isAnswered = true;
    			elem.picked = option.id;
    			console.log('for question ' + elem.id + ' isAnswered isset to ' + elem.isAnswered + ' and the picked option is ' + elem.picked);
    			elem.options.forEach(function(obj,index,array){
    				if(obj.id !== option.id){
    					obj.selected = false;
    				};
    			});
    		};
    	});
    };

	//http get method
	$http.get('http://localhost/stan/app/assets/apis/questions.json').then(function(res){
		$rootScope.allQuestions = quizHandler.shuffle(res.data.questions);
		$scope.shuffleOptions();
		$scope.itemsPerPage = 1;
		

		$scope.navigator = function(index){
			if(index > 0 && index <= $rootScope.allQuestions.length){
				$scope.currentQuestion = index;
			}
		};
		$scope.$watch('currentQuestion + 1', function(){
        	var begin = (($scope.currentQuestion - 1) * $scope.itemsPerPage),
        	end = begin + $scope.itemsPerPage;

        	$scope.filteredQuestions = $rootScope.allQuestions.slice(begin, end);
		});

		function submitExams(data){
			$http.post('http://localhost/stan/serverv2/public/setResult', data).then(function(response){
				console.log(response.data);
				if(response.status == "success"){
					$state.go("login");
				}else{
					// sweet alert error submitting exams
				}
			});
		}

		$scope.extractor = function(){
			$scope.submittable = [];
			//gather the options for all the questions.
    		for (var i = $scope.allQuestions.length - 1; i >= 0; i--) {	
				$scope.submittable.push({qid: $scope.allQuestions[i].id, choice: $scope.allQuestions[i].picked});
			}
			console.log($scope.submittable);
			console.log(userid);
			console.log(coursesessid);

			var  quid = $scope.submittable;
			var userseesid = userid;
			var course_id = coursesessid;

			var dat = JSON.stringify({
				qnA : quid,
				userId : userseesid,
				courseId : course_id
			});

			console.log(dat);
			submitExams(dat);
		}


        $scope.submitQuiz = function(){
    		swal({   
	        title: "Submit Exam",   
	        text: "Are you sure you want to submit?",   
	        type: "warning",   
	        showCancelButton: true,   
	        confirmButtonColor: "#DD6B55",   
	        confirmButtonText: "Yes, submit!",   
	        cancelButtonText: "No, cancel!",   
	        closeOnConfirm: false,   
	        closeOnCancel: true 
	    }, function(isConfirm){  
	        if (isConfirm) {  
				swal("Success", "Your exam was successfully submitted.", "success");
				$scope.extractor();
	        }
	    });

    	}
	});
	/*end http get method*/

	$scope.shuffleOptions = function(){
		$rootScope.allQuestions.forEach(function(question){
			question.options = quizHandler.shuffle(question.options);
		});
	};	

		$scope.timerHandler = function(examTime){
				function getTimeRemaining(endtime) {
	  				var t = Date.parse(endtime) - Date.parse(new Date());
					var seconds = Math.floor((t / 1000) % 60);
					var minutes = Math.floor((t / 1000 / 60) % 60);
					var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
					var days = Math.floor(t / (1000 * 60 * 60 * 24));
					$scope.chartPercent = Math.floor((t / $scope.examTime.inSeconds) / 10);
					return {
					  'total': t,
					  'days': days,
					  'hours': hours,
					  'minutes': minutes,
					  'seconds': seconds,
					  'percent' : $scope.chartPercent
					};
				};

			function initializeClock(id, endtime) {
				var hours = document.getElementById('hours');
	  			var minutes = document.getElementById('minutes');
	  			var seconds = document.getElementById('seconds');
	  			function updateClock() {
	    			var t = getTimeRemaining(endtime);

	    			$timeout(function(){
	    					$scope.chartPercent = t.percent;
	    				}, 500)

	    			hours.innerHTML = ('0' + t.hours).slice(-2);
	    			minutes.innerHTML = ('0' + t.minutes).slice(-2);
	    			seconds.innerHTML = ('0' + t.seconds).slice(-2);

	    			if (t.total <= 0) {
	      				clearInterval(timeinterval);
	      				$scope.chartPercent = 0;
						  $rootScope.showAlert('warning','Your quiz would be submitted shortly','Time Up');
						  $scope.extractor();
						//   $scope.sendResponses()
						  //$scope.logout()
	      				console.log('Time up, to submit exam');
	    			} else{	    				
	    				$timeout(function(){
	    					$scope.chartPercent = t.percent;
	    				}, 500)
	    			};
	  			};

	  		updateClock();
	  		var timeinterval = setInterval(updateClock, 1000);
			};

			var deadline = new Date(Date.parse(new Date()) + examTime * 60 * 1000);
			return initializeClock('clockdiv', deadline);
		};

		if($scope.examTime.time <61){
			$scope.hour = true;
		};

		$scope.timerHandler($scope.examTime.time); //0.167 sets the timer to 10 seconds....this is to be changed to $scope.exam time which would 
		//be a property assigned to the current exam object and note the examtime param in the main function is in minutes
}]);
app.controller('testCtrl', ['$scope','quizHandler', function($scope,quizHandler){
	$scope.testing = quizHandler.hello();
	//$scope.allQuestions = quizHandler.getQuiz();
	
}])
app.controller('previewCtrl', ['$scope','$rootScope','$http','$state', function($scope,$rootScope,$http,$state){
	$rootScope.currentPage = 'preview';
	
    $http.get('http://localhost/stan/serverv2/public/session').then(function(res){
    	console.log(JSON.stringify(res));
    	if(res.status == 200){
    		$rootScope.exam = [];
    		$http.get('http://localhost/stan/serverv2/public/examSession').then(function(resp){
    			console.log(resp.data.message);
				if (resp.status == 200) {
					$rootScope.exam = resp.data.message;
				} else {
					$rootScope.exam = "";
				};

				if((res.data._id == '') || ($rootScope.exam == '')){
	    			console.log('sorry not logged');
	    			$rootScope.showAlert('error',"Sorry you're not logged in","Error");
	    			$state.go('login');
	    		} else{
					$scope.userInfo = res.data;
					$scope.examInfo = $rootScope.exam;					
				};
			})
    		
		} else {
			$rootScope.showAlert('error',"Sorry, an error occurred while logging you in","Error");
		};
	});

	$scope.Logout = function(){
		console.log("correct");
		$http.get('http://localhost/stan/serverv2/public/logout').then(function(res){
			$state.go('login');
		})
	}

	$scope.startExam = function(){
		swal({   
	        title: "Start Exam",   
	        text: "Are you sure you want to start exam ?",   
	        type: "warning",   
	        showCancelButton: true,   
	        confirmButtonColor: "#DD6B55",   
	        confirmButtonText: "Yes, continue!",   
	        cancelButtonText: "No, cancel!",   
	        closeOnConfirm: false,   
	        closeOnCancel: true 
	    }, function(isConfirm){  
	        if (isConfirm) {  
	            swal("Success", "Your exam would start soon.", "info");   
	            $state.go('main');
	        }
	    });
	}

	
	//for the part of not going back to the preview page, try to use a flag
	// to chaeck....when u click start exam, a flag is set so if it's true u cannot go back to 
	// preview but if its not u can go there....store in localstorage....
}]);

app.controller('adminCtrl', ['$scope','$rootScope','$http','$state', function($scope,$rootScope,$http,$state){

	$rootScope.thisPage = 'admin';
	$scope.isadmin = true;
	$scope.isMainAdmin = 1;

	$rootScope.adminInfo = {};

	$http.get('http://localhost/stan/serverv2/public/adminSession').then(function(res){
		$rootScope.adminInfo = res.data;
    		if(res.data.admin_id !== ''){
    			$state.go('admin.dashboard');
    		} else{
    			$state.go('adminLogin');
    		}
	});

	$scope.adminLogout = function(){
		$http.get('http://localhost/stan/serverv2/public/adminLogout').then(function(res){
			console.log(JSON.stringify(res.data));
			$rootScope.showAlert('success',res.data.message,'Success');
			$state.go('adminLogin');
		});
	};
}])