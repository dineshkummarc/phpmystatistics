<?php @session_start(); if ( $_SESSION [ 'hidden_stat' ] != md5_file ( '../config/config.php' ) ) { $error_path = '../'; include ( '../func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/10/07                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
clearstatcache ();
//------------------------------------------------------------------------------
$bgcolor = "#F0F0EE";
$percent = 0;
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) )
 {
  if ( $_GET [ 'parameter' ] == 'stat' )
   {
    $bgcolor = "#F0F0EE";
    include ( '../log/cache_memory_address.php' );
    $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
   }
  //------------------------------------------------------------------------------
  if ( $_GET [ 'parameter' ] == 'archive' )
   {
    $bgcolor = "#F0F0EE";
    include ( '../log/cache_memory_address.php' );
    $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
   }
  //------------------------------------------------------------------------------
  if ( $_GET [ 'parameter' ] == 'cache_panel' )
   {
    $bgcolor = "#EBE8D8";
    if ( !is_readable ( "../log/cache_memory_address.php" ) )
     { $percent = 0; }
    else
     {
      include ( '../log/cache_memory_address.php' );
      $percent = ( int ) round ( $cache_memory_address / filesize ( "../log/logdb_backup.dta" ) * 100 );
     }
   }
 }
//------------------------------------------------------------------------------
if ( ( isset ( $percent ) ) && ( $percent < 100 ) )
 { $refresh = "<meta http-equiv=\"refresh\" content=\"3; URL=func_cache_control.php?parameter=".strip_tags ( $_GET [ 'parameter' ] )."\">"; }
else
 { $refresh = ""; }
//------------------------------------------------------------------------------
if ( ( isset ( $percent ) ) && ( $percent > 5 ) )
 { $percent_text = $percent.'%'; }
else
 { $percent_text = ""; }
//------------------------------------------------------------------------------
echo '<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Check Timstamp</title>
  <meta name="title" content="PHP Web Stat - Check Timstamp">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css">
  '.$refresh.'
  <style type="text/css">
    body {background-color:'.$bgcolor.'; margin:0px;}
  </style>
</head>
<body>
<div class="progress" style="width:398px; margin:auto">
  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="'.$percent.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$percent.'%">'.$percent_text.'</div>
</div>
</body>
</html>';
//------------------------------------------------------------------------------
?>