var submitReviewJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.factory('submitReviewFac', submitReviewFac)
	.service('submitReviewSvc', submitReviewSvc);

	function submitReviewFac($resource){
		return $resource(window.url+'/api/v1' + '/:method', {method:'@method'},{
			save: {
				method: 'POST'
			},
			get: {
				method: 'GET'
			}
		});
	}

	function toObj(array) {
		var obj = {};
		angular.forEach(array, function(value, key){
			obj[key] = value;
		});
		return obj;
	}
	function submitReviewSvc(submitReviewFac){
		var $this = {};

		$this.updateReviewCourse = function(data){
			var dataSend = new submitReviewFac(data);
			return dataSend.$save({method:'update-review-course'});
		}
		return $this;
	}
})();