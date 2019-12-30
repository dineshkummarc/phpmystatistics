<?php @session_start(); @setcookie('sysinfo');
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.1                                                      #
# File-Release-Date:  19/07/20                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2019 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config/config.php' ); // include config
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
if ( $db_active == 1 )
 {
  include ( 'config/config_db.php'     ); // include db prefix
  include ( 'func/func_db_connect.php' ); // include database connectivity
 }
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$stat_version  = file ( "index.php" ); // include stat version
eval($stat_version[32]);
eval($stat_version[33]);
$geoip_version = file ( "func/geoip/LocationIPversion.dat" ); // include geoip version
$sysinfo_vers  = "2.6";  // sysinfo version
$last_edit     = "2019"; // last file release
//------------------------------------------------------------------------------
//check date form & language pack
if ( $language == "language/german.php" )
 {
  $last_log_dateform = "d.m.y, H:i \\U\\h\\r";
  $last_cache_update_dateform = "d.m.y, H:i \\U\\h\\r";
  // language pack de
  $lang_disabled = "deaktiviert";
  $lang_delete_info = "Diese Datei nach erfolgreichem Update der Stat löschen";
  $lang_chmod_error = "Falsche Dateirechte";
 }
else
 {
  $last_log_dateform = "y/m/d h:i A";
  $last_cache_update_dateform = "y/m/d h:i A";
  // language pack other (en)
  $lang_disabled = "disabled";
  $lang_delete_info = "Delete after update";
  $lang_chmod_error = "Check CHMOD";
 }
//------------------------------------------------------------------------------
// enabled & disabled icons, ok & info icons
$icon_info_enabled    = '<span class="glyphicon glyphicon-ok" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
$icon_info_disabled   = '<span class="glyphicon glyphicon-remove" style="font-size:16px; vertical-align:middle; line-height:16px; margin-top:-4px; color:#c40000; cursor:help" title="'.$lang_disabled.'"></span>';
$icon_chmod_ok        = '<span class="glyphicon glyphicon-ok-circle" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
$icon_chmod_error     = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="'.$lang_chmod_error.'"></span>';
$icon_php_error       = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="PHP version must be >= 5.4"></span>';
$icon_folder          = '<span class="glyphicon glyphicon-folder-close" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#f2cf6d; cursor:default"></span>';
$icon_folder_th       = '<span class="glyphicon glyphicon-folder-close" style=""></span>';
//------------------------------------------------------------------------------
// functions
function check_file_version ( $file )
 {
  $check_file = file ( $file );
  $version    = trim ( substr ( $check_file [ 6 ] , 22 , 9 ) );
  return $version;
 }
//-----------------------------
function check_file_release ( $file )
 {
  $check_file = file ( $file );
  $release    = trim ( substr ( $check_file [ 7 ] , 22 , 8 ) );
  return $release;
 }
//-----------------------------
function file_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 2 : 3;
  return substr( decoct( $perms), $cut );
 }
//-----------------------------
function folder_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 1 : 2;
  return substr ( decoct ( $perms ), $cut );
 }
//-----------------------------
function file_size ( $file )
 {
  if ( !file_exists ( $file ) ) return false;
  return number_format ( ( filesize ( $file ) / 1024 ) , 2 , "," , "." );
 }
//-----------------------------
function file_row_size_small ( $file )
 {
  if ( !file_exists ( $file ) ) return false;
  return count ( file ( $file ) );
 }
//-----------------------------
function file_row_size_big ( $file )
 {
  $counter = trim( `wc --lines < $file` ); // only Unix/Linux server
  if ( $counter != "" ) { return number_format( $counter , 0 , "," , "." ); }
  $counter = 0;
  $logfile = fopen ( $file , "r" );
  if ( $logfile == FALSE ) { return number_format( $counter , 0 , "," , "." ); }
  while ( !FEOF ( $logfile ) )
   {
    $logfile_entry = fgets ( $logfile , 60000 );
    $counter++;
   }
  fclose ( $logfile       );
  unset  ( $logfile       );
  unset  ( $logfile_entry );

  return number_format ( $counter , 0 , "," , "." );
 }
//-----------------------------
function read_files ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
   if ($handle)
    {
     while ( false !== ( $file = readdir ( $handle ) ) )
      {
       if ( $file != "." && $file != ".." )
        {
         if ( !is_dir ( $path."/".$file ) && ( substr ( $file , 0 , 1) != "." ) )
          {
           $result[] = $file;
          }
        }
      }
   }
   closedir ( $handle );
   return $result;
 }
//------------------------------------------------------------------------------
function read_dir ( $path )
 {
  $result = array();
  $handle = opendir ( $path );
  if ( $handle )
   {
    while ( false !== ( $file = readdir ( $handle ) ) )
     {
      if ( $file != "." && $file != ".." )
       {
        if ( is_dir ( $path."/".$file ) )
         {
          $result[] = $file;
         }
        else
         {
          $name = $path."/".$file;
          $result[] = $name;
         }
       }
     }
   }
  closedir ( $handle );
  return $result;
 }
