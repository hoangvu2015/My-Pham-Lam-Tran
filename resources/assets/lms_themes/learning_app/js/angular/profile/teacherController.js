var teacherProJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('teacherProCtrl', teacherProCtrl)
	.controller('ModalInstanceTaglineCtrl', ModalInstanceTaglineCtrl)
	.controller('ModalInstanceTeacherCtrl', ModalInstanceTeacherCtrl)
	.controller('ModalInstancePaymentCtrl', ModalInstancePaymentCtrl);
	
	function teacherProCtrl($rootScope, $scope, $http, $timeout, $filter, $uibModal, $log, teacherSvc, Upload){
		/* jshint validthis: true */
		angular.element('#mod-tutor-profile').removeClass('hidden');
		/*Variable*/
		$scope.user_profile = window.user_profile;
		$scope.user_works = window.user_works;
		$scope.user_educations = window.user_educations;
		$scope.user_certificates = window.user_certificates;
		$scope.teacher_profile = window.teacher_profile;
		$scope.topics = window.topics;
		$scope.fields = window.fields;
		$scope.optionsCkEditor = window.optionCkEditor;
		$scope.array_payment = window.array_payment;
		$scope.trans = window.trans;
		formatData();
		$scope.infoPass = {};
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
		$scope.aboutMe = {
			about_me:$scope.teacher_profile.about_me
		};
		$scope.skype = {
			skype:$scope.user_profile.skype
		};
		$scope.teacherInfo = {
			'id':$scope.teacher_profile.id,
			'voice':$scope.user_profile.voice,
			'youtube':$scope.teacher_profile.youtube,
			'topics':$scope.teacher_profile.topicsArr,
			'fields':$scope.teacher_profile.fieldsArr,
			'methodology':$scope.teacher_profile.methodology,
			'experience':$scope.teacher_profile.experience
		};
		/*Function*/
		$scope.changePass = changePass;
		$scope.editPayment = editPayment;
		$scope.changeTagline = changeTagline;
		$scope.submitInfo = submitInfo;
		$scope.submitAboutMe = submitAboutMe;
		$scope.submitSkype = submitSkype;
		$scope.submitVideo = submitVideo;
		$scope.submitSubject = submitSubject;
		$scope.submitFields = submitFields;

		$scope.submitAddUW = submitAddUW;
		$scope.submitEditUW = submitEditUW;
		$scope.deleteUW = deleteUW;
		$scope.submitAddUE = submitAddUE;
		$scope.submitEditUE = submitEditUE;
		$scope.deleteUE = deleteUE;
		$scope.submitAddUC = submitAddUC;
		$scope.submitEditUC = submitEditUC;
		$scope.deleteUC = deleteUC;

		$scope.moreUserWork = moreUserWork;
		$scope.moreEdu = moreEdu;
		$scope.moreCer = moreCer;

		$scope.onFileSelect = onFileSelect;
		$scope.uploadAudio = uploadAudio;
		$scope.checkTopic = checkTopic;

		// console.log('controllerTeacherProfile',$scope.teacher_profile);

		function formatData(){
			$scope.teacher_profile.topicsArr = [];
			angular.forEach($scope.teacher_profile.topics, function(value, key) {
				$scope.teacher_profile.topicsArr.push(String(value.id));
			});

			$scope.teacher_profile.fieldsArr = [];
			angular.forEach($scope.teacher_profile.fields, function(value, key) {
				$scope.teacher_profile.fieldsArr.push(String(value.id));
			});
		}

		function checkTopic(id_topic){
			var flat = in_array(id_topic,$scope.teacherInfo.topics);
			return flat;
		}

		function changePass(){
			console.log('test');
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/popup_change_password.blade.php',
				controller: 'ModalInstanceTeacherCtrl',
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

		function editPayment(){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/pages/profile/popup/payment_info_popup.blade.php',
				controller: 'ModalInstancePaymentCtrl',
				resolve: {
					payment: function () {
						return $scope.array_payment;
					}
				}
			});

			modalInstance.result.then(function (resp) {
				$scope.array_payment = resp.payment;
			}, function () {
				$log.info('Modal dismissed at: ' + new Date());
			});
		}

		function changeTagline(){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/profiles/tagline.blade.php',
				controller: 'ModalInstanceTaglineCtrl',
				resolve: {
					teacher: function () {
						return $scope.teacher_profile;
					}
				}
			});

			modalInstance.result.then(function (resp) {
				$scope.teacher_profile.tagline = resp.data.tagline;
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

				// angular.element('.submit').removeAttr('disabled');
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

		function submitAboutMe(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-about-me').removeClass('bg-green');

			$scope.aboutMe.id = $scope.teacher_profile.id;
			teacherSvc.updateAboutMe($scope.aboutMe).then(function(resp){
				console.log('done',resp);
			})
		}

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

		function submitVideo(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-youtube').removeClass('bg-green');

			teacherSvc.updateVideo($scope.teacherInfo).then(function(resp){
				console.log('done',resp);
			})
		}

		function submitSubject(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-subject').removeClass('bg-green');

			teacherSvc.updateSubject($scope.teacherInfo).then(function(resp){
				console.log('done',resp);
			})
		}

		function submitFields(valid){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-fields').removeClass('bg-green');

			teacherSvc.updateFields($scope.teacherInfo).then(function(resp){
				console.log('done',resp);
			})
		}

		function submitAddUW(valid, tmpUW){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-work-add').removeClass('bg-green');
			// console.log('ok',tmpUW);

			teacherSvc.addUW(tmpUW).then(function(resp){
				console.log('done',resp);
				if(resp.success && resp.data){
					$scope.user_works.push(resp.data);
					$timeout(function(){
						reloadDatePicker();
					},500);
					
					$scope.tmpUW = {};
				}
			})
		}

		function submitEditUW(valid, userWork, index){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-work-update'+index).removeClass('bg-green');
			angular.element('#sm-work-update'+index).attr('disabled', 'true');
			console.log('okww','#sm-work-update'+index);

			// angular.element('.submit').removeAttr('disabled');
			teacherSvc.updateUW(userWork).then(function(resp){
				console.log('done',resp);
			})
		}

		function deleteUW(userWork){
			teacherSvc.deleteUW(userWork).then(function(resp){
				console.log('done',resp);
				angular.forEach($scope.user_works, function(value, key) {
					if(userWork.id == value.id){
						$scope.user_works.splice(key,1);
						console.log('ooos',$scope.user_works);
					}
				});
			})
		}

		function submitAddUE(valid, tmpUE){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-edu-add').removeClass('bg-green');
			console.log('ok',tmpUE);

			// angular.element('.submit').removeAttr('disabled');
			teacherSvc.addUE(tmpUE).then(function(resp){
				console.log('done',resp);
				if(resp.success && resp.data){
					$scope.user_educations.push(resp.data);
					$timeout(function(){
						reloadDatePicker();
					},500);
					
					$scope.tmpUE = {};
				}
			})
		}

		function submitEditUE(valid, userEdu, index){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-edu-update'+index).removeClass('bg-green');
			angular.element('#sm-edu-update'+index).attr('disabled', 'true');
			console.log('okww','#sm-edu-update'+index);

			console.log('ok',userEdu);

			// angular.element('.submit').removeAttr('disabled');
			teacherSvc.updateUE(userEdu).then(function(resp){
				console.log('done',resp);
			})
		}

		function deleteUE(userEdu){
			teacherSvc.deleteUE(userEdu).then(function(resp){
				console.log('done',resp);
				angular.forEach($scope.user_educations, function(value, key) {
					if(userEdu.id == value.id){
						$scope.user_educations.splice(key,1);
					}
				});
			})
		}

		function submitAddUC(valid, tmpUC){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-cer-add').removeClass('bg-green');
			console.log('ok',tmpUC);

			// angular.element('.submit').removeAttr('disabled');
			teacherSvc.addUC(tmpUC).then(function(resp){
				console.log('done',resp);
				if(resp.success && resp.data){
					$scope.user_certificates.push(resp.data);
					$timeout(function(){
						reloadDatePicker();
					},500);
					
					$scope.tmpUC = {};
				}
			})
		}

		function submitEditUC(valid, userCer, index){
			$scope.submited = true;
			if(!valid)return;
			angular.element('#sm-cer-update'+index).removeClass('bg-green');
			angular.element('#sm-cer-update'+index).attr('disabled', 'true');
			console.log('okww','#sm-cer-update'+index);
			console.log('ok',userCer);

			angular.element('.submit').removeAttr('disabled');
			teacherSvc.updateUC(userCer).then(function(resp){
				console.log('done',resp);
			})
		}

		function deleteUC(userCer){
			teacherSvc.deleteUC(userCer).then(function(resp){
				console.log('done',resp);
				angular.forEach($scope.user_certificates, function(value, key) {
					if(userCer.id == value.id){
						$scope.user_certificates.splice(key,1);
					}
				});
			})
		}

		function moreUserWork(){
			angular.element('#fresh-companies').removeClass('hidden');
			$scope.tmpUW = {};
			angular.element('#sm-work-add').removeClass('bg-green');
			angular.element('#sm-work-add').attr('disabled', 'true');
		}

		function moreEdu(){
			angular.element('#fresh-edu').removeClass('hidden');
			$scope.tmpUE = {};
			angular.element('#sm-edu-add').removeClass('bg-green');
			angular.element('#sm-edu-add').attr('disabled', 'true');
		}

		function moreCer(){
			angular.element('#fresh-cer').removeClass('hidden');
			$scope.tmpUC = {};
			angular.element('#sm-cer-add').removeClass('bg-green');
			angular.element('#sm-cer-add').attr('disabled', 'true');
		}

		function uploadAudio(file){

			if(file.length >0){

				var byte = window.max_size_byte.split(" ");
				if(parseInt(byte) < file[0].size){
					alert('Max file size '+window.max_size);
					return;
				}

				Upload.upload({
					url: window.url+'/api/v1/update-audio',
					data: {user_id:$scope.user_profile.id, file: file},
				}).then(function (resp) {
					console.log('Success ' ,resp);
					if(resp.data.success){
						$scope.user_profile.voice = resp.data.user.voice;
					}
				}, function (resp) {
					console.log('Error status: ' + resp.status);
				}, function (evt) {
					$scope.progressPercentage = parseInt(100.0 * evt.loaded / evt.total);
					// console.log('progress: ' + $scope.progressPercentage + '% ' + evt.config.data.file.name);
				});
			}
			
		}

		function onFileSelect(file){
			$scope.teacherInfo.voice = file;
			$scope.teacherInfo.id = $scope.user_profile.id;
			// console.log('tt',$scope.teacherInfo.voice);
			
			teacherSvc.updateAudio($scope.teacherInfo).then(function(resp){
				console.log('done',resp);
			})

		}

		$scope.changeSM = function(value){
			// console.log('changeUserInfo',value);
			if(!angular.element('#sm-'+value).hasClass('bg-green')){
				angular.element('#sm-'+value).removeAttr('disabled');
				angular.element('#sm-'+value).addClass('bg-green');
			}
		};
		
		$scope.clickSM = function(value){
			// console.log('changeUserInfo',value);
			// angular.element('#sm-'+value).removeClass('bg-green');
			// angular.element('#sm-'+value).attr('disabled', 'true');
		};

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

		$scope.closeNoti = function(){
			teacherSvc.closeNoti().then(function(resp){
				console.log('donexxx',resp);
				$scope.teacher_profile.close_noti = resp.data.close_noti;
			})
		}
	}

	//Controller Popup ModalInstanceTeacherCtrl.
	function ModalInstanceTeacherCtrl($scope, $uibModalInstance, user, teacherSvc){
		/* jshint validthis: true */

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

	//Controller Popup ModalInstanceTaglineCtrl.
	function ModalInstanceTaglineCtrl($scope, $uibModalInstance, teacher, teacherSvc){
		/* jshint validthis: true */
		$scope.teacher = {
			tagline:teacher.tagline
		};

		$scope.save = function (valid) {
			$scope.submited = true;
			if(!valid) return;

			$scope.teacher.id = teacher.id;
			teacherSvc.changeTagline($scope.teacher).then(function(resp){
				// if(resp.error){
				// 	$scope.errors = resp.data.password;  
				// }
				if(resp.success){
					$uibModalInstance.close(resp);
				}
			})
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	//Controller Popup ModalInstancePaymentCtrl.
	function ModalInstancePaymentCtrl($scope, $uibModalInstance, payment, teacherSvc){
		$scope.payment = formatData(payment);
		$scope.national = window.national;
		var array_payment = {
			commom: {
				country: "",
			}
		};

		$scope.save = function (valid) {
			if(valid == true){
				teacherSvc.addPayment($scope.payment).then(function(resp){
					if(resp.success){
						$uibModalInstance.close(resp);
						payment = resp.payment;
					}
				});
			}
		};

		$scope.selectCountry = function() {
			var temp = $scope.commom.country.split(" | ");
			$scope.payment.data.country = temp[0];
			$scope.payment.data.payments_group = parseInt(temp[1].replace("#group-",""));
			resetActive();
			$scope.payment = setGroup($scope.payment);
		}


		$scope.showBank = function(class_payment) {
			if ($scope.payment.class[class_payment].showbank == "showbank") {
				$scope.payment.class[class_payment].showbank = "";
				$scope.payment.check[class_payment] = "";
			}
			else{
				$scope.payment.class[class_payment].showbank = "showbank";
				$scope.payment.check[class_payment] = "yes";
			}
		}

		function setActive(class_payment, payment) {
			payment.class[class_payment].active = "active";
			if (payment.class[class_payment].showbank == "showbank") {
				payment.check[class_payment] = "yes";
			}
		}

		function resetActive() {
			angular.forEach($scope.payment.class, function(value, key){
				value.active = "";
				$scope.payment.check[key] = "";
			});
		}

		function setGroup(payment) {
			var group = payment.data.payments_group;
			if (group == 1 ){
				setActive("payment_BA1",payment);
				payment.class.payment_BA1.showbank = "showbank";
				payment.check.payment_BA1 = "yes";
			}
			if (group == 2 ){
				setActive("payment_BA2", payment);
			}
			if (group >= 2 ) {
				payment.data.text_class = "active";
				setActive("payment_PP", payment);
				setActive("payment_SK", payment);
			}
			if (group == 3 ) {
				setActive("payment_BA3", payment);
			}
			if (group >= 3 ) {
				setActive("payment_PO", payment);
				setActive("payment_OPM", payment);
			}
			return payment;
		}

		function formatData(payment) {
			payment.check = {};
			payment.id_list = {};
			payment.class = {};
			angular.forEach(payment, function(value, key){
				if (key.includes("payment_") == true ) {
					if (value ==  null) {
						payment.check[key] = "";
						payment.id_list[key] = 0;
						payment.class[key] = { active: "", showbank: "" }
					}
					else{
						payment.check[key] = "yes";
						payment.id_list[key] = value.id;
						payment.class[key] = { active: "active", showbank: "showbank" };
						delete value.created_at;
						delete value.updated_at;
						delete value.user_id;
					}
				}
			});
			payment = setGroup(payment);
			payment.type_pay_id = {
				payment_BA1: 1,
				payment_BA2: 1,
				payment_BA3: 1,
				payment_PP: 2,
				payment_SK: 3,
				payment_PO: 4,
				payment_OPM: 5
			};
			return payment;
		}
	}

})();