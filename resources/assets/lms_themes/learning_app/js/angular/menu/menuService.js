(function(){
	'use strict';

	angular
	.module('Lms_App')
	.factory('menuFac', menuFac)
	.service('menuSvc', menuSvc);

	function menuFac($resource){
		return $resource(window.url+'/api/v1' + '/:method', {method:'@method'},{
			save: {
				method: 'POST'
			},
			get: {
				// headers:{ "Content-Type": "application/json; charset=utf-8" },
				method: 'GET'
			}
		});
	}

	function menuSvc(menuFac){
		var $this = {};

		$this.loginUser = function(data){
			var dataSend = new menuFac(data);

			return dataSend.$save({method:'login-user'});
		}

		$this.loginUserSocial = function(data){
			var dataSend = new menuFac(data);

			return dataSend.$save({method:'login-user-social'});
		}

		$this.registerUser = function(data){
			var dataSend = new menuFac(data);

			return dataSend.$save({method:'register-user'});
		}

		$this.sendMailWelcome = function(data){
			var dataSend = new menuFac(data);

			return dataSend.$save({method:'send-mail-welcome'});
		}

		$this.sendMailForgetPass = function(data){
			var dataSend = new menuFac(data);

			return dataSend.$save({method:'send-mail-forget-pass'});
		}

		$this.test = function(){
			console.log('testxxx');
		}

		$this.toBecomeTutor = function () {
			var dataSend = new menuFac();
			return dataSend.$save({method:'to-become-tutor'});
		}

		return $this;
	}
	
})();