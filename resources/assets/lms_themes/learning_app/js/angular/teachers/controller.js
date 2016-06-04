var teacherJs = (function(){
	'use strict';

	angular
	.module('Lms_App')
	.controller('teacherCtrl', teacherCtrl);
	
	function teacherCtrl($scope, $timeout, $filter, $log, $sce, NgTableParams, ngTableEventsChannel){
		/* jshint validthis: true */
		angular.element('#mod-tutor-list').removeClass('hidden')
		/*Variable*/
		$scope.urlDetail = window.urlDetail;
		$scope.topics = window.topics;
		$scope.teachersAll = window.teachersAll;
		$scope.teachersAll  = formatData($scope.teachersAll);
		// console.log($scope.teachersAll);
		$scope.filters = {
			'topics':[],
			'nationality':'',
			'gender':''
		};
		// console.log('test',$scope.topics);
		/*Function*/
		$scope.changeFilter = changeFilter;
		$scope.clickSearchTopic = clickSearchTopic;
		$scope.getAudioUrl = getAudioUrl;

		$scope.tableParams = new NgTableParams({
			filter:{
			},
			count : 10
		}, { 
			counts: [],
			dataset: $scope.teachersAll
		});

		//Event when change pages
		ngTableEventsChannel.onAfterReloadData(function(){
			$timeout(function(){
				jQuery("html, body").animate({ scrollTop: 0 }, "slow");
				jQuery('input.rating').rating({
					stop: '5'
				});
				tutorJs.voicePlay();
			},500);
		}, $scope);

		//Event when change pages
		// ngTableEventsChannel.onPagesChanged(function(){
		// 	console.log('test',$scope.tableParams.page());
		// }, $scope);

		function changeFilter(field, value){
			$scope.teachersAll = window.teachersAll;
			$scope.teachersAll  = formatData($scope.teachersAll);

			if(field == 'gender'){
				GA('TutorList', 'FilterGender', 'TutorList');
			}else if(field == 'nationality'){
				GA('TutorList', 'FilterNationality', 'TutorList');
			}else if(field == 'topics'){
				GA('TutorList', 'FilterSubject', 'TutorList');
			}
			
			$scope.teachersAll = $filter('teacherFilter')($scope.teachersAll,$scope.filters);
			$scope.tableParams = new NgTableParams({
				count : 10
			}, { 
				counts: [],
				dataset: $scope.teachersAll
			});
		}

		function clickSearchTopic(field, value){
			// console.log('pp',field,value,$scope.tableParams);
			// if(value.length == 0){
				changeFilter(field, value);
			// }

			// $scope.teachersAll = $filter('teacherFilterTopics')($scope.teachersAll,$scope.filters);
			// $scope.tableParams = new NgTableParams({
			// 	count : 10
			// }, { 
			// 	counts: [],
			// 	dataset: $scope.teachersAll
			// });
			
			// $scope.changeFilter(field,value);
		}

		function formatData (data){
			angular.forEach(data, function(value,index){
				value.show_topic = '';
				value.id_topic = [];
				if(value.gender == 'female'){
					value.gender = 'fe';
				}else{
					value.gender = value.gender;
				}
				if(value.topics.length != 0){
					angular.forEach(value.topics, function(value1,index1){
						if(index1 == value.topics.length-1){
							value.show_topic += value1.name;
							value.id_topic.push(value1.id);
						}else{
							value.show_topic += value1.name+', ';
							value.id_topic.push(value1.id);
						}
					})
				}
				formatTaglineView(value);
			})

			return data;
		}

		function formatTaglineView(teacher){
			if(teacher.tagline == null || teacher.tagline.length == 0){
				if(teacher.about_me != null){
					if(teacher.about_me.length > 120){
						teacher.taglineView = teacher.about_me.substr(0,120)+'...';
					}else{
						teacher.taglineView = teacher.about_me;
					}
				}
			}else{
				teacher.taglineView = teacher.tagline.substr(0,120)+'...';
			}
		}

		function getAudioUrl(audio){
			
			return $sce.trustAsResourceUrl(audio);
		}
	}

})();