<?php
require 'sample_response.php';
?>
<!doctype html>
<html lang="en">
<head>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
   <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
   <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.5/angular-route.min.js"></script>
   <script src="bower_components/angular-animate/angular-animate.min.js"></script>
   <script src="js/ui-bootstrap-tpls-0.13.4.min.js"></script>
   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> 
</head>

<title>Reputation Loop Code Challenge</title>

<body>

<div class="container-fluid" id="ng-app" ng-app="CodeChallengeApp" ng-controller="CodeChallengeController">
   <header>
      <h4>Reputation Loop Code Challenge</h4>
   </header>

   <section id="business_info">
      <div class="col-md-4">
         <p>Business Name: {{business_info.business_name}}</p>
      </div>
      <div class="col-md-4">
         <p>Address: {{business_info.
      </div>
      <div class="col-md-4">

      </div>
   </section>
</div>

<script src="js/app.js"></script>
<script src="js/services.js"></script>
<script src="js/controllers.js"></script>

</body>

</html>
