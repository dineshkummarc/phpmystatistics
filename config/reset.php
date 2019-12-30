<?php @session_start(); if ( $_SESSION [ 'hidden_func' ] != md5_file ( 'config.php' ) ) { $error_path = '../'; include ( '../func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/05/14                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config.php'              ); // include path to logfile
include ( 'config_db.php'           ); // include path to db_prefix
include ( '../'.substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
include ( '../func/html_header.php' ); // include html header
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'action' ] ) && $_GET [ 'action' ] == 'reset' )
 {
  if ( !isset ( $_POST [ 'startsite' ] ) )
   {
   	echo '
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <form style="margin:0px;" name="reset" action="'.$_POST [ 'PHP_SELF' ].'" method="post">
    <tr>
      <td class="th2 bold center" style="height:34px; padding:2px; color:#CC0000; font-size:18px; border-bottom:1px solid #0D638A;"><img src="../images/alert.gif" border="0" alt="" title="">&nbsp; &nbsp; &nbsp;'.$lang_admin_sr[6].'&nbsp; &nbsp; &nbsp;<img src="../images/alert.gif" border="0" alt="" title=""></td>
    </tr>
    <tr>
      <td class="bg1 warning bold center" style="vertical-align:middle;">'.$lang_admin_sr[7].'</td>
    </tr>
    <tr>
      <td class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;">
      <input type="hidden" name="startsite" value="1">  <!--hidden field site-->
      <input type="submit" class="submit" value="'.$lang_admin_sr[8].'">
      </td>
    </tr>
    </form>
    </table>
    ';
   }
  else
   {
    // empty the cache files
    //----------------------
    // empty the cache_time_stamp.php
    $logfile = fopen ( "../log/cache_time_stamp.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    // empty the cache_time_stamp_archive.php
    $logfile = fopen ( "../log/cache_time_stamp_archive.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    // empty the cache_visitors.php
    $logfile = fopen ( "../log/cache_visitors.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    // empty the cache_visitors_archive.php
    $logfile = fopen ( "../log/cache_visitors_archive.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    // empty the cache_visitors_counter.php
    $logfile = fopen ( "../log/cache_visitors_counter.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    // empty the index_days.php
    $logfile = fopen ( "../log/index_days.php" , "r+" );
    flock ( $logfile , LOCK_EX );
     ftruncate ( $logfile , 0 );
     fwrite ( $logfile , "<?php \$index_days = array ( 0 ); ?>" );
    flock ( $logfile , LOCK_UN );
    fclose ( $logfile );
    unset  ( $logfile );
    //--------------------------------------------------------------------------
    if ( $db_active == 1 )
     {
      //--------------------
      $dirname  = "config";
      $filename = "reset";
      include ( '../func/func_db_connect.php' );
      //--------------------
      // empty the db_tables
      //--------------------
      // empty the browser table
      $query  = "TRUNCATE TABLE ".$db_prefix."_browser";
      $result = db_query ( $query , 0 , 0 );
      // empty the domain table
      $query  = "TRUNCATE TABLE ".$db_prefix."_domain";
      $result = db_query ( $query , 0 , 0 );
      // empty the main table
      $query  = "TRUNCATE TABLE ".$db_prefix."_main";
      $result = db_query ( $query , 0 , 0 );
      // empty the operating_system table
      $query  = "TRUNCATE TABLE ".$db_prefix."_operating_system";
      $result = db_query ( $query , 0 , 0 );
      // empty the referrer table
      $query  = "TRUNCATE TABLE ".$db_prefix."_referrer";
      $result = db_query ( $query , 0 , 0 );
      // empty the resolution table
      $query  = "TRUNCATE TABLE ".$db_prefix."_resolution";
      $result = db_query ( $query , 0 , 0 );
      // empty the site_name table
      $query  = "TRUNCATE TABLE ".$db_prefix."_site_name";
      $result = db_query ( $query , 0 , 0 );
      //--------------------

      // set the first pattern id
      //--------------------
      // pattern browser
      $query = "INSERT INTO ".$db_prefix."_browser VALUES ('1', 'unknown')";
      $result = db_query ( $query , 0 , 0 );
      // pattern operating system
      $query = "INSERT INTO ".$db_prefix."_operating_system VALUES ('1', 'unknown')";
      $result = db_query ( $query , 0 , 0 );
      // pattern referrer
      $query = "INSERT INTO ".$db_prefix."_referrer VALUES ('1', '---')";
      $result = db_query ( $query , 0 , 0 );
      // pattern resolution
      $query = "INSERT INTO ".$db_prefix."_resolution VALUES ('1', 'unknown')";
      $result = db_query ( $query , 0 , 0 );
      // pattern site name
      $query = "INSERT INTO ".$db_prefix."_site_name VALUES ('1', '---')";
      $result = db_query ( $query , 0 , 0 );
      //--------------------
     }
    else
     {
      // empty the log files
      //--------------------
      // empty the last_logins.dta
      $logfile = fopen ( "../log/last_logins.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the last_timestamp.dta
      $logfile = fopen ( "../log/last_timestamp.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the logdb.dta
      $logfile = fopen ( "../log/logdb.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the logdb_backup.dta
      $logfile = fopen ( "../log/logdb_backup.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the logdb_temp.dta
      $logfile = fopen ( "../log/logdb_temp.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the timestamp_cache_update.dta
      $logfile = fopen ( "../log/timestamp_cache_update.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );

      // empty the pattern files
      //------------------------
      // empty the pattern_browser.dta
      $logfile = fopen ( "../log/pattern_browser.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the pattern_operating_system.dta
      $logfile = fopen ( "../log/pattern_operating_system.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the pattern_referer.dta
      $logfile = fopen ( "../log/pattern_referer.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the pattern_resolution.dta
      $logfile = fopen ( "../log/pattern_resolution.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      // empty the pattern_site_name.dta
      $logfile = fopen ( "../log/pattern_site_name.dta" , "w" );
      fclose ( $logfile );
      unset  ( $logfile );
      //------------------------
     }
    //--------------------------------------------------------------------------
   	echo '
    <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="th2 bold center" style="height:18px; padding:2px; border-bottom:1px solid #0D638A;">'.$lang_admin_sr[9].'</td>
    </tr>
    <tr>
      <td class="bg3 bold center" style="width:100%; vertical-align:middle; font-size:16px;">'.$lang_admin_sr[10].'</td>
    </tr>
    </table>
    ';
   }
  include ( '../func/html_footer.php' ); // include html footer
  exit;
 }
//-------------------------------------------------------------------------------
echo '
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td class="bg1" style="vertical-align:top; padding:20px 50px 0px 50px;">'.$lang_admin_sr[2].'<br><br>'.$lang_admin_sr[3].'<br><br>'.$lang_admin_sr[4].'</td>
</tr>
<tr>
  <td class="th2 center" style="height:24px; padding:2px; border-top:1px solid #0D638A;"><input type="submit" class="submit" onclick="location.href=\'reset.php?action=reset\'" value="'.$lang_admin_sr[5].'"></td>
</tr>
</table>
';
//-------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//-------------------------------------------------------------------------------
?>