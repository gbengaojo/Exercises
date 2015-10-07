/**
 * flower garden
 */

var controllers = angular.module('CodeChallengeApp.controllers', []).
   controller('CodeChallengeController', function($scope, rlAPIservice) {

      rlAPIservice.getResponse().success(function(response) {
         $scope.business_info = response.business_info;
         console.log(response.business_info.business_name);
      });





      $scope.totalItems = 7;
      $scope.currentPage = 1;

      $scope.setPage = function(pageNo) {
         $scope.currentPage = pageNo;
      };

      $scope.pageChanged = function() {
         $log.log('Page changed to: ' + $scope.currentPage);
      };

      $scope.maxSize = 5;
      $scope.bigTotalItems = 10;
      $scope.bigCurrentPage = 1;
   });
