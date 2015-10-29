/**
 * flower garden
 */

var controllers = angular.module('CodeChallengeApp.controllers', ['ui.bootstrap']).
   controller('CodeChallengeController', function($scope, rlAPIservice) {
      $scope.filteredReviews = [];
      $scope.currentPage = 1;
      $scope.numPerPage = 1;
      $scope.maxSize = 5;

      rlAPIservice.getResponse().success(function(response) {
         $scope.business_info = response.business_info;
         $scope.reviews = response.reviews;
         $scope.totalItems = response.reviews.length;

         $scope.$watch('currentPage + numPerPage', function() {
            var begin = (($scope.currentPage - 1) * $scope.numPerPage);
            var end = begin + $scope.numPerPage;
          
            $scope.filteredReviews = $scope.reviews.slice(begin, end);
         });

         console.log(response.business_info.business_name);
         console.log('total items count: ' + response.reviews.length);
      });
   });
