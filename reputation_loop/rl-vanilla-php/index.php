<?php
// instantiate class and call appropriate method for rl API call; retrieve data (as an object)
// and use this object and its members to populate the business fields on this page, as
// well as the <li> elements for pagination. Use regular beootstrap for pagination.
require_once 'classes/ReputationLoop.php';
?>
<!doctype html>
<html lang="en" id="ng-app" ng-app="CodeChallengeApp">
<head>
   
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
   
   <script type="text/javascript">
      $.fn.stars = function() {
         return $(this).each(function() {
            $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
         });
      }

      function getReview(page_no) {
         console.log('page no: ' + page_no);
         $.post('assets/ajax/reviews.php?page_no=' + page_no,
            function(data) {
               console.log(data);
            }
         );
      }
   </script>

   <style>
      html,body {
         margin: 0px;
         padding: 0px;
         overflow-x: hidden; 
      }

      .container-fluid {
         margin: 10px;
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
         background: url(assets/images/stars.png) 0 -16px repeat-x;
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

<header>
   <h4>Reputation Loop Code Challenge</h4>
</header>

<div class="container-fluid" ng-controller="CodeChallengeController">
   <!-- Business Info -->
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
   <!-- end business info -->

   <!-- Ratings -->
   <section id="ratings">
      <div class="row">
         <div class="col-md-12">
              <!-- pagination -->
              <ul class="pagination">
                 <?php for ($i = 1; $i < count($reviews) - 1; $i++): ?>
                 <li><a href="#" onclick="getReview(<?php echo $i ?>)"><?php echo $i ?></a></li>
                 <?php endfor ?>

              </ul>
              <!-- end pagination -->
         </div>
      </div>

      <div class="row">
         <div class="col-md-6">
            <!-- reviews -->
            <div id="review">
               <span class="stars"><?php echo $reviews[0]->rating ?></span>
               By <a href="<?php echo $reviews[0]->customer_url ?>" target="_blank">
                     <span id="name"><?php echo $reviews[0]->customer_name ?></span>
                  </a>
               on <?php echo date('F d, Y', strtotime($reviews[0]->date_of_submission)) ?>
            </div>
            <div>
                 <?php echo $reviews[0]->description ?>
            </div>
            <div>
               From <?php echo $reviews[0]->review_source ?>
            </div>
         </div>
      </div>
      <!-- end reviews -->
   
   </section>
   <!-- end Ratings -->
</div>

<script type="text/javascript">
$(function() {
   $('span.stars').stars();
});
</script>


</body>

</html>
