<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/01/21                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( '../config/config.php' ); // check language
//------------------------------------------------------------------------------
$bgcolor = "#f0f0ee";
$check_file = "cache_time_stamp.php";
//------------------------------------------------------------------------------
if ( $language == "language/german.php" )
 {
  $dateform  = "d.m.Y - H:i:s";
 }
else
 {
  $dateform  = "Y/m/d - h:i a";
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == "stat" )
 {
  $bgcolor = "transparent";
  $check_file = "cache_time_stamp.php";
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == "archive" )
 {
  $bgcolor = "transparent";
  $check_file = "cache_time_stamp_archive.php";
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == "cache_panel" )
 {
  $bgcolor = "#ededed";
  $check_file = "cache_time_stamp.php";
 }
//------------------------------------------------------------------------------
echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="refresh" content="3; URL=func_timestamp_control.php?parameter='.strip_tags ( $_GET [ "parameter" ] ).'">
  <title>PHP Web Stat - Check Timstamp</title>
  <style type="text/css">
    body { background-color:'.$bgcolor.'; margin:0px; }
  </style>
</head>
<body>
<table style="width:100%">
<tr>
  <td valign="middle" align="center" style="font-family:Arial,Verdana,Helvetica,sans serif; font-weight:bold; font-size:16px">';
  include ( "../log/".$check_file );
  if ( ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == "cache_panel" ) || ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == "cache_panel_counter" ) )
   {
    if ( isset ( $cache_time_stamp ) && $cache_time_stamp != "" ) { echo date ( $dateform , $cache_time_stamp ); } else { echo '<img src="../images/loading_indicator_24.gif" style="width:24px; height:24px; vertical-align:middle" alt=""> loading...'; }
   }
  else
   {
    if ( isset ( $cache_time_stamp ) && $cache_time_stamp != "" ) { echo date ( $dateform , $cache_time_stamp ); } else { echo 'loading...'; }
   }
  echo '</td>
</tr>
</table>
</body>
</html>';
//------------------------------------------------------------------------------
?>