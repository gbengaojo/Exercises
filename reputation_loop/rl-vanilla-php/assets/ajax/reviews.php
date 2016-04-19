<?php
require_once '../../classes/ReputationLoop.php';

if (is_numeric($_GET['page_no'])) { // simple input validation
   $page_no = $_GET['page_no'];
   echo json_encode($rl_response->reviews[$page_no]);
} else {
   // malicious payload
   echo 'error';
}
