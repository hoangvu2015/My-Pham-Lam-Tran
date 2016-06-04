var studentProJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('studentProCtrl', studentProCtrl)
	.controller('ModalInstanceStudentCtrl', ModalInstanceStudentCtrl);
	
	function studentProCtrl($rootScope, $scope, $timeout, $filter, $uibModal, $log, teacherSvc){
		/* jshint validthis: true */
		angular.element('#mod-tutor-profile').removeClass('hidden')
		/*Variable*/
		$scope.user_profile = window.user_profile;
		$scope.userInfo = {
			name:$scope.user_profile.name,
			date_of_birth:$scope.user_profile.date_of_birth,
			gender:$scope.user_profile.gender,
			phone_code:$scope.user_profile.phone_code,
			phone:parseInt($scope.user_profile.phone),
			address:$scope.user_profile.address,
			city:$scope.user_profile.city,
			country:$scope.user_profile.country,
			nationality:$scope.user_profile.nationality
		};
		$scope.skype = {
			skype:$scope.user_profile.skype
		};
		
		/*Function*/
		$scope.changePass = changePass;
		$scope.submitInfo = submitInfo;
		$scope.submitSkype = submitSkype;

		console.log('controllerTeacherProfile',$scope.user_profile);

		function changePass(){
			// console.log('test');
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/popup_change_password.blade.php',
				controller: 'ModalInstanceStudentCtrl',
				resolve: {
					user: function () {
						return $scope.user_profile;
					}
				}
			});

			modalInstance.result.then(function (resp) {
				//do...
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function submitInfo(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-user-info').removeClass('bg-green');
			
			$scope.userInfo.id = $scope.user_profile.id;
			teacherSvc.updateUserInfo($scope.userInfo).then(function(resp){

				if(resp.errors){
					$scope.errors = []; 
					angular.forEach(resp.data, function(value, key) {
						angular.forEach(value, function(value1, key1) {
							$scope.errors.push(value1);
						});
					});
				}

				if(resp.success){
					$scope.errors = false;
				}
			})
		}

		$scope.changeSM = function(value){
			console.log('changeUserInfo',value);
			if(!angular.element('#sm-'+value).hasClass('bg-green')){
				angular.element('#sm-'+value).removeAttr('disabled');
				angular.element('#sm-'+value).addClass('bg-green');
			}
		};
		
		$scope.clickSM = function(value){
			// console.log('changeUserInfo',value);
			// angular.element('#sm-'+value).removeClass('bg-green');
		};

		function submitSkype(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-skype').removeClass('bg-green');

			$scope.skype.id = $scope.user_profile.id;
			console.log('skype',$scope.skype);
			teacherSvc.updateSkype($scope.skype).then(function(resp){
				console.log('done',resp);
			})
		}

		$scope.connetFacebook = function(){
			FB.getLoginStatus(function(response){
				if(response.status == "connected"){
					$scope.loginSuccess(response);
				}else{
					FB.login(function (response) {
						if (response.status === 'connected') {
							$scope.loginSuccess(response);
						}
					},{scope:"email"});
				}
			});
		}

		$scope.disconnetFacebook = function(){
			teacherSvc.disconnectFacebook().then(function(resp){
				$scope.user_profile.conn_facebook_id = resp.data.conn_facebook_id;
			})
		}

		$scope.loginSuccess = function(response){
			var accessToken = response.authResponse.accessToken;

			FB.api("/me", {fields: "id,name,email,picture"}, function(response){
				console.log(response);
				teacherSvc.connectFacebook(response).then(function(resp){
					// console.log('donexxx',resp);
					$scope.user_profile.profile_picture = resp.data.profile_picture;
					$scope.user_profile.conn_facebook_id = resp.data.conn_facebook_id;
				})
			});
		}
	}

	//Controller Popup ModalInstanceStudentCtrl.
	function ModalInstanceStudentCtrl($scope, $uibModalInstance, user, teacherSvc){
		/* jshint validthis: true */

		$scope.infoPass = {};

		$scope.save = function (valid) {
			$scope.submited = true;
			if(!valid) return;

			$scope.infoPass.id = user.id;
			teacherSvc.changePass($scope.infoPass).then(function(resp){
				if(resp.error){
					$scope.errors = resp.data.password;  
				}
				if(resp.success){
					$uibModalInstance.close(resp);
				}
			})
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

})();