<?php
//------------------------------------------------------------------------------
if ( strpos ( strtolower ( $_SERVER [ "PHP_SELF" ] ) , "tracking_code.php" ) > 0 )
 {
  exit;
 }
else
 {
  echo '
  <script src="http://local.rocket.co.in:8081/stat/pws.php?mode=js"></script>
  <noscript><img src="http://local.rocket.co.in:8081/stat/pws.php?mode=img" style="border:0; width:1px; height:1px" alt="noscript-img"></noscript>
  ';
 }
//------------------------------------------------------------------------------
?>