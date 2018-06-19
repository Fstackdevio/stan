var app = angular.module('ngQuiz');
app.config(['$urlRouterProvider', '$stateProvider', '$locationProvider', function($urlRouterProvider, $stateProvider, $locationProvider) {
	$urlRouterProvider.otherwise('/login');

	// $locationProvider.html5Mode(true);
	// $locationProvider.html5Mode({
	// 	enabled: true,
	// 	requireBase: false
	//   });

	$stateProvider
	.state('login', {
		url: '/login',
		templateUrl: 'assets/tpl/login.html'
	})
	.state('adduser', {
		url: '/addUser',
		templateUrl: 'assets/tpl/addUser.html'
	})
	.state('result', {
		url: '/result',
		templateUrl: 'assets/tpl/result.html'
	})
	.state('main', {
		url: '/main',
		templateUrl: 'assets/tpl/exampg.html'
	})
	.state('dashboard', {
		url: '/dashboard',
		templateUrl: 'assets/tpl/dashboard.html'
	})
	.state('preview', {
		url: '/preview',
		templateUrl: 'assets/tpl/preview.html'
	})
	.state('admin', {
            url: '/admin',
            /*views: {
              '': {
                templateUrl: 'views/layout.html'
              },
              'aside': {
                templateUrl: 'views/aside.html'
              },
              'content': {
                templateUrl: 'views/content.html'
              }
            }*/
            templateUrl: 'assets/tpl/admin/admin.html'
    })
	.state('adminLogin', {
		url: '/admin/login',
		templateUrl: 'assets/tpl/admin/login.html'
	})
	.state('admin.dashboard', {
		url: '/dashboard',
		templateUrl: 'assets/tpl/admin/dashboard.html'
	})

	//--- admin.downloads route section
	.state('admin.downloadHistory', {
		url: '/download-history',
		templateUrl: 'assets/tpl/admin/downloads/history.html'
	})
	/*.state('admin.download', {
		url: '/download/',
		templateUrl: 'assets/tpl/admin/downloads/history.html'
	})*/
	//--- admin.downloads route section end

	//--- admin.exams route section
	.state('admin.createExam', {
		url: '/create-exam',
		templateUrl: 'assets/tpl/admin/exams/add.html'
	})
	.state('admin.viewExam', {
		url: '/view-exams',
		templateUrl: 'assets/tpl/admin/exams/view.html'
	})
	.state('admin.editExam', {
		url: '/edit-exam/:data',
		params: {
			data: {
				array: true
			}
		},
		templateUrl: 'assets/tpl/admin/exams/edit.html'
	})
	.state('admin.downloadExam', {
		url: '/delete-exam',
		templateUrl: 'assets/tpl/admin/exams/download.html'
	})
	//--- admin.exams route section end

	//--- admin.questions route section
	.state('admin.addQuestion', {
		url: '/add-question',
		templateUrl: 'assets/tpl/admin/questions/add.html'
	})
	.state('admin.viewQuestion', {
		url: '/view-questions',
		templateUrl: 'assets/tpl/admin/questions/view.html'
	})
	.state('admin.editQuestion', {
		url: '/edit-question',
		templateUrl: 'assets/tpl/admin/questions/edit.html'
	})
	.state('admin.downloadQuestion', {
		url: '/download-question',
		templateUrl: 'assets/tpl/admin/questions/download.html'
	})
	//--- admin.questions route section end

	//--- admin.result route section
	.state('admin.viewResult', {
		url: '/view-result',
		templateUrl: 'assets/tpl/admin/results/view.html'
	})
	.state('admin.downloadResult', {
		url: '/download-result',
		templateUrl: 'assets/tpl/admin/results/download.html'
	})
	//--- admin.result route section end

	//admin.students route section start
	.state('admin.addStudent', {
		url: '/register-student',
		templateUrl: 'assets/tpl/admin/students/add.html'
	})
	.state('admin.viewStudent', {
		url: '/view-students',
		templateUrl: 'assets/tpl/admin/students/view.html'
	})
	.state('admin.editStudent', {
		url: '/edit-student/:data',
		params: {
			data: {
				array: true
			}
		},
		templateUrl: 'assets/tpl/admin/students/edit.html'
	})
	.state('admin.downloadStudent', {
		url: '/download-students',
		templateUrl: 'assets/tpl/admin/students/download.html'
	})
	//--- admin.students route section end
	.state('admin.help', {
		url: '/help',
		templateUrl: 'assets/tpl/admin/help.html'
	})
}]);