/***************************************************
Description: Cấu hình website
****************************************************/
var settingJs = (function(){
	'use strict';

	return {
		appPrefix: 'bzSkeleton',
		baseUrl: 'https://dev.bizzon.com.vn/ngskeleton/',
		apiVersion: 'api/',
		language: 'vi',														// Ngôn ngữ website
		/* bzs:facebook */
		facebook: {
			appId: '870470899727751',										// Facebook ID [local:870470899727751, dev: 1016667048377053
			version: 'v2.5',												// Phiên bản API,
			permissions: 'publish_actions,email,user_posts,user_photos',	// Quyền truy cập facebook
			cookie: true,
            xfbml: true
		},
		/* end:bzs:facebook */
		google: {
			gaIds: ['']														// Google Analytics ID
			/* bzs:recaptcha */
			,reCaptchaPublicKey: '6LcXmRQTAAAAAD5IaMRhJK7hYgvJXp5Zl-Nd6_AS',// Recaptcha key [dev: 6LcXmRQTAAAAAD5IaMRhJK7hYgvJXp5Zl-Nd6_AS]
			reCaptchaTheme: 'clean'											// Recaptcha theme
			/* end:bzs:recaptcha */
		},
		requestTimeout:30000,												// Thời hạn gửi request AJAX
		storageExpireTime: 900,												// Thời hạn sẽ hủy dữ liệu localStorage
		preloadResource: []
	}
})();