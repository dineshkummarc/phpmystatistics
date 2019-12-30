<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/05/09                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
if ( !isset ( $error_path ) ) { $error_path = "../"; }
//------------------------------------------------------------------------------
echo'<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Error</title>
  <meta name="title" content="PHP Web Stat - Error">
  <style type="text/css">
    body     { margin: 20px 80px 0px 80px; background: #FFFFFF url('.strip_tags ( $error_path ).'images/error_bg.png) repeat-x; font-size: 14px; font-weight: bold; }
    #info    { font-size: 24px; color: #446D8C; font-family: Arial, Verdana, Sans Serif; }
    .site    { color: #CC0000; }
    #info_de { width: 100%; border: 1px solid #BEDCE7; background: #EAF2F5; color: #446D8C; padding: 10px; }
    #info_en { width: 100%; border: 1px solid #BEDCE7; background: #EAF2F5; color: #446D8C; padding: 10px; }
    .info    { margin-right: 20px; }
    .flag    { margin-right: 20px; margin-bottom: 20px; float: left; }
    #copy    { position:absolute; bottom: 0px; left: 50%; width: 500px; height: 30px; text-align: center; margin-left: -250px; }
    a        { color: #002E45; }
    a:hover, a:focus { color: #23527c; }
  </style>
</head>
<body id="grad">
<div id="content">
  <div id="info">
   <img class="info" src="'.strip_tags ( $error_path ).'images/error_info.png" style="border:0; width:64px; height:64px" alt="info">
   Access Denied
  </div>
  <br />
  <div id="info_de">
   <img class="flag" src="'.strip_tags ( $error_path ).'images/error_flag_de.jpg" style="border:0; width:34px; height:17px" alt="flag">
   Sie sind nicht berechtigt die von Ihnen aufgerufene Seite <span class="site">'.basename ( $_SERVER [ "PHP_SELF" ] ).'</span> zu betreten.
  </div>
  <br />
  <div id="info_en">
   <img class="flag" src="'.strip_tags ( $error_path ).'images/error_flag_gb.jpg" style="border:0; width:34px; height:17px" alt="flag">
   You are not authorized to access the selected page <span class="site">'.basename ( $_SERVER [ "PHP_SELF" ] ).'</span>.
  </div>
</div>
<div id="copy">
 &copy; Copyright '.date ( "Y" ).' <a href="https://www.php-web-statistik.de">PHP Web Stat</a> All Rights Reserved
</div>
</body>
</html>
';
//------------------------------------------------------------------------------
?>