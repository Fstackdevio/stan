var app = angular.module('ngQuiz');
app.service('quizHandler',['$http', function($http){
    this.hello = function(){
        return "Hello world because quizHandler.hello is working";
    };
    //shuffle method
    this.shuffle = function(array){
        var length = array.length, temp, randomNumber;
        while(0 != length){
            randomNumber = Math.floor(Math.random() * length);
            length -= 1;
            temp = array[length];
            array[length] = array[randomNumber];
            array[randomNumber] = temp;
            // works like the swap algorithm: temp=a, a=b, b=temp
        };
        return array;
    };
    this.booleanConverter = function(str){
        if(val == 'true' || val == 'True' || val == true){
            return true;
        } else if(val == 'undefined' || val == null || val == '' || val == 'false' || val == 'False'){
            return false;
        } else {
            return "unidentified expression";
        };
    };
    this.getQuestions = function(){
        return {
         questions: $http.get('http://localhost/stan/app/assets/apis/questions.json').then(function(res){
                        console.log((res.data.questions));
                        return res.data;
                    }), 
         testData : getQuestion.question
        }
    }

}]);
app.factory('ExamData', ['$http', function($http){
    $http.defaults.headers.post["Content-Type"] = "application/x-www-form-urlencoded";

    var retVal = {};

    retVal.get = function(){
        return $http.get('http://localhost/stan/app/assets/apis/exams.json').success(function(res,stat){
            return res.data;
        })
    };
    retVal.post = function(){
        return "post method";
    };
    retVal.put = function(){
        return 'put method';
    };
    retVal.delete = function(){
        return 'delete Method';
    };

    return retVal;
}]);