function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var daysSpan = clock.querySelector('.days');
  var hoursSpan = clock.querySelector('.hours');
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  function updateClock() {
    var t = getTimeRemaining(endtime);

    daysSpan.innerHTML = t.days;
    hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
    minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
    secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

    if (t.total <= 0) {
      clearInterval(timeinterval);
    }
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
}

var deadline = new Date(Date.parse(new Date()) + 15 * 24 * 60 * 60 * 1000);
initializeClock('clockdiv', deadline);


=======Ctrl backup with the store arrY WORKING well (at point of not repiting if going 4wd) =====
'use strict';
var app = angular.module('ngQuiz');

app.controller('ngQuiz', ['$scope','$rootScope', function($scope,$rootScope){
  $rootScope.app = {
    title: "QuizApp",
    schoolName: "Testing School"
  };

  $rootScope.showAlert = function(type,msg,title){
    swal({
      type: type,
      text: msg,
      title: title
    })
  };
  $rootScope.chartOptions = {
    animate: 1000,
    barColor:'#03A9F4',
    scaleColor: false,
    lineWidth: 3,
    lineCap: 'circle',
    size: 100
  };
}]);

app.controller('timerCtrl', ['$scope', function($scope){
  
}])

app.controller('loginCtrl', ['$scope','$http','$rootScope','$state', function($scope,$http,$rootScope,$state){
  /*****8**** alert function for all login alerts ***8*****/
  /*$rootScope.showAlert = function(type,msg,title){
    swal({
      type: type,
      text: msg,
      title: title
    })
  };*/

  $rootScope.exams = {};

  $scope.selectedExam = "Select a course";

  $scope.pwd= '';

  /*****8**** array for the exam password ****8*****/
  $http.get('http://localhost/stan/app/assets/apis/exams.json')
    .then(function(res){
      //console.log(res.data[0]);
      $rootScope.exams = res.data;

      $rootScope.showPassword = function(selected){     
        for(var i=0;i<$rootScope.exams.length;i++){
          if(selected == $rootScope.exams[i].name){
            return $scope.exams[i].pwd;
            console.log($scope.exams[i].pwd);
          }
        }
      };
    });
  

  /*****8**** the main login function ****8*****/
  $scope.login = function(form,selectedExam){
    if(form.password == $rootScope.showPassword(selectedExam)){
      $http.post('http://localhost/stan/server/v1/login', form)
      .then(function(res){
        if(res.data.status == "success"){
          //console.log("logged in");

          for(var i=0;i<=$rootScope.exams.length;i++){
            if(form.password == $rootScope.exams[i].pwd){
              //console.log($rootScope.exams[i].duration);
              localStorage.setItem('examTime', JSON.stringify({time: $rootScope.exams[i].duration, inSeconds:$rootScope.exams[i].duration*60}));

              $state.go('main');
            };
          };

          $rootScope.userInfo = res.data;
          console.log($rootScope.userInfo);
          $rootScope.showAlert(res.data.status,res.data.message,res.data.status);
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
}]);


/***8**** registration controller ****8****/
app.controller('regCtrl', ['$scope','$http', function($scope,$http){
  $scope.feedback = "not yet sent";
  $scope.addUser = function(user){
  $http.post('http://localhost/stan/server/v1/newStudent', user).then(function(res){
    console.log(res.data);
    $scope.feedback = res.data.message;
  })
}
}]);


/*****8**** exams page controller ****8*****/
app.controller('examPageCtrl', ['$scope','$rootScope','$http','quizHandler', function($scope, $rootScope,$http,quizHandler){
  $scope.currentCourse = "Chemistry"; 
  $scope.examTime = JSON.parse(localStorage.getItem('examTime'));

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

  $scope.pickAnswer = function(qid,oid){
    if ($scope.answered.length === 0) {
      $scope.answered.push({qid: qid, oid:oid});
      console.log(JSON.stringify($scope.answered));
    } else {
      for (var i = $scope.answered.length - 1; i >= 0; i--) {
        if(qid == $scope.answered[i].qid){
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
    }
    

  $http.get('http://localhost/stan/app/assets/apis/questions.json').then(function(res){
    $rootScope.allQuestions = quizHandler.shuffle(res.data.questions);
    $scope.itemsPerPage = 1;
    //$scope.filteredQuestions = $rootScope.allQuestions;

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
  });

    $scope.timerHandler = function(examTime){
        function getTimeRemaining(endtime) {
            var t = Date.parse(endtime) - Date.parse(new Date());
          var seconds = Math.floor((t / 1000) % 60);
          var minutes = Math.floor((t / 1000 / 60) % 60);
          var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
          var days = Math.floor(t / (1000 * 60 * 60 * 24));
          return {
            'total': t,
            'days': days,
            'hours': hours,
            'minutes': minutes,
            'seconds': seconds
          };
        };

      function initializeClock(id, endtime) {
        var hours = document.getElementById('hours');
          var minutes = document.getElementById('minutes');
          var seconds = document.getElementById('seconds');

          function updateClock() {
            var t = getTimeRemaining(endtime);

            hours.innerHTML = ('0' + t.hours).slice(-2);
            minutes.innerHTML = ('0' + t.minutes).slice(-2);
            seconds.innerHTML = ('0' + t.seconds).slice(-2);

            if (t.total <= 0) {
                clearInterval(timeinterval);
                $scope.chartPercent = 0;
                $scope.$watch('chartPercent - 1', function(){
                  $scope.chartPercent = 50;
                })
                //$rootScope.showAlert('warning','Your quiz would be submitted shortly','Time Up');
                console.log('timeUp');
            } else{
              $scope.chartPercent = Math.floor((t.total/$scope.examTime.inSeconds) / 10);
              //console.log($scope.chartPercent);
              $scope.$watch('chartPercent', function(){
                $scope.chartPercent = $scope.chartPercent;
              })
            };
          };

        updateClock();
        var timeinterval = setInterval(updateClock, 1000);
      };

      var deadline = new Date(Date.parse(new Date()) + examTime * 60 * 1000);
      //console.log(deadline);
      return initializeClock('clockdiv', deadline);
    };

    if($scope.examTime.time <61){
      $scope.hour = true;
    };

    $scope.timerHandler($scope.examTime.time); //0.167 sets the timer to 10 seconds....this is to be changed to $scope.exam time which would 
    //be a property assigned to the current exam object and note the examtime param in the main function is in minutes

    //complete work on the time -> chart relationship

}]);

app.controller('chartCtrl', ['$scope', function ($scope) {
      $scope.percent = 65;
      $scope.anotherPercent = -45;
      //console.log($scope.percent);
      $scope.anotherOptions = {
        animate:{
          duration:0,
          enabled:false
        },
        barColor:'#2C3E50',
        scaleColor:false,
        lineWidth:20,
        lineCap:'circle'
      };
    }]);

app.controller('testCtrl', ['$scope','quizHandler', function($scope,quizHandler){
  $scope.testing = quizHandler.hello();
  //$scope.allQuestions = quizHandler.getQuiz();
  
}])