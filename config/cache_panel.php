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
include ( 'config.php' ); // include path to logfile
include ( '../'.substr ( $language , 0 , strpos ( $language , '.' ) ).'_admin.php' ); // include language vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
include ( '../func/html_header.php' ); // include html header
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == 'cache_finished' )
 {
  //--------------------------------
  echo '
  <div style="position:absolute; width:440px; height:260px; border:1px solid #737373; top:50%; left:50%; margin-top:-130px; margin-left:-220px; background-color:#ededed">
    <div style="height:60px; background-image: url(../images/bg_system.gif); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">
      Cache Creator
    </div>
    <div style="height:150px; padding:15px 20px 20px 20px; border-top:1px solid #737373; border-bottom:1px solid #a7a7a7; font-size:11px; line-height:14px">
      '.$lang_admin_cc[9].'
    </div>
    <div style="padding:13px 20px; font-size:11px; line-height:22px">
      Creator v2.4
      <input type="button" class="btn btn-xs" style="float:right" onclick="window.close();" value="'.$lang_admin_cc[11].'">
    </div>
  </div>
  ';
  exit;
  //--------------------------------
 }
//------------------------------------------------------------------------------
// create cache with iframe of the cache_creator
if ( isset ( $_POST [ 'hidden_panel' ] ) )
 {
  if ( $_POST [ 'hidden_panel' ] == $_SESSION [ 'hidden_panel' ] )
   {
    //--------------------------------
    $cache_timestamp_file = fopen ( "../log/cache_time_stamp.php" , "w+" );
     fwrite ( $cache_timestamp_file , "<?php ?>" ); // php header + footer
    fclose ( $cache_timestamp_file );
    unset  ( $cache_timestamp_file );
    //--------------------------------
    $cache_timestamp_file = fopen ( "../log/cache_memory_address.php" , "w+" );
     fwrite ( $cache_timestamp_file , "<?php \$cache_memory_address = \"\";?>" ); // php header + footer
    fclose ( $cache_timestamp_file );
    unset  ( $cache_timestamp_file );
    //--------------------------------
    $cache_visitors_file = fopen ( "../log/cache_visitors.php" , "w+" );
     fwrite ( $cache_visitors_file , "<?php ?>" ); // php header + footer
    fclose ( $cache_visitors_file );
    unset  ( $cache_visitors_file );
    //--------------------------------
    echo '
    <div style="position:absolute; width:440px; height:260px; border:1px solid #737373; top:50%; left:50%; margin-top:-130px; margin-left:-220px; background-color:#ededed">
      <div style="height:60px; background-image: url(../images/bg_system.gif); text-align:right; vertical-align:bottom">
        <iframe name="creator" src="../func/func_load_creator.php?parameter=create_stat_cache" style="width:8px; height:8px; border:none; overflow:hidden"></iframe>
      </div>
      <div style="height:150px; padding:15px 20px 0px 20px; border-top:1px solid #737373; border-bottom:1px solid #a7a7a7; font-size:11px; line-height:14px">
        '.$lang_admin_cc[6].'<br>';
        if ( $db_active == 1 )
         {
          echo '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div>';
         }
        else
         {
          echo '<iframe name="cache_control" src="../func/func_cache_control.php?parameter=cache_panel" style="width:398px; height:20px; border:none; overflow:hidden"></iframe>';
         }
        echo '
        '.$lang_admin_cc[7].'<br>'.$lang_admin_cc[8].'<br><br>
        <iframe name="timestamp_control" src="../func/func_timestamp_control.php?parameter=cache_panel" style="width:200px; height:26px; margin-left:198px; border:none; overflow:hidden"></iframe>
      </div>
      <div style="padding:13px 20px; font-size:11px; line-height:22px">
        Creator v2.4
      </div>
    </div>
    ';
    //--------------------------------
   }
 }
else
 {
  //--------------------------------
  // form to confirm cache creation
  $_SESSION [ 'hidden_panel' ] = md5 ( date ( 'Yzda' ) );
  echo '
  <form style="margin:0px;" name="admin" action="'.$_SERVER [ 'PHP_SELF' ].'" method="post">
  <div style="position:absolute; width:440px; height:260px; border:1px solid #737373; top:50%; left:50%; margin-top:-130px; margin-left:-220px; background-color:#ededed">
    <div style="height:60px; background-image: url(../images/bg_system.gif); text-align:right; vertical-align:top; padding:10px 20px 0px 0px; color:#436783; font-family:Arial Black; font-size:13px;">
      Cache Creator
    </div>
    <div style="height:150px; padding:15px 20px 20px 20px; border-top:1px solid #737373; border-bottom:1px solid #a7a7a7; font-size:11px; line-height:14px">
      '.$lang_admin_cc[1].'<br><br>
      '.$lang_admin_cc[2].'<br><br>
      '.$lang_admin_cc[3].'
    </div>
    <div style="padding:13px 20px; font-size:11px; line-height:22px">
      Creator v2.4
      <input type="hidden" name="hidden_panel" value="'.$_SESSION [ 'hidden_panel' ].'">
      <input type="button" class="btn btn-xs" style="float:right; margin-left:6px" onclick="window.close();" value="'.$lang_admin_cc[5].'">
      <input type="submit" class="btn btn-xs" style="float:right" value="'.$lang_admin_cc[4].'">
    </div>
  </div>
  </form>
  ';
  //--------------------------------
 }
//------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>