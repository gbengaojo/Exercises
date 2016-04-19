<?php
// instantiate class and call appropriate method for rl API call; retrieve data (as an object)
// and use this object and its members to populate the business fields on this page, as
// well as the <li> elements for pagination. Use regular beootstrap for pagination.
require_once 'classes/ReputationLoop.php';
?>
<!doctype html>
<html lang="en">
<head>
   
   <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
   <link rel="stylesheet" href="assets/css/style.css">
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
   <script src="bower_components/moment/min/moment-with-locales.min.js" type="text/javascript"></script>
   
   <script type="text/javascript">
      $.fn.stars = function() {
         return $(this).each(function() {
            $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
         });
      }

      // pagination ajax
      function getReview(page_no) {
         page_no = page_no - 1;
         $.post('assets/ajax/reviews.php?page_no=' + page_no,
            function(data) {
               var obj = $.parseJSON(data);
               $('#rating').text(obj.rating);
               $('#rating.stars').stars();  // refresh the rating stars...
               $('#customer_url').attr('href', obj.customer_url);
               $('#customer_name').text(obj.customer_name);
               $('#description').text(obj.description);
               $('#review_source').text(obj.review_source);

               var d = new Date(obj.date_of_submission);
               var date_of_submission = moment(d).format('MMMM D, YYYY hh:mm a');
               // var date_of_submission = moment(d).format('MM/DD/YYYY ');
               $('#date_of_submission').text(date_of_submission);
/*
               // some simple date formatting
               var d = new Date(obj.date_of_submission);
               var date_of_submission = d.toString();
               $('#date_of_submission').text(date_of_submission);
*/
            }
         );
      }

      $(function() {
   $('span.stars').stars();
});

   </script>

</head>

<title>Reputation Loop Code Challenge</title>

<body>

<header>
   <h4>Reputation Loop Code Challenge</h4>
</header>

<div class="container-fluid">
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
            <p><a href="<?php echo $business_info->external_url ?>">Leave a Review</a></p>
         </div>
         <div class="col-md-6">
            <p><a href="<?php echo $business_info->external_page_url ?>">See All Reviews</a></p>
         </div>
      </div>
   </section>
   <!-- end business info -->

   <!-- Ratings and Reviews -->
   <section id="ratings">
      <div class="row">
         <div class="col-md-12">
              <!-- pagination -->
              <ul class="pagination">
                 <?php for ($i = 1; $i < count($reviews) + 1; $i++): ?>
                 <li><a href="#" onclick="getReview(<?php echo $i ?>)"><?php echo $i ?></a></li>
                 <?php endfor ?>

              </ul>
              <!-- end pagination -->
         </div>
      </div>

      <!-- reviews -->
      <div class="row">
         <div class="col-md-6">
            <div id="review">
               <span id="rating" class="stars"><?php echo $reviews[0]->rating ?></span>
               By <a id="customer_url" href="<?php echo $reviews[0]->customer_url ?>" target="_blank">
                     <span id="customer_name"><?php echo $reviews[0]->customer_name ?></span>
                  </a>
               on <span id="date_of_submission"><?php echo date('F j, Y g:i a', strtotime($reviews[0]->date_of_submission)) ?></span>
            </div>
            <div id="description">
                 <?php echo $reviews[0]->description ?>
            </div>
            <div>
               From <span id="review_source"><?php echo $reviews[0]->review_source ?></span>.
            </div>
         </div>
      </div>
      <!-- end reviews -->
   
   </section>
   <!-- end Ratings and Reviews -->
</div>

</body>

</html>
