var menuJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('menuCtrl', menuCtrl)
	.controller('ModalInstanceConfirmCtrl', ModalInstanceConfirmCtrl)
	.controller('ModalInstanceLoginCtrl', ModalInstanceLoginCtrl)
	.controller('ModalInstanceRegisterCtrl', ModalInstanceRegisterCtrl)
	.controller('ModalInstanceSelectCtrl', ModalInstanceSelectCtrl);

	function menuCtrl($rootScope, $scope, $timeout, $uibModal, $log, $uibModalStack, GAuth, appSvc, menuSvc){
		/* jshint validthis: true */
		/*Variable*/
		/*Function*/
		$scope.showLogin = showLogin;
		$scope.showRegister = showRegister;
		$scope.showSelect = showSelect;

		// $scope.showConfirm = showConfirm;
		$scope.showReConfirm = showReConfirm;
		$rootScope.loginFacebook = loginFacebook;
		$rootScope.loginGoogle = loginGoogle;
		$rootScope.typeLogin = '';//page register tutor and login normal

		function showLogin(type){
			$rootScope.typeLogin = type;
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_login.blade.php',
				controller: 'ModalInstanceLoginCtrl',
			});
			modalInstance.result.then(function (resp) {
				if(resp.type == 'register'){
					$scope.showSelect();
				}
				if(resp.type == 'notConfirm'){
					$scope.showReConfirm(resp.user);
				}
				if(resp.type == 'forget'){
					var user = {};
					var modalInstance = $uibModal.open({
						animation: true,
						templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_forget_password.blade.php',
						controller: 'ModalInstanceConfirmCtrl',
						resolve: {
							user: function () {
								return user;
							}
						}
					});
					modalInstance.result.then(function (resp) {
					});
				}
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function showSelect() {
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_select.blade.php',
				controller: 'ModalInstanceSelectCtrl',
			});
			modalInstance.result.then(function(resp){
				$scope.showRegister();
			}, function() {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function showRegister(social){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_register.blade.php',
				controller: 'ModalInstanceRegisterCtrl',
				resolve: {
					social: function () {
						return social;
					}
				}
			});
			modalInstance.result.then(function (resp) {
				console.log(resp);
				if(resp.type == 'login'){
					$scope.showLogin();
				}
				if(resp.success == true && resp.notConfirm == true){
					$scope.showReConfirm(resp.user);
				}
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function showForget(){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_forget_password.blade.php',
				controller: 'ModalInstanceConfirmCtrl',
			});
			modalInstance.result.then(function (resp) {
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		// function showConfirm(user){
		// 	var modalInstance = $uibModal.open({
		// 		animation: true,
		// 		templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_confirm.blade.php',
		// 		'backdrop':'static',
		// 		controller: 'ModalInstanceConfirmCtrl',
		// 		resolve: {
		// 			user: function () {
		// 				return user;
		// 			}
		// 		}
		// 	});
		// 	modalInstance.result.then(function (user) {
		// 		//send email.
		// 		$rootScope.openLoading({callback:function(){
		// 			menuSvc.sendMailWelcome(user).then(function(resp){
		// 				$rootScope.closeLoading();
		// 				$scope.showReConfirm(user);
		// 				console.log('res_mail',resp);
		// 			});
		// 		}});

		// 	}, function () {
		// 		$log.info('Modal dismissed at: ' + new Date());
		// 	});
		// }

		function showReConfirm(user){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/auth/popup_reconfirm.blade.php',
				'backdrop':'static',
				controller: 'ModalInstanceConfirmCtrl',
				resolve: {
					user: function () {
						return user;
					}
				}
			});
			modalInstance.result.then(function (resp) {

			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function loginFacebook(){
			appSvc.getFacebook().then(function(user){
				if(!user.error){
					social('facebook', user);
				}else{
					location.reload();
				}
			});
		}

		function loginGoogle(){
			GAuth.login().then(function(user){
				social('google', user);
			});
		}

		function social(type, user){
			$scope.social = {
				type:type,
				id :user.id,
				name :user.name,
				email :user.email,
				profile_picture :user.picture+'?sz=200'
			};
			if(type == 'facebook'){
				$scope.social.profile_picture = 'https://graph.facebook.com/v2.5/'+user.id+'/picture?width=200&height=200';
			}
			$rootScope.openLoading({callback:function(){
				menuSvc.loginUserSocial($scope.social).then(function(resp){
					$rootScope.closeLoading();
					if(resp.success == true){
						console.log(resp);
						if($rootScope.typeLogin == 'tutor'){
							window.location = window.URL_BECOME_TUTOR;
						}else{
							location.reload();
						}
						return true;
					}
					if(resp.error == 'notEmail'){
						$uibModalStack.dismissAll();
						$scope.showRegister($scope.social);
					}
				});
			}});
		}
	}

	//Controller Popup ModalInstanceLoginCtrl.
	function ModalInstanceLoginCtrl($rootScope, $scope, $uibModal, $uibModalInstance, menuSvc){
		/* jshint validthis: true */
		var resp = {
			'type':'',
			'data':{}
		};
		$scope.user = {
			'email':'',
			'password':'',
			'remember':false
		};

		$scope.login = login;
		$scope.showRegister = showRegister;
		$scope.cancel = cancel;
		$scope.showForget = showForget;

		function login(valid) {
			$scope.submited = true;
			if(!valid) return;

			$rootScope.openLoading({callback: function(){
				menuSvc.loginUser($scope.user).then(function(resp){
					$rootScope.closeLoading();
					if(resp.success == false && resp.confirm == false){
						console.log('notConfirm',resp);
						resp.type = 'notConfirm';
						$uibModalInstance.close(resp);
					}

					if(resp.success == true){
						if($rootScope.typeLogin == 'tutor'){
							window.location = window.URL_BECOME_TUTOR;
						}else{
							location.reload();
						}
					}else if(resp.success == false && resp.lockout_time == true){
						$scope.message_lockout_time = resp.message_lockout_time;
						$scope.errorLogin = false;
					}else{
						$scope.message_lockout_time = false;
						$scope.errorLogin = true;
					}
				});
			}});
		};

		function showRegister(){
			resp.type = 'register';
			$uibModalInstance.close(resp);
		}

		function showForget(){
			resp.type = 'forget';
			$uibModalInstance.close(resp);
		}

		function cancel() {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalInstanceRegisterCtrl.
	function ModalInstanceRegisterCtrl($rootScope, $scope, $uibModalInstance, CONTS_COUNTRY, menuSvc, social){
		/* jshint validthis: true */
		$scope.conts_country = CONTS_COUNTRY;
		var resp = {
			'type':'',
			'data':{}
		};
		$scope.user = {
			'provider':'',
			'provider_id':'',
			'name':'',
			'email':'',
			'password':'',
			'profile_picture':'',
			'phone_code':'VN',
			'phone':''
		};
		// if(typeof social != 'undefined'){
		// 	$scope.user = {
		// 		'provider':social.type,
		// 		'provider_id':social.id,
		// 		'name':social.name,
		// 		'email':social.email,
		// 		'password':'',
		// 		'profile_picture':social.profile_picture,
		// 		'phone_code':'VN',
		// 		'phone':''
		// 	};
		// }else{
		// 	$scope.user = {
		// 		'provider':'',
		// 		'provider_id':'',
		// 		'name':'',
		// 		'email':'',
		// 		'password':'',
		// 		'profile_picture':'',
		// 		'phone_code':'VN',
		// 		'phone':''
		// 	};
		// }

		$scope.register = register;
		$scope.showLogin = showLogin;
		$scope.cancel = cancel;

		function register(valid) {
			$scope.submited = true;
			if(!valid) return;

			$rootScope.openLoading({callback:function(){
				menuSvc.registerUser($scope.user).then(function(resp){
					$rootScope.closeLoading();
					if(resp.success == true){
						// if($rootScope.typeLogin == 'tutor'){
						// 	window.location = window.URL_BECOME_TUTOR;
						// }else{
						// 	location.reload();
						// }
						window.location = window.URL_BECOME_TUTOR;
						// $uibModalInstance.close(resp);
						console.log('success',resp);
					}else{
						if(resp.success == false && resp.errors){
							$scope.errorsRegister = resp.errors;
							console.log('error',$scope.errorsRegister);
						}
					}
				});
			}});
		};

		function showLogin(){
			resp.type = 'login';
			$uibModalInstance.close(resp);
		}

		function cancel() {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalInstanceConfirmCtrl.
	function ModalInstanceConfirmCtrl($rootScope, $scope, $uibModalInstance, menuSvc, user){
		/* jshint validthis: true */
		$scope.user = user;
		console.log($scope.user);

		$scope.cancel = cancel;
		// $scope.reConfirm = reConfirm;
		$scope.sendMail = sendMail;
		$scope.forgetAct = forgetAct;
		$scope.forgerPass = {email:''};
		// function reConfirm() {
		// 	$uibModalInstance.close(user);
		// };

		function forgetAct(valid) {
			$scope.submited = true;
			if(!valid) return;

			$rootScope.openLoading({callback:function(){
				menuSvc.sendMailForgetPass($scope.forgerPass).then(function(resp){
					$rootScope.closeLoading();
					$uibModalInstance.close($scope.forgerPass);
				});
			}});
		};

		function sendMail() {
			$rootScope.openLoading({callback:function(){
				menuSvc.sendMailWelcome(user).then(function(resp){
					$rootScope.closeLoading();
					$uibModalInstance.close(user);
				});
			}});
		};

		function cancel() {
			$uibModalInstance.dismiss('cancel');
		};
	}

	function ModalInstanceSelectCtrl($rootScope, $scope, $uibModalInstance, menuSvc) {
		$scope.link = window.toBecomeTutorLink;
		$scope.select = function() {
			$uibModalInstance.close("test");
		};
	}
})();