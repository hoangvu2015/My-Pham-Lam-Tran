// (function(){
// 	'use strict';

// 	angular
// 	.module('App')
// 	.factory('teacherFac', teacherFac)
// 	.service('teacherSvc', teacherSvc);

// 	function teacherFac($resource){
// 		return $resource(settingJs.baseUrlApi + settingJs.apiVersion + '/:method/:id', {method:'@method', id: '@id'},{
// 			save: {
// 				headers:{ "Content-Type": "text/plain; charset=utf-8" },
// 				method: 'POST'
// 			},
// 			get: {
// 				headers:{ "Content-Type": "text/plain; charset=utf-8" },
// 				method: 'GET'
// 			}
// 		});
// 	}

// 	function teacherSvc(){
// 		var $this = {};
// 		// console.log(123);
// 		// $this.updateStatus = function(data){
// 		// 	return teacherFac.$save(data,{method:'update-status-teacher'}).$promise;
// 		// }
// 		$this.test = function(){
// 			console.log('test');
// 		}

// 		return $this;
// 	}
	
// })();