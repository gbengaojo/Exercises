var services = angular.module('CodeChallengeApp.services', []).
   factory('rlAPIservice', function($http) {

      var rlAPI = {};

      rlAPI.getResponse = function() {
         return $http({
            method: 'post',
            url: 'scripts/localfeedbackloop.php'
         });
      }

      return rlAPI;
   });
