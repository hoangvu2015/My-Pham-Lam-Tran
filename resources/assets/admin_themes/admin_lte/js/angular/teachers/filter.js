var teacherJs = (function(){
	'use strict';

	angular
	.module('App')
	.filter('teacherFilterSearch', teacherFilterSearch);

	function teacherFilterSearch() {
		function formatDate(string) {
			var date = string.split(' ');
			var dateString = date[0];
			var timeString = date[1];
			var day = dateString.split('-')[2];
			var month = dateString.split('-')[1];
			var year = dateString.split('-')[0];
			var hour = timeString.split(':')[0];
			var minute = timeString.split(':')[1];
			var second = timeString.split(':')[2];
			return new Date(month+"/"+day+"/"+year+" "+hour+":"+minute+":"+second);
		}
		function checkDate(value, date) {
			if(date != ""){
				var dateStart = formatDate(date.split(" - ")[0]);
				var dateEnd = formatDate(date.split(" - ")[1]);
				var dateCheck = formatDate(value.created_at);
				if (dateStart <= dateCheck && dateCheck <= dateEnd)	return true;
				return false;
			}
			return true;
		}

		function checkContain(string, substring) {
			if(string.toLowerCase().indexOf(substring.toLowerCase()) > -1) return true;
			return false;
		}

		function checkFilterText(value, string) {
			if(string != ""){
				// if(checkContain(value.name, string) || checkContain(value.email, string) || checkContain(value.skype, string)
				// 	|| checkContain(value.phone, string)) return true;
				// 	return false;
				if(checkContain(value.name, string)){
					return true;
				}
				else if(checkContain(value.email, string)){
					return true;
				}
				else if(checkContain(value.skype, string)){
					return true;
				}
				else if(checkContain(value.phone, string)){
					return true;
				}
				return false;
			}
			return true;
		}

		return function(teachers,search) {
			var out = [];
			// console.log('ololo',teachers);
			var string = search[0];
			var date = search[1];
			angular.forEach(teachers, function(value,index){
				if(checkDate(value,date) && checkFilterText(value,string)){
					out.push(value);
				}
			})
			return out;
		}
	}
})();