//------------------------------------------------------------------------------
function read_installed_plugins ( )
 {
  include ( 'config/config.php' ); // include config
  //-------------------------------------------------
  if ( $language == "language/german.php" )
   {
    $lang_chmod_error = "Fehlende Dateirechte";
   }
  else
   {
    $lang_chmod_error = "Check CHMOD";
   }
  $icon_chmod_ok    = '<span class="glyphicon glyphicon-ok-circle" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
  $icon_chmod_error = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="'.$lang_chmod_error.'"></span>';
  //-------------------------------------------------
  if ( is_dir ( "plugins/" ) )
   {
    $plugin_files_read = read_dir ( 'plugins/' );
    asort ( $plugin_files_read );
    //-------------------------------------------------
    if ( !$plugin_files_read )
     {
      echo 'No plugins installed';
     }
    else
     {
      echo '<table class="table" style="margin:3px 0">';
      echo '<tr><th>Plugin</th><th>CHMOD</th></tr>';
      foreach ( $plugin_files_read as $value )
       {
        if ( file_exists ( 'plugins/'.$value.'/info.php' ) )
         {
          include ( 'plugins/'.$value.'/info.php' );

          if ( ( $db_active == 0 ) || ( $db_active == 1 ) && ( $plugin_database == 1 ) )
           {
            if (
               ( $value != 'geoip'           ) &&
               ( $value != 'hitcharts'       ) &&
               ( $value != 'lasthits'        ) &&
               ( $value != 'mail'            ) &&
               ( $value != 'onclick'         ) &&
               ( $value != 'piecharts'       ) &&
               ( $value != 'visitsmonthyear' )
               )
             { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">&nbsp;</td></tr>'; }
            else
             {
                  if ( ( $value == 'geoip'           ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100660 ) ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/last_update.dta' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/last_update.dta' ) ) == 100660 ) ) ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
              elseif (   $value == 'hitcharts'       ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">-</td></tr>'; }
              elseif ( ( $value == 'lasthits'        ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100660 ) ) ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
              elseif ( ( $value == 'mail'            ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100660 ) ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/last_send.dta' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/last_send.dta' ) ) == 100660 ) ) ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
              elseif ( ( $value == 'onclick'         ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/config.php' ) ) == 100660 ) ) && ( ( decoct ( fileperms ( 'plugins/'.$value.'/logdb_track_file.dta' ) ) == 100666 ) || ( decoct ( fileperms ( 'plugins/'.$value.'/logdb_track_file.dta' ) ) == 100660 ) ) ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
              elseif (   $value == 'piecharts'       ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">-</td></tr>'; }
              elseif (   $value == 'visitsmonthyear' ) { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">-</td></tr>'; }
                else { echo '<tr><td class="sys-result">'.$plugin_name.', v'.$plugin_version.'</td><td class="sys-result text-center">'.$icon_chmod_error.'</td></tr>'; }
             }
           }

          unset ( $plugin_version   );
          unset ( $plugin_release   );
          unset ( $plugin_author    );
          unset ( $plugin_website   );
          unset ( $plugin_database  );
          unset ( $plugin_directory );
          unset ( $plugin_name      );
         }
       }
      echo '</table>';
     }
   }
  else
   {
    echo 'No plugins installed';
   }
 }
