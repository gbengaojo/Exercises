<?php
require 'sample_response.php';
require 'scripts/localfeedbackloop.php';
?>
<!doctype html>
<html lang="en" id="ng-app" ng-app="CodeChallengeApp">
<head>
   
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.5/angular-animate.js"></script>
   <script src="js/ui-bootstrap-tpls-0.13.4.min.js"></script>
   <script src="js/app.js"></script>
   <script src="js/services.js"></script>
   <script src="js/controllers.js"></script>

   <style>
      body {
         margin: 0px;
         padding: 0px;
      }

      .container-fluid {
         margin: 0px;
         padding: 0px;
         font-family: 'Helvetica', 'Arial', sans-serif; 
      }

      header {
         color: #ccc;
         background: no-repeat rgb(49, 64, 75);
         padding-bottom: 20px;
         padding-left: 10px;
         padding-top: 5px;
      }

      .bold {
         font-weight: bold;
      }
   </style>
</head>

<title>Reputation Loop Code Challenge</title>

<body>

<div class="container-fluid" ng-controller="CodeChallengeController">
   <header>
      <h4>Reputation Loop Code Challenge</h4>
   </header>

   <section id="business_info">
      <div class="row">
         <div class="col-md-4">
            <p><span class="bold">Business Name:</span> {{business_info.business_name}}</p>
         </div>
         <div class="col-md-4">
            <p><span class="bold">Address:</span> {{business_info.business_address}}</p>
         </div>
         <div class="col-md-4">
            <p><span class="bold">Phone:</span> {{business_info.business_phone}}</p>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6">
            <p><span class="bold">Average Rating:</span> {{business_info.total_rating.total_avg_rating}}</p>
         </div>
         <div class="col-md-6">
            <p><span class="bold">Number of Reviews:</span> {{business_info.total_rating.total_no_of_reviews}}</p>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6">
            <p><a ng-href="{{business_info.external_url}}">External URL</a></p>
         </div>
         <div class="col-md-6">
            <p><a ng-href="{{business_info.external_page_url}}">External Page URL</a></p>
         </div>
      </div>
   </section>

   <section id="ratings">
      <ul>
         <li ng-repeat="review in filteredReviews"><a href="#">{{review.description}}</a></li>
      </ul>

      <pagination
         ng-model="currentPage"
         total-items="totalItems"
         max-size="maxSize"
         boundary-links="true">
      </pagination>

   </section>
</div>

<!--
<script src="js/app.js"></script>
<script src="js/services.js"></script>
<script src="js/controllers.js"></script>
-->

</body>

</html>
