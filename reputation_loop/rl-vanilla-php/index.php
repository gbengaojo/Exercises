<?php
// instantiate class and call appropriate method for rl API call; retrieve data (as an object)
// and use this object and its members to populate the business fields on this page, as
// well as the <li> elements for pagination. Use regular beootstrap for pagination.
require_once 'classes/ReputationLoop.php';
?>
<!doctype html>
<html lang="en" id="ng-app" ng-app="CodeChallengeApp">
<head>
   
   <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
   
   <script type="text/javascript">
      $.fn.stars = function() {
         return $(this).each(function() {
            $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
         });
      }
   </script>

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

      span.stars, span.stars span {
         display: inline-block;
         background: url(images/stars.png) 0 -16px repeat-x;
         width: 80px;
         height: 16px;
      }

      span.stars span {
         background-position: 0 0;
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
            <p><span class="bold">Business Name:</span> <?php echo $business_info->business_name ?></p>
         </div>
         <div class="col-md-4">
            <p><span class="bold">Address:</span> <?php echo $business_info->business_address ?></p>
         </div>
         <div class="col-md-4">
            <p><span class="bold">Phone:</span> <?php echo $business_info->business_phone ?></p>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6">
            <p><span class="bold">Average Rating: <span class="stars"><?php echo $business_info->total_rating->total_avg_rating ?></span></span></p>
         </div>
         <div class="col-md-6">
            <p><span class="bold">Number of Reviews:</span> <?php echo $business_info->total_rating->total_no_of_reviews ?></p>
         </div>
      </div>

      <div class="row">
         <div class="col-md-6">
            <p><a href="<?php echo $business_info->external_url ?>">External URL</a></p>
         </div>
         <div class="col-md-6">
            <p><a href="<?php echo $business_info->external_page_url ?>">External Page URL</a></p>
         </div>
      </div>
   </section>

   <section id="ratings">
      <ul>
         <?php for ($i = 0; $i < count($reviews); $i++): ?>
         <li><a href="#"><?php echo $reviews[$i]->description ?></a></li>
         <?php endfor ?>
      </ul>
   </section>

   <script type="text/javascript">
   $(function() {
      $('span.stars').stars();
   });
   </script>
</div>

</body>

</html>
