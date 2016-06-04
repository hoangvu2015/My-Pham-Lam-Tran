var submitReviewJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('submitReviewCtrl', submitReviewCtrl);

	function submitReviewCtrl($rootScope, $scope, submitReviewSvc){
		$scope.course = window.course;
		$scope.review = window.review.length == 0 ? {} : window.review;
		$scope.learner = window.learner;
		$scope.review.course_id = $scope.review.course_id == undefined ? $scope.course.id : $scope.review.course_id;
		$scope.review.user_id = $scope.learner.id;
		$scope.review.role_id = 6;
		$scope.review.approved = 1;
		$scope.review.course = $scope.course.title;
		$scope.review.learn_time = $scope.course.learning_hours;
		$scope.submit = false;

		$scope.updateReview = updateReview;

		function sumRate() {
			var sumArray = [];
			var sum = 0;
			sumArray.push($scope.review.teaching_content);
			sumArray.push($scope.review.network_quality);
			sumArray.push($scope.review.teaching_method);
			sumArray.push($scope.review.attitude_work);
			sumArray.push($scope.review.value_received);
			angular.forEach(sumArray, function(value, key){
				if (value != undefined) {
					sum += value;
				}
				else{
					$scope.valid = false;
				}
			});
			$scope.review.rate = parseFloat((sum/5).toFixed(1));
		}

		function updateReview() {
			$scope.submit = true;
			$scope.valid = true;
			sumRate();
			console.log($scope.review);
			if($scope.valid){
				submitReviewSvc.updateReviewCourse({'review' : $scope.review, 'tutor' : window.tutor}).then(function(resp) {
					if (resp.success == true) {
						angular.element(".submit-btn").removeAttr('disabled');
						window.location.href = window.link;
					}
				}, function(resp) {
					console.log(resp);
				});
			}
			angular.element(".submit-btn").removeAttr('disabled');
		}
	}
})();