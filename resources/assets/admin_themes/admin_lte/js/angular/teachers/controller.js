var teacherJs = (function(){
	'use strict';

	angular
	.module('App')
	.controller('teachCtrl', teachCtrl)
	.controller('ModalConfirmCtrl', ModalConfirmCtrl)
	.controller('ModalInstanceCtrl', ModalInstanceCtrl);

	function teachCtrl($rootScope, $scope, $http, $timeout, $filter, $uibModal, $log, $compile, NgTableParams, ngTableEventsChannel){
		/* jshint validthis: true */
		var teacher = this;
		$scope.urlEditTeacher = window.urlEdit.split("{id}");
		$scope.urlEditPayment = window.urlPayment.split("{id}");
		$scope.urlAddReviewTeacher = window.urlAddReview.split("{id}");
		/*Variable*/
		$scope.teachersAll = window.teachersAll;
		$scope.teachersAll  = formatData($scope.teachersAll);
		$scope.filters = {};
		$scope.teacher = {};
		$scope.search = {
			full:''
		};
		// $scope.datePicker = {date :{startDate: window.startDate, endDate: window.endDate}};
		// $scope.datetime_js_format = window.datetime_js_format;
		console.log($scope.teachersAll);

		/*Function*/
		setColorStatus();
		$scope.clickEdit = clickEdit;
		$scope.clickStatusApprover = clickStatusApprover;
		$scope.changeSearch = changeSearch;
		$scope.changeFilter = changeFilter;
		$scope.changeDate = changeDate;
		$scope.changeEditStatus = changeEditStatus;
		$scope.clickReset = clickReset;
		$scope.editNote = editNote;

		// console.log('teachCtrl', $scope.teachersAll);
		$scope.exportData = exportData;
		angular.element('#listTeach').removeClass('hidden')

		$scope.tableParams = new NgTableParams({filter:{}}, { dataset: $scope.teachersAll});

		//Event when change pages
		ngTableEventsChannel.onAfterReloadData(function(){
			$timeout(function(){
				afterReloadTable();
				setColorStatus();
				// console.log('change');
			},100);
		}, $scope);

		function clickEdit(id){
			console.log('gg',id);
		}

		function changeSearch(){
			$scope.teachersAll = formatData(window.teachersAll);
			if(typeof $scope.filters.full == 'undefined') $scope.filters.full = "";
			if($scope.filters.date_filter == "Invalid date - Invalid date"){
				$scope.filters.date_filter = "";
			}
			var array = [$scope.filters.full, $scope.filters.date_filter];
			if($scope.filters.full == "" && $scope.filters.date_filter == ""){
				$scope.tableParams = new NgTableParams({filter:{}}, { dataset: $scope.teachersAll});
			}
			else{
				$scope.teachersAll = $filter('teacherFilterSearch')($scope.teachersAll,array);
				$scope.tableParams = new NgTableParams({filter:$scope.tableParams.filter()}, { dataset: $scope.teachersAll});
			}
		}

		function changeFilter(field, value){
			var filter = {};
			if(field == 'gender'){
				filter['user_profile'] = {};
				filter['user_profile'][field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}
			if(field == 'country'){
				filter = {};
				filter[field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}else{
				filter[field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}
		}
		function changeDate() {
			if($scope.filters.date_filter == "Invalid date - Invalid date"){
				$scope.filters.date_filter = "";
			}
			else{
				var array = [1,$scope.filters.date_filter];
				$scope.teachersAll = formatData(window.teachersAll);
				$scope.teachersAll = $filter('teacherFilterSearch')($scope.teachersAll,array);
				$scope.tableParams = new NgTableParams({filter:$scope.tableParams.filter()}, { dataset: $scope.teachersAll});
			}
		}
		function clickStatusApprover(nameStatus, item, index){
			if(nameStatus == 'approver'){
				var statusName = 'approve '+item.name;
				angular.element('.approverBtn').attr('disabled', 'true');
			}else if(nameStatus == 'deny'){
				var statusName = 'deny '+item.name;
				angular.element('.denyBtn').attr('disabled', 'true');
			}

			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/admin_themes/admin_lte/pages/teacher/modals/confirmPop.blade.php',
				controller: 'ModalConfirmCtrl',
				resolve: {
					statusName: function () {
						return statusName;
					}
				}
			});
			console.log(item);

			modalInstance.result.then(function (checkEmail) {
				item.checkEmail = checkEmail;
				if(nameStatus == 'approver'){
					item.approver_status = 1;
				}else if(nameStatus == 'deny'){
					item.approver_status = 2;
				}
				$http({
					method: 'POST',
					url: url+'/api/v1/update-status-teacher',
					data:item
				}).then(function(resp){
					angular.forEach($scope.teachersAll, function(value,index1){
						angular.element('.approverBtn').removeAttr('disabled');
						angular.element('.denyBtn').removeAttr('disabled');
						if(value.id == item.id){
							if(nameStatus == 'approver'){
								$scope.teachersAll.splice(index,1);
								$scope.tableParams.reload();
							}else if(nameStatus == 'deny'){
								value.approver_status = 2;
							}
						}
					})
				});
			}, function () {
				angular.element('.approverBtn').removeAttr('disabled');
				angular.element('.denyBtn').removeAttr('disabled');
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function changeEditStatus(nameStatus, item, value, index){
			var tmp = angular.copy(item);
			if(nameStatus == 'teaching_status'){
				tmp.teaching_status = value;
				var cssId = '#teaching_status'+index;
				if(value == 0){
					angular.element(cssId).css('color', '#2196F3');
				}
				if(value == 1){
					angular.element(cssId).css('color', '#00BCD4');
				}
				if(value == 2){
					angular.element(cssId).css('color', '#4CAF50');
				}
				if(value == 3){
					angular.element(cssId).css('color', '#FF9800');
				}
				if(value == 4){
					angular.element(cssId).css('color', '#F44336');
				}
			}else if(nameStatus == 'available_status'){
				tmp.available_status = value;
				var cssId = '#available_status'+index;
				if(value == 0){
					angular.element(cssId).css('color', '#2196F3');
				}
				if(value == 1){
					angular.element(cssId).css('color', '#4CAF50');
				}
				if(value == 2){
					angular.element(cssId).css('color', '#F44336');
				}
			}else{
				tmp.publish_status = value;
				var cssId = '#publish_status'+index;
				if(value == 0){
					angular.element(cssId).css('color', 'red');
				}
				if(value == 1){
					angular.element(cssId).css('color', 'green');
				}
			}
			$http({
				method: 'POST',
				url: url+'/api/v1/update-status-teacher',
				data:tmp
			}).then(function(resp){
				angular.forEach(teachersAll, function(value,index){
					if(value.id == tmp.id){
						console.log(resp);
						value.teaching_status = tmp.teaching_status;
						value.available_status = tmp.available_status;
						value.publish_status = tmp.publish_status;
					}
				})
			});
		}

		function formatData (data){
			angular.forEach(data, function(value,index){
				value.show_topic = '';
				if(value.user_profile.gender == 'female'){
					value.gender = 'fe';
				}else{
					value.gender = value.user_profile.gender;
				}
				// if(value.topics.length > 0){
				// 	angular.forEach(value.topics, function(value1,index1){
				// 		if(index1 == value.topics.length-1){
				// 			value.show_topic += value1.name;
				// 		}else{
				// 			value.show_topic += value1.name+', ';
				// 		}
				// 	})
				// }
			})
			return data;
		}

		function setColorStatus(){
			$timeout(function(){
				angular.forEach($scope.tableParams.data, function(value,index){
					angular.element('#teaching_status'+index).val(value.teaching_status);
					angular.element('#available_status'+index).val(value.available_status);
					angular.element('#publish_status'+index).val(value.publish_status);

					var cssId = '#teaching_status'+index,
					value = angular.element('#teaching_status'+index).val();
					if(value == 0){
						angular.element(cssId).css('color', '#2196F3');
					}
					if(value == 1){
						angular.element(cssId).css('color', '#00BCD4');
					}
					if(value == 2){
						angular.element(cssId).css('color', '#4CAF50');
					}
					if(value == 3){
						angular.element(cssId).css('color', '#FF9800');
					}
					if(value == 4){
						angular.element(cssId).css('color', '#F44336');
					}

					var cssId = '#available_status'+index,
					value = angular.element('#available_status'+index).val();

					if(value == 0){
						angular.element(cssId).css('color', '#2196F3');
					}
					if(value == 1){
						angular.element(cssId).css('color', '#4CAF50');
					}
					if(value == 2){
						angular.element(cssId).css('color', '#F44336');
					}

					var cssId = '#publish_status'+index,
					value = angular.element('#publish_status'+index).val();

					if(value == 0){
						angular.element(cssId).css('color', 'red');
					}
					if(value == 1){
						angular.element(cssId).css('color', 'green');
					}
				})
			},10);
		}

		function afterReloadTable(){
			angular.forEach($scope.tableParams.data, function(value,index){
				angular.element('#teaching_status'+index).val(value.teaching_status);
				angular.element('#available_status'+index).val(value.available_status);
			})
		}

		function clickReset(){
			$scope.filters.show_topic = '';
			$scope.filters.available_status = '';
			$scope.filters.teaching_status = '';
			$scope.filters.gender = '';
			$scope.filters.date_filter = '';
			$scope.filters.full = '';


			if(typeof $scope.search != 'undefined'){
				$scope.filters.full = '';
			}

			if(typeof $scope.filters.user_profile != 'undefined'){
				$scope.filters.user_profile.country = '';
			}
			changeSearch();
			// changeDate();
			$scope.tableParams = new NgTableParams({filter:{}}, { dataset: $scope.teachersAll});
		}
		function editNote(item){

			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/admin_themes/admin_lte/pages/teacher/modals/editNote.blade.php',
				controller: 'ModalInstanceCtrl',
					// size: size,
					resolve: {
						item: function () {
							return item;
						}
					}
				});

			modalInstance.result.then(function (selectedItem) {

				angular.forEach($scope.teachersAll, function(value,index){
					if(value.id == selectedItem.id){
						value.note = selectedItem.note;
						return false;
					}
				});
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		// function applyDate(){
			// $scope.datePicker.date.startDate = $filter('date')($scope.datePicker.startDate, String(window.datetime_js_format));
			// $scope.datePicker.date.endDate = $filter('date')($scope.datePicker.endDate, String(window.datetime_js_format));
			// console.log('sdfsdf',$scope.datePicker,window.datetime_js_format);
		// }

		function exportData(type){
			console.log($scope.tableParams);
			// var data = angular.copy($scope.tableParams.filter());
			// data.type = type;
			// console.log('type',type,url_teacher);

			// $http({
			// 	method: 'GET',
			// 	url: url_teacher,
			// 	data:data
			// }).then(function(resp){
			// 	console.log('test',resp);
			// });
		}
	}

//Controller Popup ModalInstanceCtrl.
function ModalInstanceCtrl($scope, $http, $uibModalInstance, item){
	/* jshint validthis: true */
	$scope.noteUser = angular.copy(item.note);

	$scope.save = function () {
		item.note  = $scope.noteUser;
		$http({
			method: 'POST',
			url: url+'/api/v1/update-note-teacher',
			data:item
		}).then(function(resp){
			$uibModalInstance.close(item);
		});
	};

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
}

//Controller Popup ModalConfirmCtrl.
function ModalConfirmCtrl($scope, $uibModalInstance, statusName){
	/* jshint validthis: true */
	$scope.statusName = statusName;
	$scope.checkEmail = false;

	$scope.save = function () {
		$uibModalInstance.close($scope.checkEmail);
	};

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
}

})();