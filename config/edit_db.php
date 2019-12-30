<?php @session_start(); if ( $_SESSION [ 'hidden_func' ] != md5_file ( 'config.php' ) ) { $error_path = '../'; include ( '../func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/01/20                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config.php' ); // include path to style
include ( '../'.substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
$dirname  = "config";
$filename = "edit_db";
include ( '../func/func_db_connect.php' );
//------------------------------------------------------------------------------
if ( isset ( $_POST [ 'sql' ] ) )
 {
  echo '
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
  <head>
   <title>PHP Web Stat</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="pragma"  content="no-cache">
   <meta http-equiv="expires" content="0">
   <link rel="stylesheet" type="text/css" href="../'.$theme.'/style.css" media="screen, projection">
   <style type="text/css">
    body { margin:10px; }
    .result_row1 { background:#FFFFFF; }
    .result_row2 { background:#EBECED; }
   </style>
  </head>
  <body>';
  $result  = db_query ( $_POST [ 'sql' ] , 1 , 0 );
  echo '
  <table id="groundtable" width="100%" cellspacing="0" cellpadding="0"><tr><td><br><big><b>Database Result</b></big><br>
  <table width="100%" border="0" cellspacing="1" cellpadding="0" style="border:1px solid #000000;">';
  $background_split = 1;
  for ( $x = 0 ; $x <= count ( $result ) - 1 ; $x++ )
   {
    if ( ( $background_split % 2 ) == 0 ) { $background = "result_row1"; } else { $background = "result_row2"; }
   	echo '<tr class="'.$background.'">';
    for ( $y = 0 ; $y <= count ( $result[$x] ) - 1 ; $y++ )
     {
   	  echo '<td>';
   	   echo $result[$x][$y];
   	  echo '</td>';
     }
    echo '</tr>';
    $background_split++;
   }
  echo '</table>';
  echo '</td></tr></table>';
 }
else
 {
	echo '
  <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
  <html>
  <head>
   <title>PHP Web Stat</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <meta http-equiv="pragma"  content="no-cache">
   <meta http-equiv="expires" content="0">
   <link rel="stylesheet" type="text/css" href="../themes/admin.css" media="screen, projection">
   <script type="text/javascript" src="../func/win_open.js"></script>
   <style type="text/css">
    body { margin:0px; }
   </style>
  </head>
  <body>
  <form style="display:inline; margin:0px;" method="POST" target="result">
  <table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center" bgcolor="#D7E2EA" style="padding:10px; color:#000000; border-bottom:1px solid #0D638A;">
    <textarea name="sql" rows="6" style="width:100%; background-color:#F9FAFB;"></textarea>
    </td>
  </tr>
  <tr>
    <td class="th2 center" style="height:24px; padding:2px;">
    <input type="submit" class="submit" onclick="db_result();" value="OK">
    </td>
  </tr>
  </table>
  </form>
	';
 }
//------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>