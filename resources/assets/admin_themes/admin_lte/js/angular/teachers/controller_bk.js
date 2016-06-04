var teacherJs = (function(){
	'use strict';

	angular
	.module('App')
	.controller('teachCtrl', teachCtrl)
	.controller('ModalInstanceCtrl', ModalInstanceCtrl);

	function teachCtrl($rootScope, $scope, $http, $timeout, $filter, $uibModal, $log, NgTableParams, ngTableEventsChannel){
		/* jshint validthis: true */
		$scope.urlEditTeacher = window.urlEdit.split("{id}");
		/*Variable*/
		$scope.teachersAll = window.teachersAll;
		$scope.teachersAll  = formatData($scope.teachersAll);
		$scope.filters = {};
		$scope.teacher = {};
		
		/*Function*/
		setColorStatus();
		$scope.clickEdit = clickEdit;
		$scope.changeSearch = changeSearch;
		$scope.changeFilter = changeFilter;
		$scope.changeEditStatus = changeEditStatus;
		$scope.clickResset = clickResset;
		$scope.editNote = editNote;

		console.log('teachCtrl', $scope.teachersAll);
		angular.element('#listTeach').removeClass('hidden')

		$scope.tableParams = new NgTableParams({
			filter:{
			}
		}, { 
			dataset: $scope.teachersAll
		});

		//Event when change pages
		ngTableEventsChannel.onAfterReloadData(function(){
			$timeout(function(){
				setColorStatus();
				// console.log('change');
			},500);
			
		}, $scope);

		function clickEdit(id){
			console.log('gg',id);
		}
		
		function changeSearch(){
			var filter = $scope.search.full;
			if ($scope.isInvertedSearch){
				filter = "!" + filter;
			}
			
			angular.extend($scope.tableParams.filter(), { $: filter });
			// setColorStatus();
		}

		function changeFilter(field, value){
			var filter = {};
			if(field == 'gender'){
				filter['user_profile'] = {};
				filter['user_profile'][field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}
			if(field == 'country'){
				filter['user_profile'] = {};
				filter['user_profile'][field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}else{
				filter[field] = value;
				angular.extend($scope.tableParams.filter(), filter);
			}
			// if(value == 0 || value == ''){

				// $timeout(function(){
				// 	$scope.tableParams.reload();
				// },500);
				// $timeout(function(){
				// 	$scope.tableParams.reload();
				// },500);
				// $timeout(function(){
				// 	$scope.tableParams.reload();
				// },500);

				// var tmpFilter = angular.copy($scope.tableParams.filter());

				// $scope.tableParams = new NgTableParams({
				// 	filter: {
						
				// 	}
				// }, { dataset: $scope.teachersAll});

				// $timeout(function(){
				// 	$scope.tableParams = new NgTableParams({
				// 		filter: tmpFilter
				// 	}, { dataset: $scope.teachersAll});
				// },300);
				
				setColorStatus();
			// }
			
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
				
			}else{
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
			}

			$http({
				method: 'POST',
				url: url+'/api/v1/update-status-teacher',
				data:tmp
			}).then(function(resp){
				// console.log('test',tmp);
				angular.forEach(teachersAll, function(value,index){
					if(value.id == tmp.id){
						// console.log(resp);
						value.teaching_status = tmp.teaching_status;
						value.available_status = tmp.available_status;
						// $timeout(function(){
						// 	$scope.tableParams.reload();
						// },500);
						
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
				
				if(value.topics.length != 0){
					angular.forEach(value.topics, function(value1,index1){
						if(index1 == value.topics.length-1){
							value.show_topic += value1.name;
						}else{
							value.show_topic += value1.name+', ';
						}
						
					})
				}
			})
			return data;
		}

		function setColorStatus(){
			$timeout(function(){
				for (var i = 0; i < 100; i++) {
					var cssId = '#teaching_status'+i,
					value = angular.element('#teaching_status'+i).val();
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

					var cssId = '#available_status'+i,
					value = angular.element('#available_status'+i).val();

					if(value == 0){
						angular.element(cssId).css('color', '#2196F3');
					}
					if(value == 1){
						angular.element(cssId).css('color', '#4CAF50');
					}
					if(value == 2){
						angular.element(cssId).css('color', '#F44336');
					}
				}
			},10);
		}

		function clickResset(){
			$scope.filters.show_topic = '';
			$scope.filters.available_status = '';
			$scope.filters.teaching_status = '';
			$scope.filters.gender = '';

			if(typeof $scope.search != 'undefined'){
				$scope.search.full = '';
			}

			if(typeof $scope.filters.user_profile != 'undefined'){
				$scope.filters.user_profile.country = '';
			}
			$scope.tableParams = new NgTableParams({
				filter:{
				}
			}, { dataset: $scope.teachersAll});
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
				// console.log('success',selectedItem);
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
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
			// console.log('test',item.note);
		});
	};

	$scope.cancel = function () {
		$uibModalInstance.dismiss('cancel');
	};
}

})();