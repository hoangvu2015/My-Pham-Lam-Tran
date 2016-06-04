(function(){
    'use strict';
    angular
    .module('App', [
        'ngTable',
        'ui.bootstrap',
        'daterangepicker'
        // 'ngSanitize',
        // 'ngAnimate',
        // 'ngMessages',
        // 'ngResource',
        // 'ui.router',
        // 'LocalStorageModule',
        // 'ngFacebook',
        // 'ngProgress',
        // 'angular-cache',
        // 'angular-google-analytics',
        // 'toastr',
        // 'djds4rce.angular-socialshare',
        // 'timer'
        ])
    .config(config)
    .run(run);

    function config(){
        
    }

    function run(){
    	// console.log('kkk');
        // $FB.init('932928490106717');
    }

    angular.element(document).ready(function() {
        // angular.bootstrap(document.html, ['App']);
    });
})();