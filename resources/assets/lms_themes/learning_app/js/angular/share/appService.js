(function(){
	'use strict';

	angular
	.module('Lms_App')
	.factory('appFac', appFac)
	.service('appSvc', appSvc);

	function appFac($resource){
		return $resource(window.url+'/api/v1' + '/:method', {method:'@method'},{
			save: {
				method: 'POST'
			},
			get: {
				method: 'GET'
			}
		});
	}

	function appSvc(appFac,$q){
		var $this = {};

		// $this.loginUser = function(data){
		// 	var dataSend = new appFac(data);

		// 	return dataSend.$save({method:'login-user'});
		// }

		$this.test = function(){
			console.log('testxxx');
		}

		$this.getFacebook = function(){
			var deferred = $q.defer();

			FB.getLoginStatus(function(response){
				if(response.status === "connected"){
					var accessToken = response.authResponse.accessToken;
					FB.api("/me", {fields: "id,name,email,picture"}, function(response){
						// console.log('da login',response);
						deferred.resolve(response);
					});
				}else{
					FB.login(function (response) {
						if (response.status === 'connected') {
							var accessToken = response.authResponse.accessToken;
							FB.api("/me", {fields: "id,name,email,picture"}, function(response){
								// console.log('moi login',response);
								deferred.resolve(response);
							});
						}
					},{scope:"email"});
				}
			});

			return deferred.promise;
		}

		return $this;
	}
	
})();