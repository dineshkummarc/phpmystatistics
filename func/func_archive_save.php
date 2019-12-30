<?php @session_start(); if ( $_SESSION [ "hidden_stat" ] != md5_file ( "../config/config.php" ) ) { $error_path = "../"; include ( "../func/func_error.php" ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/05/09                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( "../config/config.php" ); // include path to style
include ( "../".$language        ); // include language
//------------------------------------------------------------------------------
echo '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>PHP Web Stat</title>
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css">
  <style type="text/css">
    body { background-color: transparent; margin: 0px; }
  </style>
</head>
<body>';
//------------------------------------------------------------------------------
// if the archive should be saved
if ( ( isset ( $_POST [ "from_timestamp" ] ) ) && ( isset ( $_POST [ "until_timestamp" ] ) ) )
 {
  //------------------------------------------------------------------
  if ( !is_numeric ( $_POST [ "from_timestamp"  ] ) ) { exit; }
  if ( !is_numeric ( $_POST [ "until_timestamp" ] ) ) { exit; }
  //------------------------------------------------------------------
  if ( $_SESSION [ "loggedin" ] == "admin" )
   {
    if ( !copy ( "../log/cache_visitors_archive.php" , "../log/archive/".$_POST [ "from_timestamp" ]."-".$_POST [ "until_timestamp" ].".php" ) )
     {
      echo $lang_archive[8]."\n";
     }
    else
     {
      echo '<b>'.$lang_archive[9].'</b>';
      exit;
     }
   }
  else
   {
    echo $lang_archive[8];
   }
  //------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------
  // form to save the displayed archive
  echo '
  <div style="text-align:right; line-height:50px">
    <form name="save" action="func_archive_save.php" method="post">
    <input type="hidden" name="from_timestamp" value="'.$_GET [ "from_timestamp" ].'">
    <input type="hidden" name="until_timestamp" value="'.$_GET [ "until_timestamp" ].'">
    <div style="float:right; margin-left:10px; line-height:20px">
      <a class="archive-save" href="#" onclick="document.forms[\'save\'].submit()"><span class="glyphicon glyphicon-save" style="font-size:16px" title="'.$lang_archive[11].'"></span></a>
    </div>
    <div class="archive-save" style="float:right; line-height:18px">
      '.$lang_archive[10].'
    </div>
    </form>
  </div>';
  //------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
echo '
</body>
</html>
';
//------------------------------------------------------------------------------
?>