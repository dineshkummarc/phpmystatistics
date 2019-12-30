<?php @session_start(); if ( $_SESSION [ 'hidden_stat' ] != md5_file ( 'config/config.php' ) ) { include ( 'func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/06/18                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( 'config/config.php'                ); // include path to logfile
include ( $language                          ); // include language vars
include ( $language_patterns                 ); // include language country vars
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( 'config/config_db.php'           ); // include db_prefix
  include ( 'func/func_db_connect.php'       ); // include database connectivity
 }
//------------------------------------------------------------------------------
include ( 'func/func_pattern_reverse.php'    ); // include pattern reverse function
include ( 'func/func_pattern_matching.php'   ); // include pattern matching function
include ( 'func/func_pattern_icons.php'      ); // include pattern icons function
include ( 'func/func_kill_special_chars.php' ); // include umlaut function
include ( 'func/func_display.php'            ); // include display function
$detail_logfile  = $_GET [ 'detail_logfile'  ]; // which module details should be shown
//------------------------------------------------------------------------------
// include the saved arrays, depending on archive yes or no
if ( isset ( $_GET [ 'archive_save' ] ) )
 {
  if ( substr ( $_GET [ 'archive_save' ] , 0 , 3 ) == 'log' ) { include ( $_GET [ 'archive_save' ] ); }
 }
elseif ( isset ( $_GET [ 'archive' ] ) && $_GET [ 'archive' ] == 1 )
 {
  include ( 'log/cache_visitors_archive.php' );
 }
else { include ( 'log/cache_visitors.php' ); }
//------------------------------------------------------------------------------
include ( 'func/html_header.php' ); // include html header with table sorting
//------------------------------------------------------------------------------
// browser
if ( $detail_logfile == "pattern_browser.dta" )
 {
  if ( count ( $browser ) != 0 )
   {
    // check if details of every browser should be displayed
    if ( ( $show_detailed_browser == 0 ) && ( $browser ) )
     {
      foreach ( $browser as $key => $value )
       {
        $browser_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] = $browser_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] + $value;
       }
      $browser = $browser_simple;
     }
	  // consolidates browser version to one minor version
	  if ( ( $show_detailed_browser == 1 ) && ( $browser ) )
	   {
	    foreach ( $browser as $key => $value )
	     {
	  	  if ( ( strpos ( $key , "." ) ) === false )
	  	   {
	  	    $browser_simple [ trim ( $key ) ] = $browser_simple [ trim ( $key ) ] + $value;
	  	   }
	  	  else
	  	   {
	  	    $browser_simple [ trim ( substr ( $key , 0 , strpos ( $key , "." ) + 2 ) ) ] = $browser_simple [ trim ( substr ( $key , 0 , strpos ( $key , "." ) + 2 ) ) ] + $value;
	  	   }
	     }
	    $browser = $browser_simple;
	   }
	  unset ( $browser_simple );
    $max_value = array_sum ( $browser );
    arsort ( $browser );
    display ( $lang_browser[1] , $lang_browser[2] , $lang_module[1] , $lang_module[2] , $browser , "100%" , count( $browser ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 1 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// os
if ( $detail_logfile == "pattern_operating_system.dta" )
 {
  if ( count ( $operating_system ) != 0 )
   {
    // check if details of every operating system should be displayed
    if ( ( $show_detailed_os == 0 ) && ( $operating_system ) )
	   {
	    foreach ( $operating_system as $key => $value )
	     {
	  	  $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] = $operating_system_simple [ trim ( substr ( $key , 0 , strrpos ( $key , " " ) ) ) ] + $value;
	     }
	    $operating_system = $operating_system_simple;
	   }
	  unset ( $operating_system_simple );
    $max_value = array_sum ( $operating_system );
    arsort ( $operating_system );
    display ( $lang_os[1] , $lang_os[2] , $lang_module[1] , $lang_module[2] , $operating_system , "100%" , count( $operating_system ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 1 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// resolotion
if ( $detail_logfile == "pattern_resolution.dta" )
 {
  if ( count ( $resolution ) != 0 )
   {
    $max_value = array_sum ( $resolution );
    arsort ( $resolution );
    display ( $lang_resolution[1] , $lang_resolution[2] , $lang_module[1] , $lang_module[2] , $resolution , "100%" , count( $resolution ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// referer
if ( $detail_logfile == "referer" )
 {
  if ( count ( $referer ) != 0 )
   {
    $max_value = array_sum ( $referer );
    arsort ( $referer );
    display ( $lang_referer[1] , $lang_referer[2] , $lang_module[1] , $lang_module[2] , $referer , "100%" , 1000 , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// sitename
if ( $detail_logfile == "site_name" )
 {
  if ( count ( $site_name ) != 0 )
   {
    $max_value = array_sum ( $site_name );
    $temp_site_name_array = array ();
    foreach ( $site_name as $key => $value )
     {
      if ( $db_active == 1 )
       {
        $temp_site_name_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
      else
       {
        $temp_site_name_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
     }
    $site_name = $temp_site_name_array;
    unset ( $temp_site_name_array );
    arsort ( $site_name );
    display ( $lang_site[1] , $lang_site[2] , $lang_module[1] , $lang_module[2] , $site_name , "100%" , count( $site_name ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// entrysite
if ( $detail_logfile == "entrysite" )
 {
  if ( count ( $entrysite ) != 0 )
   {
    $max_value = array_sum ( $entrysite );
    $temp_entrysite_array = array ();
    foreach ( $entrysite as $key => $value )
     {
      if ( $db_active == 1 )
       {
        $temp_entrysite_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
      else
       {
        $temp_entrysite_array [ kill_special_chars ( pattern_matching_reverse ( "site_name_reverse" , $pattern_site_name [ $key ] ) ) ] += $value;
       }
     }
    $entrysite = $temp_entrysite_array;
    unset ( $temp_entrysite_array );
    arsort ( $entrysite );
    display ( $lang_entrysite[1] , $lang_entrysite[2] , $lang_module[1] , $lang_module[2] , $entrysite , "100%" , count( $entrysite ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// searchengines_archive
if ( $detail_logfile == "searchengines_archive" )
 {
  if ( count ( $searchengines_archive ) != 0 )
   {
    $max_value = array_sum ( $searchengines_archive );
    arsort ( $searchengines_archive );
    display ( $lang_searchengine[1] , $lang_searchengine[2] , $lang_module[1] , $lang_module[2] , $searchengines_archive , "100%" , count( $searchengines_archive ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// searchwords_special
if ( $detail_logfile == "searchwords_archive_special" )
 {
  if ( count ( $searchwords_archive ) != 0 )
   {
    $searchwords_archive_temp = array ();
     foreach ( $searchwords_archive as $key => $value )
      {
       $key = str_replace( "&quot;" , "" , $key );
       $temp_split = explode ( " " , $key );
       foreach ( $temp_split as $splitted )
        {
         if ( trim ( $splitted ) != "" )
          {
           if ( array_key_exists ( $splitted , $searchwords_archive_temp ) )
            {
             $searchwords_archive_temp [ $splitted ] += $value;
            }
           else
            {
             $searchwords_archive_temp [ $splitted ] = $value;
            }
          }
        }
      }
    $searchwords_archive =  $searchwords_archive_temp;
    unset ( $searchwords_archive_temp );

    $max_value = array_sum ( $searchwords_archive );
    arsort ( $searchwords_archive );
    display ( $lang_searchwords[1] , $lang_searchwords[2] , $lang_module[1] , $lang_module[2] , $searchwords_archive , "100%" , count( $searchwords_archive ) , $lang_module[3], $delete_year , $max_value , "y"  , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// searchwords
if ( $detail_logfile == "searchwords_archive" )
 {
  if ( count ( $searchwords_archive ) != 0 )
   {
    $max_value = array_sum ( $searchwords_archive );
    arsort ( $searchwords_archive );
    display ( $lang_searchwords[1] , $lang_searchwords[2] , $lang_module[1] , $lang_module[2] , $searchwords_archive , "100%" , count( $searchwords_archive ) , $lang_module[3], $delete_year , $max_value , "y"  , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// visitors per day
if ( $detail_logfile == "visitors_per_day" )
 {
  if ( count ( $visitor_day ) != 0 )
   {
    $max_value = array_sum ( $visitor_day );
    ksort ( $visitor_day );
    display ( $lang_day[3] , $lang_day[2] , $lang_module[1] , $lang_module[2] , $visitor_day , "100%" , count( $visitor_day ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// visitors per month
if ( $detail_logfile == "visitors_per_month" )
 {
  if ( count ( $visitor_month ) != 0 )
   {
    $max_value = array_sum ( $visitor_month );
    ksort ( $visitor_month );
    display ( $lang_month[1] , $lang_month[2] , $lang_module[1] , $lang_module[2] , $visitor_month , "100%" , count( $visitor_month ) , $lang_module[3] , $delete_year , $max_value , "y" , 0 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// trends per month
if ( $detail_logfile == "trends_month" )
 {
  include ( 'func/func_display_trends.php' );

  if ( count ( $visitor_month ) != 0 )
   {
    //------------------------------------------------------
    // get the real first tracking timestamp
    $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
    $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
    $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];

    // if the first line in the logfile is empty, we take the second line
    if ( $real_first_timestamp == 0 )
     {
      $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
      $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];
     }

    fclose ( $logfile_first_timestamp ); // close logfile
    unset  ( $logfile_first_timestamp );
    //---
    //how many days exist in the first year/month the tracking started
    if ( date ( "Y/m" , $real_first_timestamp ) == date ( "Y/m" ) )
     {
      $month_first = ( int ) round ( ( time ( ) - $real_first_timestamp ) / 86400 );
     }
    else
     {
      $month_first = ( int ) round ( ( mktime ( 23 , 59 , 59 , date ( "m" , $real_first_timestamp ) , date ( "t" , $real_first_timestamp ) , date ( "Y" , $real_first_timestamp ) ) - $real_first_timestamp ) / 86400 );
     }
    //---
    foreach ( $visitor_month as $key => $value )
     {
      // if the year/month of the stat start == actual year/month
      if ( date ( "Y/m" , $real_first_timestamp ) == date ( "Y/m" , strtotime ( $key.'/1' ) ) )
       {
        $month_complete [ $key ] = ( int ) round ( ( $value / $month_first ) );
       }
      else
       {
        if ( date ( "Y/m" ) == date ( "Y/m" , strtotime ( $key.'/1' ) ) )
         {
          if ( date ( "Y/m" ) == date ( "Y/m" , $real_first_timestamp ) )
           {
            $month_complete [ $key ] = ( int ) round ( ( $value / $month_first ) );
           }
          else
           {
            $temp = ( int ) round ( ( time ( ) - mktime ( 0 , 0 , 1 , date ( "m" ) , 1 , date ( "Y" ) ) ) / 86400 );
            $month_complete [ $key ] = ( int ) round ( ( $value / $temp ) );
            unset ( $temp );
           }
         }
        else
         {
          $month_complete [ $key ] = ( int ) round ( ( $value / date ( "t" , mktime ( 22 , 00 , 00 , substr ( $key , 5 , 2 ) , 15 , substr ( $key , 0 , 4 ) ) ) ) );
         }
       }
     }
    //------------------------------------------------------
    // start detail module month
    echo '<div class="module">
    <div class="module-header">'.$lang_trend[2].'</div>
    <div class="module-content">
    <table class="module-table">
    <tr>
      <th style="text-align:left">'.$lang_month[2].'</th>
      <th style="text-align:center">'.$lang_module[2].'</th>
      <th style="text-align:right; padding-right:8px">'.$lang_trend[1].'</th>
      <th style="text-align:right; padding-right:8px">'.$lang_counter[6].'</th>
      <th style="text-align:right; padding-right:8px; border-right:1px outset #6F6F6F">&nbsp;</th>
      <th style="text-align:right; padding-right:8px">'.$lang_trend[1].'</th>
      <th style="text-align:right; padding-right:8px">'.$lang_overview[1].'</th>
      <th>&nbsp;</th>
    </tr>
    ';
    ksort ( $visitor_month  );
    ksort ( $month_complete );
    display_trends ( $visitor_month , $month_complete , 0 );
    echo '</table>
    </div> <!-- module-content -->
    <div class="module-footer">&nbsp;</div>
    </div> <!-- module -->';
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// trends per year
if ( $detail_logfile == "trends_year" )
 {
  include ( 'func/func_display_trends.php' );
  //-----
  if ( count ( $visitor_year ) != 0 )
   {
    //------------------------------------------------------
    // get the real first tracking timestamp
    $logfile_first_timestamp = fopen ( "log/logdb_backup.dta" , "r" ); // open logfile
    $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
    $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];

    // if the first line in the logfile is empty, we take the second line
    if ( $real_first_timestamp == 0 )
     {
      $logfile_real_first_timestamp = fgetcsv ( $logfile_first_timestamp , 60000 , "|" );
      $real_first_timestamp = $logfile_real_first_timestamp [ 0 ];
     }

    fclose ( $logfile_first_timestamp ); // close logfile
    unset  ( $logfile_first_timestamp );
    //-----
    //how many days exist in the first year the tracking started
    if ( date ( "Y" , $real_first_timestamp ) == date ( "Y" ) )
     {
      $year_first = ( int ) round ( ( time ( ) - $real_first_timestamp ) / 86400 );
     }
    else
     {
      $year_first = ( int ) round ( ( mktime ( 23 , 59 , 59 , 12 , 31 , date ( "Y" , $real_first_timestamp ) ) - $real_first_timestamp ) / 86400 );
     }
    //-----
    $year_complete = array ( );
    foreach ( $visitor_year as $key => $value )
     {
      // the key value in the cache_visitors array is set to " 2007 ", thats why the trim function
      $key = trim ( $key );

      // if the year of the stat start == actual year
      if ( date ( "Y" , $real_first_timestamp ) == date ( "Y" , strtotime ( $key.'/1/1' ) ) )
       {
        $year_complete [ $key ] = ( int ) round ( ( $value / $year_first ) );
       }
      else
       {
        if ( date ( "Y" ) == date ( "Y" , strtotime ( $key.'/1/1' ) ) )
         {
          if ( date ( "Y" ) == date ( "Y" , $real_first_timestamp ) )
           {
            $year_complete [ $key ] = ( int ) round ( ( $value / $year_first ) );
           }
          else
           {
            $temp = ( int ) round ( ( time ( ) - mktime ( 23 , 59 , 59 , 1 , 1 , date ( "Y" ) ) ) / 86400 );
            $year_complete [ $key ] = ( int ) round ( ( $value / $temp ) );
            unset ( $temp );
           }
         }
        else
         {
          $year_complete [ $key ] = ( int ) round ( ( $value / 365 ) );
         }
       }
     }
    //---------------------------------------------------
    // start detail module years
    echo '<div class="module">
    <div class="module-header">'.$lang_trend[3].'</div>
    <div class="module-content">
    <table class="module-table">
    <tr>
     <th style="text-align:left">'.$lang_year[2].'</th>
     <th style="text-align:center">'.$lang_module[2].'</th>
     <th style="text-align:right; padding-right:8px">'.$lang_trend[1].'</th>
     <th style="text-align:right; padding-right:8px">'.$lang_counter[6].'</th>
     <th style="text-align:right; padding-right:8px; border-right:1px outset #6f6f6f">&nbsp;</th>
     <th style="text-align:right; padding-right:8px">'.$lang_trend[1].'</th>
     <th style="text-align:right; padding-right:8px">'.$lang_overview[1].'</th>
     <th>&nbsp;</th>
    </tr>
    ';
    ksort ( $visitor_year  );
    ksort ( $year_complete );
    display_trends ( $year_complete , $visitor_year , 1 );
    echo '</table>
    </div> <!-- module-content -->
    <div class="module-footer">&nbsp;</div>
    </div> <!-- module -->';
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//--------------------------------------------------------------------
// country
if ( $detail_logfile == "country" )
 {
  if ( count ( $country ) != 0 )
   {
    $country_full = array ();
    foreach ( $country as $key => $value )
     {
      //--------------------------------
      if ( ( $key == "unknown" ) || ( $key == "-" ) )
       {
        $country_full [ $lang_module[3] ] = $value;
       }
      else
       {
        $country_full [ $country_array [ $key ]." (".$key.")" ] = $value;
       }
      //--------------------------------
     }
    $max_value = array_sum ( $country_full );
    arsort ( $country_full );
    display ( $lang_country[1] , $lang_country[2] , $lang_module[1] , $lang_module[2] , $country_full , "100%" , count( $country_full ) , $lang_module[3] , $delete_year , $max_value , "y" , 1 , 0 , 0 , 0 );
   }
  include ( 'func/html_footer.php' );
  exit;
 }
//------------------------------------------------------------------------------
include ( 'func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>