//------------------------------------------------------------------------------
function read_installed_themes ( )
 {
  include ( 'config/config.php' ); // include config
  //-------------------------------------------------
  if ( $language == "language/german.php" )
   {
    // language pack de
    $lang_chmod_error = "Falsche Dateirechte";
   }
  else
   {
    // language pack en
    $lang_chmod_error = "Check CHMOD";
   }
  //-------------------------------------------------
  // chmod & folder icons
  $icon_chmod_ok      = '<span class="glyphicon glyphicon-ok-circle" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
  $icon_chmod_error   = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="'.$lang_chmod_error.'"></span>';
  $icon_folder_th     = '<span class="glyphicon glyphicon-folder-close" style=""></span>';
  //-------------------------------------------------
  $theme_files_read = read_dir ( 'themes/' );
  asort ( $theme_files_read );
  //-------------------------------------------------
  foreach ( $theme_files_read as $value )
   {
    echo '<tr><th colspan="5" class="text-left">'.$icon_folder_th.' themes/'.$value.'</th></tr>';
    if ( file_exists ( 'themes/'.$value.'/counter.css' ) )
     {
      if ( ( decoct ( fileperms ( "themes/".$value."/counter.css" ) ) == 100666 ) || ( decoct ( fileperms ( "themes/".$value."/counter.css" ) ) == 100660 ) )
       { echo '<tr><td class="sys-info">counter.css</td><td class="sys-result text-right">'.file_size("themes/".$value."/counter.css").' KB</td><td class="sys-result text-right">'.file_row_size_small("themes/".$value."/counter.css").'</td><td class="sys-result text-center">'.file_perms("themes/".$value."/counter.css").'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
      else
       { echo '<tr><td class="sys-info">counter.css</td><td class="sys-result text-right">'.file_size("themes/".$value."/counter.css").' KB</td><td class="sys-result text-right">'.file_row_size_small("themes/".$value."/counter.css").'</td><td class="sys-result text-center">'.file_perms("themes/".$value."/counter.css").'</td><td class="sys-result text-center">'.$icon_chmod_error.'</td></tr>'; }
     }
    if ( file_exists ( 'themes/'.$value.'/style.css' ) )
     {
      if ( ( decoct ( fileperms ( "themes/".$value."/style.css" ) ) == 100666 ) || ( decoct ( fileperms ( "themes/".$value."/style.css" ) ) == 100660 ) )
       { echo '<tr><td class="sys-info">style.css</td><td class="sys-result text-right">'.file_size("themes/".$value."/style.css").' KB</td><td class="sys-result text-right">'.file_row_size_small("themes/".$value."/style.css").'</td><td class="sys-result text-center">'.file_perms("themes/".$value."/style.css").'</td><td class="sys-result text-center">'.$icon_chmod_ok.'</td></tr>'; }
      else
       { echo '<tr><td class="sys-info">style.css</td><td class="sys-result text-right">'.file_size("themes/".$value."/style.css").' KB</td><td class="sys-result text-right">'.file_row_size_small("themes/".$value."/style.css").'</td><td class="sys-result text-center">'.file_perms("themes/".$value."/style.css").'</td><td class="sys-result text-center">'.$icon_chmod_error.'</td></tr>'; }
     }
   }
 }
//------------------------------------------------------------------------------
// check script_domain
if ( ( ( $script_domain == "http://localhost" ) && ( $_SERVER [ 'HTTP_HOST' ] == 'localhost' ) ) || ( ( substr ( $script_domain , 0 , 11 ) == "http://www." ) && ( substr ( $script_domain , 11 ) == $_SERVER [ 'HTTP_HOST' ] ) ) || ( ( substr ( $script_domain , 0 , 7 ) == "http://" ) && ( substr ( $script_domain , 7 ) == $_SERVER [ 'HTTP_HOST' ] ) ) || ( ( substr ( $script_domain , 0 , 12 ) == "https://www." ) && ( substr ( $script_domain , 12 ) == $_SERVER [ 'HTTP_HOST' ] ) ) || ( ( substr ( $script_domain , 0 , 8 ) == "https://" ) && ( substr ( $script_domain , 8 ) == $_SERVER [ 'HTTP_HOST' ] ) ) )
 {
  $script_domain_linktext = $script_domain;
 }
else
 {
  $script_domain_linktext = "<font color=\"red\">".$script_domain."</font>";
 }
//------------------------------------------------------------------------------
// check script_path
if ( $script_path == substr ( dirname ( $_SERVER [ 'PHP_SELF' ] ) , 1 )."/" )
 { }
else
 {
  $script_path = "<font color=\"red\">".$script_path."</font>";
 }
//------------------------------------------------------------------------------
// check exception_domain
$temp_exception_domain = "";
foreach ( $exception_domain as $value )
 {
  if ( ( $value != "localhost" ) && ( !@fsockopen ( $value , "80" , $errno , $errstr , 5 ) ) )
   {
    $temp_exception_domain = $temp_exception_domain.'<font color="red">'.$value.'</font><br />';
   }
  else
   {
    $temp_exception_domain = $temp_exception_domain.$value.'<br />';
   }
 }
unset ( $exception_domain );
$exception_domain = $temp_exception_domain;
unset ( $temp_exception_domain );
//------------------------------------------------------------------------------
// check url parameter
$temp_url_parameter = "";
foreach ( $url_parameter as $value )
 {
  $temp_url_parameter = $temp_url_parameter."<br />".$value;
 }
$temp_url_parameter = substr ( $temp_url_parameter , 6 , strlen ( $temp_url_parameter ) - 1 );
unset ( $url_parameter );
$url_parameter = $temp_url_parameter;
unset ( $temp_url_parameter );
//------------------------------------------------------------------------------
// check last cache update
$read_cache_update_timestamp = file ( 'log/timestamp_cache_update.dta' );
$last_cache_update_timestamp = $read_cache_update_timestamp[0];
//------------------------------------------------------------------------------
// check last log entry
if ( $db_active == 1 )
 {
  $query              = "SELECT MAX(timestamp) FROM ".$db_prefix."_main";
  $result             = db_query ( $query , 1 , 0 );
  $last_log_timestamp = $result[0][0];
 }
else
 {
  include ( "log/index_days.php" );
  $max_memory_address = max ( $index_days );

  $logfile = fopen ( "log/logdb_backup.dta" , "r" );
    @fseek ( $logfile , $max_memory_address );
    while ( !FEOF ( $logfile ) )
     {
      $logfile_entry = fgetcsv ( $logfile , 60000 , "|" );
      if ( trim ( $logfile_entry [ 0 ] ) != "" ) { $last_log_timestamp = $logfile_entry [ 0 ]; }
     }
  fclose ( $logfile );

  unset ( $logfile       );
  unset ( $logfile_entry );
 }
//------------------------------------------------------------------------------
function checker ( $files_path , $actual_version )
 {
  //-----------------------------
  include ( 'config/config.php' ); // include config
  //-----------------------------
  if ( $language == "language/german.php" )
   {
    // language pack de
    $lang_filecheck_error = "Prüfen Sie den Übertragungs-Modus beim hochladen der Dateien oder\ndie Datei stimmt nicht mit der Originalversion überein";
    $lang_filecheck_info = "Keine original PHP Web Stat Datei";
   }
  else
   {
    // language pack en
    $lang_filecheck_error = "Wrong FTP mode used for uploading the stat file or\nthis file is not equal to the file of the original stat download version";
    $lang_filecheck_info = "No original PHP Web Stat file";
   }
  //-----------------------------
  $stat_version = file ( "index.php" ); // include stat version
  eval($stat_version[32]);
  eval($stat_version[33]);
  $actual_version = $version_number.$revision_number;
  //-----------------------------
  $md5_file = fopen ( "func/checkversion_md5.dta" , "r" );
  $md5_file_entry = fgetcsv ( $md5_file , 60000 , "|" ); // read entry from checkversion_md5
  $checkversion_md5 = $md5_file_entry [ 2 ];
  fclose ( $md5_file );
  unset  ( $md5_file );
  //-----------------------------
  $icon_filecheck_ok    = '<span class="glyphicon glyphicon-ok-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
  $icon_filecheck_error = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="'.$lang_filecheck_error.'"></span>';
  //-----------------------------
  $blacklist_files = array (
                            // folder config
                            "cache_panel.php","config.php","config_db.php","delete_archive.php","delete_backup.php","delete_index.php","db_transfer.php","edit_css.php","edit_db.php","edit_site_name.php","edit_string_replace.php","file_version.php","pattern_site_name.inc","pattern_string_replace.inc","repair.php","tracking_code.php",
                            // folder func
                            "checkversion_md5.dta","func_archive_save.php","func_cache_control.php","func_checkversion.php","func_create_index.php","func_crypt.php","func_db_connect.php","func_display_trends.php","func_error.php","func_geoip.php","func_kill_special_chars.php","func_last_logins.php","func_last_logins_show.php","func_pattern_icons.php","func_plugin_loading.php","func_read_dir.php","func_refresh.php","func_timer.php","func_timestamp_control.php","html_footer.php",
                            // main folder
                            "checkversion.php","detail_view.php","update.php","update_info.txt"
                           );
  //-----------------------------
  $files_done = array ();
  $files_read = read_files ( $files_path );
  asort ( $files_read );
  //-----------------------------
  foreach ( $files_read as $value )
   {
    if ( !in_array ( $value, $blacklist_files ) )
     {
      $md5_file_content = md5_file ( $files_path.$value );
      $version_file  = fopen ( "func/checkversion.dta" , "r" );
      while ( !FEOF ( $version_file ) )
       {
        $version_file_entry  = fgetcsv ( $version_file , 60000 , "|" );  // read entry from checkversion
        if ( $version_file_entry [ 1 ] == $value )
         {
          $files_done[] = $value;
          echo '
          <tr>
          ';
          echo '  <td class="sys-info">'.$files_path.$value.'</td>';
          if ( $value == "checkversion.dta" )
           {
            if ( $actual_version != $version_file_entry [ 3 ] )
             {
              echo '<td class="sys-result"><span style="color:#c40000; font-weight:bold; cursor:help" title="current '.$actual_version.'">'.$version_file_entry [ 3 ].'</span></td>';
              echo '<td class="sys-result">'.$version_file_entry [ 4 ].'</td>';
             }
            else
             {
              echo '<td class="sys-result">'.$version_file_entry [ 3 ].'</td>';
              echo '<td class="sys-result">'.$version_file_entry [ 4 ].'</td>';
             }
           }
          else
           {
            if ( check_file_version ( $files_path.$value ) != $version_file_entry [ 3 ] )
             {
              echo '<td class="sys-result"><span style="color:#c40000; font-weight:bold; cursor:help" title="current '.$version_file_entry [ 3 ].'">'.check_file_version ( $files_path.$value ).'</span></td>';
              echo '<td class="sys-result">'.check_file_release ( $files_path.$value ).'</td>';
             }
            else
             {
              echo '<td class="sys-result">'.check_file_version ( $files_path.$value ).'</td>';
              echo '<td class="sys-result">'.check_file_release ( $files_path.$value ).'</td>';
             }
           }
          if ( $value == "checkversion.dta" )
           {
            $md5_file_content = md5_file ( "func/checkversion.dta" );
            if ( $checkversion_md5 != $md5_file_content )
             {
              echo '<td class="sys-result text-center">'.$icon_filecheck_error.'</td>';
             }
            else
             {
              echo '<td class="sys-result text-center">'.$icon_filecheck_ok.'</td>';
             }
           }
          else
           {
            if ( trim ( $version_file_entry [ 2 ] ) != $md5_file_content )
             {
              echo '<td class="sys-result text-center">'.$icon_filecheck_error.'</td>';
             }
            else
             {
              echo '<td class="sys-result text-center">'.$icon_filecheck_ok.'</td>';
             }
           }
          echo '
          </tr>';
         }
       }
      fclose ( $version_file );
      unset  ( $version_file );
     }
   }
  foreach ( $files_read as $value )
   {
    if ( ( !in_array ( $value, $blacklist_files ) ) && ( !in_array ( $value, $files_done ) ) )
     {
      echo '<tr><td class="sys-info">'.$files_path.$value.'</td><td class="sys-result">&nbsp;</td><td class="sys-result">&nbsp;</td><td class="sys-result text-center"><span class="glyphicon glyphicon-warning-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:orange; cursor:help" title="'.$lang_filecheck_info.'"></span></td></tr>';
     }
   }
 }
//------------------------------------------------------------------------------
// actual stat version
$actual_version = $version_number.$revision_number;
//------------------------------------------------------------------------------
include ( 'func/html_header.php' ); // include html header
//------------------------------------------------------------------------------
// page content
echo '<div id="ground" style="width:960px">
<div id="content">

<div id="header" style="margin-bottom:15px; border: 1px solid #606060; -webkit-box-shadow:none; -moz-box-shadow:none; -o-box-shadow:none; box-shadow:none">
  <div class="container-fluid" style="margin-left:0; margin-right:0">
    <div class="brand">
      <a href="http://www.php-web-statistik.de" target="_blank" style="float:left; margin-right:20px"><img src="images/system.png" alt="PHP Web Stat" title="PHP Web Stat"></a>
      <div class="brand-inline">
        <div class="brand-name">PHP Web Stat</div>
        <div class="script-ver">SysInfo v'.$sysinfo_vers.'</div>
      </div>
    </div>
    <div class="align-right" style="margin-top:27px; font-size:14px; line-height:16px">
      <a href="index.php?action=backtostat"><span class="glyphicon glyphicon-stats"></span> Stat</a> &nbsp;
      <a href="config/admin.php"><span class="glyphicon glyphicon-cog"></span> Admin-Center</a> &nbsp;
      <a href="config/file_version.php" class="floatbox.fileversion" data-fb-options="width:680 height:530"><span class="glyphicon glyphicon-floppy-disk"></span> File Version</a> &nbsp;
      <a href="counter.php" class="floatbox.counter" data-fb-options="width:150 height:160 scrolling:no"><span class="glyphicon glyphicon-tasks"></span> Counter</a> &nbsp;
    </div>
    <div class="clearfix"></div>
  </div>
</div>

<div style="width:50%; float:left; padding-right:20px">

  <div class="sys-module">
    <div class="sys-module-header">Script Info</div>
    <div class="sys-module-content">
      <table class="sys-table">
      <tr>
        <td class="sys-info" style="width:160px">Script Version</td>
        <td class="sys-result text-left">'.$version_number.$revision_number.'</td>
      </tr>
      <tr>
        <td class="sys-info" style="width:160px">Script registered</td>
        <td class="sys-result text-left">';
        //-----------------------------
        $temp_script_domain = str_replace ( 'https://' , '' , $script_domain );
        $temp_script_domain = str_replace ( 'http://' , '' , $temp_script_domain );
        $temp_script_domain = str_replace ( 'www.' , '' , $temp_script_domain );
        //-----------------------------
        $license_key = null;
        for ($x=0;$x<42;$x++) {$license_key=strtoupper(md5(sha1($license_key.base64_encode($temp_script_domain))));}
        //-----------------------------
        echo '<img src="https://www.php-web-statistik.de/license/license-check.php?image='.$license_key.'">';
        //-----------------------------
        unset ( $temp_script_domain );
        //-----------------------------
        echo'</td>
      </tr>
      <tr>
        <td class="sys-info">Script Activitiy</td>
        <td class="sys-result text-left">'; if ( $script_activity == 1 ) { echo $icon_info_enabled; } else { echo '<span style="background:#f9fbe0; color:#c40000"><span class="glyphicon glyphicon-info-sign"></span> Maintenance Mode&nbsp;</span>'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">DB Active</td>
        <td class="sys-result text-left">'; if ( $db_active == 1 ) { echo $icon_info_enabled; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Script Domain</td>
        <td class="sys-result text-left"><a href="'.$script_domain.'" target="_blank">'.$script_domain_linktext.'</a></td>
      </tr>
      <tr>
        <td class="sys-info">Script Path</td>
        <td class="sys-result text-left">'.$script_path.'</td>
      </tr>
      <tr>
        <td class="sys-info">Starting Page</td>
        <td class="sys-result text-left">'.$home_site_name.'</td>
      </tr>
      <tr>
        <td class="sys-info" style="vertical-align:top">Domain(s)</td>
        <td class="sys-result text-left">'.$exception_domain.'</td>
      </tr>
      <tr>
        <td class="sys-info" style="vertical-align:top">URL Parameter</td>
        <td class="sys-result text-left">'.$url_parameter.'</td>
      </tr>
      <tr>
        <td class="sys-info">Frames</td>
        <td class="sys-result text-left">'; if ( $frames == 1 ) { echo $icon_info_enabled; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">IP Recount Time</td>
        <td class="sys-result text-left">'.$ip_recount_time.' min.</td>
      </tr>
      <tr>
        <td class="sys-info">Update Check</td>
        <td class="sys-result text-left">'; if ( $auto_update_check == 1 ) { echo $icon_info_enabled; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Error Reporting</td>
        <td class="sys-result text-left">'; if ( $error_reporting == 1 ) { echo $icon_info_enabled; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Logfile security</td>
        <td class="sys-result text-left">'; if ( $set_htaccess == 1 ) { echo $icon_info_enabled; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Creator Number</td>
        <td class="sys-result text-left">'.number_format ( $creator_number , 0 , "," , "." ).'</td>
      </tr>
      <tr>
        <td class="sys-info">Referer Cut</td>
        <td class="sys-result text-left">'.$creator_referer_cut.'</td>
      </tr>
      <tr>
        <td class="sys-info">Index Number</td>
        <td class="sys-result text-left">'.number_format ( $index_creator_number , 0 , "," , "." ).'</td>
      </tr>
      <tr>
        <td class="sys-info">Cache Update</td>
        <td class="sys-result text-left">'; if ( $cache_update != 0 ) { echo $cache_update." min."; } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Last Cache Update</td>
        <td class="sys-result text-left">'; if ( $cache_update != 0 ) { echo date ( $last_cache_update_dateform , strftime ( $last_cache_update_timestamp ) ); } else { echo 'OFF'; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Country detection</td>
        <td class="sys-result text-left">'; if ( file_exists ( "func/geoip/LocationIPversion.dat" ) ) { echo trim ( $geoip_version [0] ); } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Last log entry</td>
        <td class="sys-result text-left">'.date( $last_log_dateform , $last_log_timestamp ).'</td>
      </tr>
      <tr>
        <td class="sys-info" style="vertical-align:top">Installed Plugins</td>
        <td class="sys-result text-left">'; echo read_installed_plugins(); echo '</td>
      </tr>
      </table>
    </div>
  </div> <!-- /.sys-module -->

  <div class="sys-module" style="margin-top:17px">
    <div class="sys-module-header">Server Info</div>
    <div class="sys-module-content">
      <table class="sys-table">
      <tr>
        <td class="sys-info" style="width:160px">Server Host</td>
        <td class="sys-result text-left">'.gethostbyaddr ( gethostbyname ( $_SERVER[ 'SERVER_NAME' ] ) ).'</td>
      </tr>
      <tr>
        <td class="sys-info">Server OS</td>
        <td class="sys-result text-left">'.$_SERVER[ 'SERVER_SOFTWARE' ].'</td>
      </tr>
      <tr>
        <td class="sys-info">PHP Version</td>
        <td class="sys-result text-left">'; if ( phpversion() < 5.4 ) { echo '<span style="color:#cc0000">'.phpversion().'</span> &nbsp; '.$icon_php_error.''; } else { echo phpversion(); } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Max Execution Time</td>
        <td class="sys-result text-left">'.ini_get ( "max_execution_time" ).' sec.</td>
      </tr>
      <tr>
        <td class="sys-info">Memory Limit</td>
        <td class="sys-result text-left">'.ini_get ( "memory_limit" ).'B</td>
      </tr>
      <tr>
        <td class="sys-info">Session Support</td>
        <td class="sys-result text-left">'; if ( isset ( $_SESSION ) ) { echo $icon_info_enabled; } else { echo $icon_info_disabled; } echo '</td>
      </tr>
      <tr>
        <td class="sys-info">Cookie Support</td>
        <td class="sys-result text-left">'; if ( isset ( $_SERVER [ 'HTTP_COOKIE' ] ) ) { echo $icon_info_enabled; } else { echo $icon_info_disabled; } echo '</td>
      </tr>
      </table>
    </div>
  </div> <!-- /.sys-module -->

</div> <!-- /left col -->
<div style="width:50%; float:left">

  <div class="sys-module">
    <div class="sys-module-header">File Check</div>
    <div class="sys-module-content">
      <table class="sys-table">
      <tr>
        <th class="text-left">File</th>
        <th class="text-left" style="width:80px">Version</th>
        <th class="text-left" style="width:70px">Release</th>
        <th class="text-center" style="width:70px">MD5</th>
      </tr>';
      checker ( "config/"   , $actual_version );
      checker ( "func/"     , $actual_version );
      checker ( "./"        , $actual_version );
      if ( file_exists ( "update.php" ) )
       {
        echo '
        <tr>
          <td class="sys-info">./update.php</td><td class="sys-result">&nbsp;</td><td class="sys-result">&nbsp;</td><td class="sys-result text-center"><span class="glyphicon glyphicon-warning-sign" style="font-size:15px; vertical-align:middle; margin-top:-3px; color:orange; cursor:help" title="'.$lang_delete_info.'"></span></td>
        </tr>';
       }
      echo '
      </table>
    </div>
  </div> <!-- /.sys-module -->

</div> <!-- /right col -->
<div class="clearfix"></div>

<hr>

<div class="sys-module">
  <div class="sys-module-header">Folder &amp; File CHMOD Status</div>
  <div class="sys-module-content">
    <table class="sys-table">
    <tr>
      <th class="text-left">Folder</th>
      <th class="text-right" style="width:120px">Size</th>
      <th class="text-right" style="width:100px">Rows</th>
      <th class="text-center" style="width:100px">CHMOD</th>
      <th class="text-center" style="width:90px">Status</th>
    </tr>
    <tr>
      <td class="sys-info">'.$icon_folder.' backup/</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-center">'.folder_perms("backup/").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "backup/" ) ) == 40777 ) || ( decoct ( fileperms ( "backup/" ) ) == 40775 ) || ( decoct ( fileperms ( "backup/" ) ) == 40770 ) ) { echo $icon_chmod_ok; } else { echo $icon_chmod_error; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'.$icon_folder.' func/geoip/</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-center">'.folder_perms("func/geoip/").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "func/geoip/" ) ) == 40777 ) || ( decoct ( fileperms ( "func/geoip/" ) ) == 40775 ) || ( decoct ( fileperms ( "func/geoip/" ) ) == 40770 ) ) { echo $icon_chmod_ok; } else { echo $icon_chmod_error; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'.$icon_folder.' log/</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-center">'.folder_perms("log/").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/" ) ) == 40777 ) || ( decoct ( fileperms ( "log/" ) ) == 40775 ) || ( decoct ( fileperms ( "log/" ) ) == 40770 ) ) { echo $icon_chmod_ok; } else { echo $icon_chmod_error; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info" style="border-bottom:1px solid #666">'.$icon_folder.' log/archive/</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">&nbsp;</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">&nbsp;</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'.folder_perms("log/archive/").'</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'; if ( ( decoct ( fileperms ( "log/archive/" ) ) == 40777 ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40775 ) || ( decoct ( fileperms ( "log/archive/" ) ) == 40770 ) ) { echo $icon_chmod_ok; } else { echo $icon_chmod_error; } echo '</td>
    </tr>
    <tr>
      <th colspan="5" class="text-left">'.$icon_folder_th.' config (files)</th>
    </tr>
    <tr>
      <td class="sys-info">config.php</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-center">'.file_perms("config/config.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "config/config.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/config.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">config_db.php</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-right">&nbsp;</td>
      <td class="sys-result text-center">'.file_perms("config/config_db.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "config/config_db.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/config_db.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_site_name.inc'; } else { echo '<a class="referer" style="text-decoration:underline" href="config/pattern_site_name.inc" target="_blank">pattern_site_name.inc</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("config/pattern_site_name.inc").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("config/pattern_site_name.inc").'</td>
      <td class="sys-result text-center">'.file_perms("config/pattern_site_name.inc").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "config/pattern_site_name.inc" ) ) != 100666 ) && ( decoct ( fileperms ( "config/pattern_site_name.inc" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_string_replace.inc'; } else { echo '<a class="referer" style="text-decoration:underline" href="config/pattern_string_replace.inc" target="_blank">pattern_string_replace.inc</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("config/pattern_string_replace.inc").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("config/pattern_string_replace.inc").'</td>
      <td class="sys-result text-center">'.file_perms("config/pattern_string_replace.inc").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) != 100666 ) && ( decoct ( fileperms ( "config/pattern_string_replace.inc" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info" style="border-bottom:1px solid #666">tracking_code.php</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">'.file_size("config/tracking_code.php").' KB</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">'.file_row_size_small("config/tracking_code.php").'</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'.file_perms("config/tracking_code.php").'</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'; if ( ( decoct ( fileperms ( "config/tracking_code.php" ) ) != 100666 ) && ( decoct ( fileperms ( "config/tracking_code.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <th colspan="5" class="text-left">'.$icon_folder_th.' css (files)</th>
    </tr>
    <tr>
      <td class="sys-info">print.css</td>
      <td class="sys-result text-right">'.file_size("css/print.css").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("css/print.css").'</td>
      <td class="sys-result text-center">'.file_perms("css/print.css").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "css/print.css" ) ) != 100666 ) && ( decoct ( fileperms ( "css/print.css" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info" style="border-bottom:1px solid #666">style.css</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">'.file_size("css/style.css").' KB</td>
      <td class="sys-result text-right" style="border-bottom:1px solid #666">'.file_row_size_small("css/style.css").'</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'.file_perms("css/style.css").'</td>
      <td class="sys-result text-center" style="border-bottom:1px solid #666">'; if ( ( decoct ( fileperms ( "css/style.css" ) ) != 100666 ) && ( decoct ( fileperms ( "css/style.css" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <th colspan="5" class="text-left">'.$icon_folder_th.' func/geoip (files)</th>
    </tr>
    <tr>
      <td class="sys-info">LocationIP.bin</td>
      <td class="sys-result text-right">'.file_size("func/geoip/LocationIP.bin").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("func/geoip/LocationIP.bin").'</td>
      <td class="sys-result text-center">'.file_perms("func/geoip/LocationIP.bin").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "func/geoip/LocationIP.bin" ) ) != 100666 ) && ( decoct ( fileperms ( "func/geoip/LocationIP.bin" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">LocationIPv6.bin</td>
      <td class="sys-result text-right">'.file_size("func/geoip/LocationIPv6.bin").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("func/geoip/LocationIPv6.bin").'</td>
      <td class="sys-result text-center">'.file_perms("func/geoip/LocationIPv6.bin").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "func/geoip/LocationIPv6.bin" ) ) != 100666 ) && ( decoct ( fileperms ( "func/geoip/LocationIPv6.bin" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">LocationIPversion.bin</td>
      <td class="sys-result text-right">'.file_size("func/geoip/LocationIPversion.dat").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("func/geoip/LocationIPversion.dat").'</td>
      <td class="sys-result text-center">'.file_perms("func/geoip/LocationIPversion.dat").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "func/geoip/LocationIPversion.dat" ) ) != 100666 ) && ( decoct ( fileperms ( "func/geoip/LocationIPversion.dat" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <th colspan="5" class="text-left">'.$icon_folder_th.' log (files)</th>
    </tr>
    <tr>
      <td class="sys-info">cache_memory_address.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_memory_address.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/cache_memory_address.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_memory_address.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_memory_address.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_memory_address.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">cache_time_stamp.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_time_stamp.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/cache_time_stamp.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_time_stamp.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_time_stamp.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_time_stamp.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">cache_time_stamp_archive.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_time_stamp_archive.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/cache_time_stamp_archive.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_time_stamp_archive.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_time_stamp_archive.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_time_stamp_archive.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">cache_visitors.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_visitors.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/cache_visitors.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_visitors.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_visitors.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_visitors.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">cache_visitors_archive.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_visitors_archive.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/cache_visitors_archive.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_visitors_archive.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_visitors_archive.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_visitors_archive.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">cache_visitors_counter.php</td>
      <td class="sys-result text-right">'.file_size("log/cache_visitors_counter.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/cache_visitors_counter.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/cache_visitors_counter.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/cache_visitors_counter.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/cache_visitors_counter.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">index_days.php</td>
      <td class="sys-result text-right">'.file_size("log/index_days.php").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/index_days.php").'</td>
      <td class="sys-result text-center">'.file_perms("log/index_days.php").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/index_days.php" ) ) != 100666 ) && ( decoct ( fileperms ( "log/index_days.php" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">last_logins.dta</td>
      <td class="sys-result text-right">'.file_size("log/last_logins.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/last_logins.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/last_logins.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/last_logins.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/last_logins.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">last_timestamp.dta</td>
      <td class="sys-result text-right">'.file_size("log/last_timestamp.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/last_timestamp.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/last_timestamp.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/last_timestamp.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/last_timestamp.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'logdb.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/logdb.dta" target="_blank">logdb.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/logdb.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/logdb.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/logdb.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/logdb.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'logdb_backup.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/logdb_backup.dta" target="_blank">logdb_backup.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/logdb_backup.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/logdb_backup.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/logdb_backup.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/logdb_backup.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb_backup.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'logdb_temp.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/logdb_temp.dta" target="_blank">logdb_temp.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/logdb_temp.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/logdb_temp.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/logdb_temp.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/logdb_temp.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/logdb_temp.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_browser.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/pattern_browser.dta" target="_blank">pattern_browser.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/pattern_browser.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/pattern_browser.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/pattern_browser.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/pattern_browser.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_browser.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_operating_system.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/pattern_operating_system.dta" target="_blank">pattern_operating_system.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/pattern_operating_system.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/pattern_operating_system.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/pattern_operating_system.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/pattern_operating_system.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_operating_system.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_referer.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/pattern_referer.dta" target="_blank">pattern_referer.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/pattern_referer.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/pattern_referer.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/pattern_referer.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/pattern_referer.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_referer.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_resolution.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/pattern_resolution.dta" target="_blank">pattern_resolution.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/pattern_resolution.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_small("log/pattern_resolution.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/pattern_resolution.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/pattern_resolution.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_resolution.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">'; if ( $set_htaccess == 1 ) { echo 'pattern_site_name.dta'; } else { echo '<a class="referer" style="text-decoration:underline" href="log/pattern_site_name.dta" target="_blank">pattern_site_name.dta</a>'; } echo '</td>
      <td class="sys-result text-right">'.file_size("log/pattern_site_name.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/pattern_site_name.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/pattern_site_name.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/pattern_site_name.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/pattern_site_name.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>
    <tr>
      <td class="sys-info">timestamp_cache_update.dta</td>
      <td class="sys-result text-right">'.file_size("log/timestamp_cache_update.dta").' KB</td>
      <td class="sys-result text-right">'.file_row_size_big("log/timestamp_cache_update.dta").'</td>
      <td class="sys-result text-center">'.file_perms("log/timestamp_cache_update.dta").'</td>
      <td class="sys-result text-center">'; if ( ( decoct ( fileperms ( "log/timestamp_cache_update.dta" ) ) != 100666 ) && ( decoct ( fileperms ( "log/timestamp_cache_update.dta" ) ) != 100660 ) ) { echo $icon_chmod_error; } else { echo $icon_chmod_ok; } echo '</td>
    </tr>';
    echo read_installed_themes();
    echo '</table>';
  echo '
  </div>
</div> <!-- /.sys-module -->

<hr>

<div class="text-center">
  Copyright &copy; '.$last_edit.' <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a>
</div>
</div> <!-- /#content -->
</div> <!-- /#ground -->';
//------------------------------------------------------------------------------
include ( 'func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>