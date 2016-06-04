var courseDetailJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.factory('courseDetailFac', courseDetailFac)
	.service('courseDetailSvc', courseDetailSvc);

	function courseDetailFac($resource){
		return $resource(window.url+'/api/v1' + '/:method', {method:'@method'},{
			save: {
				method: 'POST'
			},
			get: {
				method: 'GET'
			}
		});
	}

	function courseDetailSvc(courseDetailFac){
		var $this = {};
		//Api
		$this.createLesson = function(data){
			var dataSend = new courseDetailFac(data);
			return dataSend.$save({method:'create-lesson'});
		}
		$this.updateLesson = function(data){
			var dataSend = new courseDetailFac(data);
			return dataSend.$save({method:'update-lesson'});
		}
		$this.updateReview = function(data){
			var dataSend = new courseDetailFac(data);
			return dataSend.$save({method:'update-review'});
		}
		$this.editNote = function (data) {
			var dataSend = new courseDetailFac(data);
			return dataSend.$save({method:'edit-note'});
		}
		$this.deleteLesson = function (data) {
			var dataSend = new courseDetailFac(data);
			return dataSend.$save({method: 'delete-lesson'});
		}
		//furture
		$this.test = function(){
			console.log('test');
		}

		$this.formatLessons = function(lessons){
			//format mounth lesson
			angular.forEach(lessons, function(value,index){
				// console.log('before',value.learn_date);
				var arr1 = value.learn_date.split("/");
				var arr2 = [arr1[1],arr1[0],arr1[2]];
				var str =  arr2.join('/');
				//fix firefox coccoc
				if(typeof arr1[1] == 'undefined'){
					var arr0 = value.learn_date.split("-");
					var arr1 = String(arr0[2]).split(' ');
					arr2 = [arr0[1],arr1[0],arr0[0]];
					var str0 =  arr2.join('/');
					var arr3 = [str0,arr1[1]];
					str = arr3.join(' ');
				}
				value.learn_date = new Date(str);
				if(parseInt(value.learn_date.getMonth()+1) < 10){
					var tmp = 0+''+parseInt(value.learn_date.getMonth()+1);
				}else{
					var tmp = parseInt(value.learn_date.getMonth()+1)
				}
				// value.mounth = tmp +'/'+ value.learn_date.getFullYear();
				value.mounth = [value.learn_date.getFullYear(),tmp];
			});
			return lessons;
		}

		$this.formatLesson = function(lesson){
			//format mounth lesson
			if(lesson){
				var arr1 = lesson.learn_date.split("/");
				var arr2 = [arr1[1],arr1[0],arr1[2]];
				var str =  arr2.join('/');
				//fix firefox coccoc
				if(typeof arr1[1] == 'undefined'){
					var arr0 = lesson.learn_date.split("-");
					var arr1 = String(arr0[2]).split(' ');
					arr2 = [arr0[1],arr1[0],arr0[0]];
					var str0 =  arr2.join('/');
					var arr3 = [str0,arr1[1]];
					str = arr3.join(' ');
				}
				lesson.learn_date = new Date(str);
				if(parseInt(lesson.learn_date.getMonth()+1) < 10){
					var tmp = 0+''+parseInt(lesson.learn_date.getMonth()+1);
				}else{
					var tmp = parseInt(lesson.learn_date.getMonth()+1)
				}
				lesson.mounth = tmp +'/'+ lesson.learn_date.getFullYear();
			}
			
			return lesson;
		}

		$this.formatLessonJS = function(lesson){
			//format mounth lesson
			if(lesson){
				lesson.learn_date = new Date(lesson.learn_date);
				if(parseInt(lesson.learn_date.getMonth()+1) < 10){
					var tmp = 0+''+parseInt(lesson.learn_date.getMonth()+1);
				}else{
					var tmp = parseInt(lesson.learn_date.getMonth()+1)
				}
				lesson.mounth = tmp +'/'+ lesson.learn_date.getFullYear();
			}
			
			return lesson;
		}

		return $this;
	}
	
})();