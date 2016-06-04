(function(){
	'use strict';

	angular
	.module('Lms_App')
	.factory('teacherFac', teacherFac)
	.service('teacherSvc', teacherSvc);

	function teacherFac($resource){
		return $resource(window.url+'/api/v1' + '/:method', {method:'@method'},{
			save: {
				headers: {'Content-Type':undefined, enctype:'multipart/form-data'},
				transformRequest: formDataObject,
				method: 'POST'
			},
			save_array: {
				method: 'POST'
			},
			get: {
				// headers:{ "Content-Type": "application/json; charset=utf-8" },
				method: 'GET'
			}
		});
	}

	function formDataObject (data) {
		var fd = new FormData();
		angular.forEach(data, function(value, key) {
			fd.append(key, value);
		});
		return fd;
	}

	function teacherSvc(teacherFac){
		var $this = {};
		$this.closeNoti = function(data){
			var dataSend = new teacherFac();

			return dataSend.$get({method:'close-noti'});
		}

		$this.connectFacebook = function(data){
			var dataSend = new teacherFac(data);

			return dataSend.$save({method:'connect-facebook'});
		}

		$this.disconnectFacebook = function(data){
			var dataSend = new teacherFac();

			return dataSend.$get({method:'disconnect-facebook'});
		}

		$this.changePass = function(data){
			var dataSend = new teacherFac(data);

			return dataSend.$save({method:'change-password'});
		}

		$this.changeTagline = function(data){
			var dataSend = new teacherFac(data);
			return dataSend.$save({method:'change-tagline'});
		}

		$this.addPayment = function(data) {
			var dataSend = new teacherFac(data);
			
			return dataSend.$save_array({method:'add-payment'});
		}
		$this.updateUserInfo = function(data){
			var dataSend = new teacherFac(data);

			return dataSend.$save({method:'update-user'});
		}

		$this.updateAboutMe = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-about-me'});
		}

		$this.updateSkype = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-skype'});
		}

		$this.updateAudio = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-audio'});
		}

		$this.updateVideo = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-video'});
		}

		$this.updateSubject = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-subject'});
		}

		$this.updateFields = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-fields'});
		}
		
		$this.addUW = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'add-user-work'});
		}

		$this.updateUW = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-user-work'});
		}

		$this.deleteUW = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'delete-user-work'});
		}

		$this.addUE = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'add-user-edu'});
		}

		$this.updateUE = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-user-edu'});
		}

		$this.deleteUE = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'delete-user-edu'});
		}

		$this.addUC = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'add-user-cer'});
		}

		$this.updateUC = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'update-user-cer'});
		}

		$this.deleteUC = function(data){
			var dataSend = new teacherFac(data);
			
			return dataSend.$save({method:'delete-user-cer'});
		}

		$this.test = function(){
			console.log('test');
		}

		return $this;
	}
	
})();