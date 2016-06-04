var appJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('appCtrl', appCtrl);
	
	function appCtrl($rootScope, $scope, $timeout, $uibModal, $uibModalStack){
		/* jshint validthis: true */
		/*Variable*/
		// console.log('app');
		$rootScope.url = url;
		$rootScope.URL_TERMS_SERVICE = window.URL_TERMS_SERVICE;
		$rootScope.openLoading = openLoading;
		$rootScope.closeLoading = closeLoading;

		function url(){
			return window.url;
		}

		function openLoading(option){
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: '../../resources/views/lms_themes/learning_app/popup/loading.blade.php',
				backdrop:'static',
				windowClass:'modal-loading'
			});
			//Add a function for when the dialog is opened
			modalInstance.opened.then(function () {
				option.callback();
			});
		}

		function closeLoading(){
			var openedModal = $uibModalStack.getTop();
			if (openedModal) {
				$uibModalStack.dismiss(openedModal.key);
			}
		}
		/*Function*/
	}
})();