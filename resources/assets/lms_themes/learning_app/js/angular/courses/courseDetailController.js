var courseDetailJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('ModalRateCtrl', ModalRateCtrl)
	.controller('ModalChangeDateCtrl', ModalChangeDateCtrl)
	.controller('ModalAddLessonCtrl', ModalAddLessonCtrl)
	.controller('ModalDeleteLessonCtrl', ModalDeleteLessonCtrl)
	.controller('ModalShowRateCtrl', ModalShowRateCtrl)
	.controller('courseDetailCtrl', courseDetailCtrl);
	
	function courseDetailCtrl($scope, $timeout, $filter, $log, $uibModal,editableOptions, courseDetailSvc, NgTableParams, ngTableEventsChannel){
		/* jshint validthis: true */
		angular.element('#mod-class-detail').removeClass('hidden');
		editableOptions.theme = 'bs3';
		/*Variable*/
		$scope.isReadonly = true;
		$scope.lesson_trial = courseDetailSvc.formatLesson(window.course_lessons_trial);
		$scope.lessons = courseDetailSvc.formatLessons(window.course_lessons);
		$scope.course = window.course;
		$scope.count_table = 0;
		$scope.new_lesson = {
			course_id: $scope.course.id,
			note: $scope.course.note,
			learn_date: new Date(),
			duration: 0,
			title: '',
		};
		$scope.note = $scope.course.note;
		/*Function*/

		// console.log('test_courseDetail',$scope.lessons,$scope.course,'oo',$scope.lesson_trial);
		$scope.tableParams = createTable($scope.lessons);
		// console.log($scope.tableParams);
		$scope.sum = function(data, field){
			var s = 0;
			for (var i = 0; i < data.length; i++) {
				s += parseFloat(data[i][field]);
			}
			return s.toFixed(2);
		}

		$scope.addNote = function (course_id,note) {
			// console.log(course_id+''+note);
			var data = {
				course_id : course_id,
				note : note
			};
			courseDetailSvc.editNote(data);
		}
		$scope.deleteLessonPopup = function (lesson,trial) {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/pages/course/modals/popDeleteLesson.blade.php',
				controller: 'ModalDeleteLessonCtrl',
				resolve: {
					lesson: function () {
						return angular.copy(lesson);
					},
					trial: function () {
						return angular.copy(trial);
					}
				}
			});

			modalInstance.result.then(function (resp) {
				if(trial == 1){
					window.course_lessons_trial = null;
					$scope.lesson_trial = courseDetailSvc.formatLesson(window.course_lessons_trial);
				}
				else{
					for (var i = 0; i < $scope.lessons.length; i++) {
						if($scope.lessons[i].id == lesson.id){
							$scope.lessons.splice(i,1);
							break;
						}
					}
					$scope.tableParams = createTable($scope.lessons);
				}

			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});

		}
		$scope.clickRate = function (lesson_title, review, role, lesson_id, trial){
			// console.log('test1',lesson_title);
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/pages/course/modals/popReview.blade.php',
				controller: 'ModalRateCtrl',
				resolve: {
					review: function () {
						return angular.copy(review);
					},
					role: function () {
						return angular.copy(role);
					},
					lesson_id: function () {
						return angular.copy(lesson_id);
					},
					lesson_title: function () {
						return angular.copy(lesson_title);
					}
				}
			});

			modalInstance.result.then(function (resp) {
				if(resp.success == true){
					console.log('test',trial);
					if(typeof trial == 'undefined'){
						for (var i = 0; i < $scope.lessons.length; i++) {
							if($scope.lessons[i].id == lesson_id){
								if(role == 'teacher'){
									$scope.lessons[i].review_teacher = resp.data;
									console.log('rese',resp);
									break;
								}else{
									$scope.lessons[i].review_student = resp.data;
									console.log('resw',resp);
									break;
								}
							}
						}
					}else{
						if($scope.lesson_trial.id == lesson_id){
							if(role == 'teacher'){
								$scope.lesson_trial.review_teacher = resp.data;
							}else{
								$scope.lesson_trial.review_student = resp.data;
							}
						}
					}
				}
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		$scope.createLesson = function (){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/pages/course/modals/popAddLesson.blade.php',
				controller: 'ModalAddLessonCtrl',
				resolve: {
					course: function () {
						return angular.copy($scope.course);
					}
				}
			});

			modalInstance.result.then(function (resp) {
				$scope.lessons.push(resp);
				$scope.tableParams = createTable($scope.lessons);
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		$scope.updateLesson = function (type,lesson){
			courseDetailSvc.updateLesson(lesson).then(function(resp){
				console.log('res',resp);
				// if(type == 'learn_date'){
				// 	lesson = courseDetailSvc.formatLessonJS(lesson);
				// 	$scope.tableParams = createTable($scope.lessons);
				// }
			});
		}

		$scope.updateReview = function (lesson_id,role,review){
			if(role == 'teacher'){
				review.role_id = 7;
				review.lesson_id = lesson_id;
			}else{
				review.role_id = 6;
				review.lesson_id = lesson_id;
			}

			courseDetailSvc.updateReview(review).then(function(resp){
				if(resp.success == true && trial === null){
					if(trial === null){
						for (var i = 0; i < $scope.lessons.length; i++) {
							if($scope.lessons[i].id == lesson_id){
								if(role == 'teacher'){
									$scope.lessons[i].review_teacher = resp.data;
									break;
								}else{
									$scope.lessons[i].review_student = resp.data;
									break;
								}
							}
						}
					}else{
						if($scope.lessons_trial.id == lesson_id){
							if(role == 'teacher'){
								$scope.lessons_trial.review_teacher = resp.data;
							}else{
								$scope.lessons_trial.review_student = resp.data;
							}
						}
					}
				}
				console.log('res',resp);
			});
		}

		$scope.clickShowRate = function(lesson, role, review) {
			if (review != null) {
				var modalInstance = $uibModal.open({
					animation: true,
					templateUrl: '../../resources/views/lms_themes/learning_app/pages/course/modals/popShowRate.blade.php',
					controller: 'ModalShowRateCtrl',
					resolve: {
						lesson: function () {
							return angular.copy(lesson);
						},
						review: function () {
							return angular.copy(review);
						},
						role: function () {
							return angular.copy(role);
						}
					}
				});
			}
		}

		$scope.changeDate = function(lesson,trial){
			console.log('lelelel',lesson);
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/pages/course/modals/popShowRate.blade.php',
				controller: 'ModalChangeDateCtrl',
				resolve: {
					lesson: function () {
						return angular.copy(lesson);
					}
				}
			});

			modalInstance.result.then(function (resp) {
				if(typeof trial != 'undefined'){
					$scope.lesson_trial = resp;
				}else{
					for (var i = 0; i < $scope.lessons.length; i++) {
						if($scope.lessons[i].id == resp.id){
							$scope.lessons[i] = resp;
							$scope.tableParams = createTable($scope.lessons);
							break;
						}
					}
				}
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function createTable(data){
			// data.sort(function (a, b) {
			// 	if (a.learn_date > b.learn_date) {
			// 		return 1;
			// 	}
			// 	if (a.learn_date < b.learn_date) {
			// 		return -1;
			// 	}
			// 	return 0;
			// });
			// for (var i = 0; i < data.length; i++) {
			// 	data[i].index = i;
			// }
			angular.forEach(data, function(value, key){
				value.index = key + 1;
			});
			var table = new NgTableParams({
				filter:{},
				sorting: { learn_date: "asc" },
				group: 'mounth',
				count:1000
			},{
				counts: [],
				dataset: data
			});
			return table;
		}
	}

	//Controller Popup ModalRateCtrl.
	function ModalRateCtrl($scope, $http, $uibModalInstance, courseDetailSvc, review, role, lesson_id, lesson_title){
		/* jshint validthis: true */
		$scope.trans = window.trans;
		$scope.role = role;
		$scope.lesson_title = lesson_title;
		if(review == null || review.rate == 0 || !review.rate || review.rate==1){
			if(role == 'student'){
				$scope.review = {
					'teaching_content': 0,
					'teaching_method': 0,
					'network_quality': 0,
					'attitude_work': 0,
					'value_received': 0,
					'content':'',
				};
			}else{
				$scope.review = {
					'rate': 0,
					'content':'',
				};
			}
		}else{
			$scope.review = review;
		}

		$scope.save = function (valid) {
			$scope.submited = true;
			if(!valid) return;

			if(role == 'teacher'){
				$scope.review.role_id = 7;
				$scope.review.lesson_id = lesson_id;
			}else{
				$scope.review.role_id = 6;
				$scope.review.lesson_id = lesson_id;
			}
			if(role == 'student'){
				$scope.review.rate = (
					$scope.review.teaching_content+
					$scope.review.teaching_method+$scope.review.network_quality+
					$scope.review.attitude_work+$scope.review.value_received
					)/5;
			}
			courseDetailSvc.updateReview($scope.review).then(function(resp){
				if(resp.success == true){
					$uibModalInstance.close(resp);
					console.log('res',resp);
				}
			});
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalChangeDateCtrl.
	function ModalChangeDateCtrl($scope, $uibModalInstance, courseDetailSvc, lesson){
		/* jshint validthis: true */
		$scope.trans = window.trans;
		$scope.lesson = lesson;
		$scope.open  = false;
		$scope.openCalendar = function($event){
			$scope.open = true;
		}

		$scope.save = function (valid) {
			$scope.submited = true;
			if(!valid) return;
			courseDetailSvc.updateLesson($scope.lesson).then(function(resp){
				console.log('res',resp);
				$scope.lesson = courseDetailSvc.formatLessonJS($scope.lesson);
				$uibModalInstance.close($scope.lesson);
			});
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalAddLessonCtrl.
	function ModalAddLessonCtrl($scope, $http,$uibModalInstance, courseDetailSvc, course){
		/* jshint validthis: true */
		$scope.trans = window.trans;
		$scope.lesson = {
			course_id: course.id,
			title: '',
			learn_date: '',
			duration: ''
		};
		$scope.open  = false;
		$scope.openCalendar = function($event){
			$scope.open = true;
		}

		$scope.save = function (valid) {
			$scope.submited = true;
			if(!valid) return;
			console.log('sss',$scope.lesson);

			courseDetailSvc.createLesson($scope.lesson).then(function(resp){
				console.log('res',resp);
				if(resp.success == true){
					resp.data.review_teacher = null;
					resp.data.review_student = null;
					resp.data = courseDetailSvc.formatLesson(resp.data);
					$uibModalInstance.close(resp.data);
				}
			});
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalDeleteLessonCtrl.
	function ModalDeleteLessonCtrl($scope, $http, $uibModalInstance, courseDetailSvc, lesson, trial) {
		$scope.trans = window.trans;
		$scope.lesson_name = lesson.title;
		$scope.save = function (valid) {
			courseDetailSvc.deleteLesson({lesson_id : lesson.id});
			$uibModalInstance.close();
		};
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	function ModalShowRateCtrl($scope, $http, $uibModalInstance ,lesson, role, review) {
		$scope.trans = window.trans;
		$scope.role = role;
		$scope.lesson_title = lesson.title;
		if(review == null || review.rate == 0 || !review.rate || review.rate==1){
			if(role == 'student'){
				$scope.review = {
					'teaching_content': 0,
					'teaching_method': 0,
					'network_quality': 0,
					'attitude_work': 0,
					'value_received': 0,
					'content':'',
				};
			}else{
				$scope.review = {
					'rate': 0,
					'content':'',
				};
			}
		}else{
			$scope.review = review;
		}

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}
})();