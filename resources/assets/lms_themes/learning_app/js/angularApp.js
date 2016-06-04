(function(){
    'use strict';

    var allModule = [
    'ui.bootstrap',
    'ngSanitize',
    'ngResource',
    'pascalprecht.translate',
    'angular-google-gapi'
    ];

    if(typeof window.ngModule != "undefined"){
        allModule = allModule.concat(window.ngModule);
    }
    
    angular
    .module('Lms_App', allModule)
    .config(config)
    .constant('CONTS_COUNTRY', COUNTRY)
    .run(['GAuth', 'GApi', 'GData','$rootScope',run]);

    function config($translateProvider){
        //Multi Language
        $translateProvider.translations('En', LANG_EN);
        $translateProvider.translations('Vn', LANG_VI);
        $translateProvider.preferredLanguage(LANG);
    }

    function run(GAuth, GApi, GData, $rootScope){
        //Google
        var CLIENT = window.googleID_JS;
        GApi.load('calendar','v3'); // for google api (https://developers.google.com/apis-explorer/)
        GAuth.setClient(CLIENT);
        GAuth.setScope("https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar.readonly"); // default scope is only https://www.googleapis.com/auth/userinfo.email

        //Facebook
        window.fbAsyncInit = function() {
            FB.init({
                appId      : window.facebookID,
                status     : true,
                xfbml      : true,
                version    : 'v2.5'
            });
        };        
    }

    angular.element(document).ready(function() {
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    });
    
})();