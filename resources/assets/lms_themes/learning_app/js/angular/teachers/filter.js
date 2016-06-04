var teacherJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.filter('teacherFilter', teacherFilter)
	.filter('teacherFilterTopics', teacherFilterTopics);

	function teacherFilterTopics() {

		return function(input,filters) {
			var out = [];
			angular.forEach(input, function(value,index){
				if(filters.topics.length == 0){
					out = angular.copy(input);
				}else {
					if(value.id_topic.length != 0 ){
						for(var i=0; i<filters.topics.length; i++){
							var flat = in_array(filters.topics[i],value.id_topic);
							if(flat == true){
								out.push(value);
								break;
							}
						}
					}
				}
			})

			return out;
		}
	}

	function teacherFilter() {

		return function(input,filters) {
			var out = [];
			if(filters.nationality == ''){
				out = angular.copy(input);
			}else{
				angular.forEach(input, function(value,index){
					if(filters.nationality == value.nationality){
						out.push(value);

					}
				})
			}
			
			var out1 = [];
			if(filters.gender == ''){
				out1 = angular.copy(out);
			}else{
				angular.forEach(out, function(value,index){
					if(filters.gender == value.gender){
						out1.push(value);
					}
				})
			}

			var out2 = [];
			if(filters.topics.length == 0){
				out2 = angular.copy(out1);
			}else{
				angular.forEach(out1, function(value,index){
					if(value.id_topic.length != 0 ){
						for(var i=0; i<filters.topics.length; i++){
							var flat = in_array(filters.topics[i],value.id_topic);
							if(flat == true){
								out2.push(value);
								break;
							}
						}
					}
				})
			}

			return out2;
		}
	}

})();