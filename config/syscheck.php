<?php @session_start(); if ( $_SESSION [ 'hidden_func' ] != md5_file ( 'config.php' ) ) { $error_path = '../'; include ( '../func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.3                                                      #
# File-Release-Date:  21/01/03                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2021 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config.php' ); // include path to config
include ( '../'.substr ( $language , 0 , strpos ( $language , "." ) )."_admin.php" ); // include language vars
//------------------------------------------------------------------------------
if ( $error_reporting == 0 ) { error_reporting(0); }
//------------------------------------------------------------------------------
if ( $language == "language/german.php"     ) { $lang = "de"; }
if ( $language == "language/english.php"    ) { $lang = "en"; }
if ( $language == "language/dutch.php"      ) { $lang = "nl"; }
if ( $language == "language/italian.php"    ) { $lang = "it"; }
if ( $language == "language/spanish.php"    ) { $lang = "es"; }
if ( $language == "language/danish.php"     ) { $lang = "dk"; }
if ( $language == "language/french.php"     ) { $lang = "fr"; }
if ( $language == "language/turkish.php"    ) { $lang = "tr"; }
if ( $language == "language/portuguese.php" ) { $lang = "pt"; }
if ( $language == "language/finnish.php"    ) { $lang = "fi"; }
//------------------------------------------------------------------------------
// chmod & folder icons
$icon_chmod_ok      = '<span class="glyphicon glyphicon-ok-circle" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
$icon_chmod_error   = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="Check CHMOD"></span>';
$icon_folder        = '<span class="glyphicon glyphicon-folder-close" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#f2cf6d; cursor:default"></span>';
$icon_folder_th     = '<span class="glyphicon glyphicon-folder-close" style=""></span>';
//------------------------------------------------------------------------------
// Function file perms
function file_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 2 : 3;
  return substr( decoct( $perms), $cut );
 }
//------------------------------------------------------------------------------
// Function folder perms
function folder_perms ( $file, $octal = false )
 {
  if ( !file_exists ( $file ) ) return false;
  $perms = fileperms ( $file );
  $cut = $octal ? 1 : 2;
  return substr ( decoct ( $perms ), $cut );
 }
//------------------------------------------------------------------------------
// Function for displaying errors
function display_error ( $x )
 {
  global $error_counter;
  $error_counter++;
  echo "<font color='#CC0000'>&nbsp; - $x.</font><br>\n";
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
function read_installed_themes ( )
 {
  include ( 'config.php' ); // include path to logfile
  //-------------------------------------------------
  // chmod & folder icons
  $icon_chmod_ok      = '<span class="glyphicon glyphicon-ok-circle" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span>';
  $icon_chmod_error   = '<span class="glyphicon glyphicon-info-sign" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:help" title="Check CHMOD"></span>';
  $icon_folder_th     = '<span class="glyphicon glyphicon-folder-close" style=""></span>';
  //-------------------------------------------------
  $theme_files_read = read_dir ( '../themes/' );
  asort ( $theme_files_read );
  //-------------------------------------------------
  foreach ( $theme_files_read as $value )
   {
    echo '<tr><th colspan="4">'.$icon_folder_th.' themes/'.$value.'</th></tr>';
    if ( file_exists ( '../themes/'.$value.'/counter.css' ) )
     {
      if ( ( decoct ( fileperms ( "../themes/".$value."/counter.css" ) ) == 100666 ) || ( decoct ( fileperms ( "../themes/".$value."/counter.css" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">counter.css</td><td class="td3">'.file_perms ( "../themes/".$value."/counter.css" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">counter.css</td><td class="td3">'.file_perms ( "../themes/".$value."/counter.css" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
     }
    if ( file_exists ( '../themes/'.$value.'/style.css' ) )
     {
      if ( ( decoct ( fileperms ( "../themes/".$value."/style.css" ) ) == 100666 ) || ( decoct ( fileperms ( "../themes/".$value."/style.css" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">style.css</td><td class="td3">'.file_perms ( "../themes/".$value."/style.css" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">style.css</td><td class="td3">'.file_perms ( "../themes/".$value."/style.css" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
     }
   }
 }
//------------------------------------------------------------------------------
// Function for linkcheck
function checklink ( $loc )
 {
  global $lang_admin_sc;
  $x = head ( $loc );
  if ( ( $x != 200 ) && ( $x != 400 ) )
   {
    display_error ( $lang_admin_sc[37]." ($x), $loc ".$lang_admin_sc[38]."" ) ;
   }
 }
//------------------------------------------------------------------------------
// Function for Socket Server Availability
function head ( $location )
 {
  if ( substr ( $location , 0 , 5 ) == 'https' ) { $port = 443; } else { $port = 80; }

  $location = trim ( preg_replace ( '/^https:\/\//i' , '' , $location ) );
  $location = trim ( preg_replace ( '/^http:\/\//i' , '' , $location ) );

  $c = strpos ( $location , "/" );

  if ( !$c ) { $host = $location; $pfad = "/"; } else { $host = substr ( $location , 0 , $c ); $pfad = substr ( $location , $c ); }

  $fp = @fsockopen ( $host, $port, $errno, $errstr, 5 );

  if ( $fp )
   {
    fputs ( $fp , "GET $pfad HTTP/1.1\r\n" );
    fputs ( $fp , "Host: $host\r\n" );
    fputs ( $fp , "User-Agent: PHP/StatusCheck V0.2\r\n" );
    fputs ( $fp , "\r\n" );

    while ( !feof ( $fp ) )
     {
      $c = fgets ( $fp , 133 );
      if ( strlen ( $c ) == 2 ) break;
      if ( preg_match ( "/^HTTP.*? ([0-9]{3})/i" , $c , $match ) ) $status = 0 + $match [ 1 ];
      if ( preg_match ( "/^Location: (.*)$/i" , $c , $match ) ) $newLocation = $match [ 1 ];
     }

    if ( ( $status == 302 || $status == 301 ) && $newLocation ) return ( head ( $newLocation ) ); else return ( $status );

    fclose ( $fp );
   }
  else
   {
    return 0;
   }
 }
//------------------------------------------------------------------------------
// Function for Database Row Output
function f ( $row )
 {
  global $t , $value_n , $last_n;
  if ( !$t )
   {
    $t = true;
    echo "\n".'<table class="table-responsive" style="border:2px solid #337ab7; color:#666"><tr>'."\n";
    foreach ( $row as $key => $value )
     {
      echo '<th style="border:1px solid #337ab7; background-color:#e5edf4; border-bottom:3px solid #337ab7; color:#666; padding:2px 5px">'.str_replace( '_' , ' ', $key ).'</th>'."\n";
     }
    echo '</tr>'."\n";
   }
  if ( ( $value_n ) && ( $value_n != $last_n ) )
   {
    $last_n = $value_n; echo '<tr><td colspan="'.count ( $row ).'" style="border:1px solid #337ab7; padding:2px 5px"><b>'.$value_n.'</b></td></tr>'."\n";
   }
  echo '<tr>'."\n";
  foreach ( $row as $key => $value )
   {
    echo '<td style="border:1px solid #337ab7; background-color:#f9f9f9; padding:2px 5px;';
    if ( is_numeric ( $value ) )
     {
      echo ' text-align:right';
     }
    echo '">'.$value.'&nbsp;</td>'."\n";
   }
  echo '</tr>'."\n";
 }
//------------------------------------------------------------------------------
// Function for Database Row Output
function f_exit ( $t )
 {
  if ( $t ){ echo '<b><font color="#CC0000">'.$t.'</font></b><hr>'."\n"; } else { echo '<br>'."\n"; }
  $t = 'GLOBAL VARIABLES';
  echo '<b>'.$t.'</b><br>'."\n";
  $result = mysqli_query ( $t );
  if ( !$result ) { echo mysqli_error().'<br>'."\n"; } else { while ( $row = mysqli_fetch_assoc ( $result ) ) { f1 ( $row ); } }
  echo '<hr>'."\n";
  $t = 'SESSION VARIABLES';
  echo '<b>'.$t.'</b><br>'."\n";
  $result = mysqli_query ( $t );
  if ( !$result ) { echo mysqli_error().'<br>'."\n"; } else { while ( $row = mysqli_fetch_assoc ( $result ) ) { f1 ( $row ); } }
  echo '<hr>'."\n";
  #if ( $t ) { exit; }
 }
//------------------------------------------------------------------------------
function f1( $row ) { echo $row [ 'Variable_name' ].': '.$row [ 'Value' ].'<br>'."\n"; }
//------------------------------------------------------------------------------
include ( '../func/html_header.php' ); // include html header
//------------------------------------------------------------------------------
echo '<div id="syscheck_menu" style="height:65px; background:#DFE4E9">
  <form name="check" action="syscheck.php" method="post">
  <div style="height:30px; padding-top:5px">
    <span style="display:inline-block; width:100px"><b>'.$lang_admin_sc[4].':</b></span>
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[5].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[6].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[7].'">
  </div>
  <div style="height:30px; padding-top:5px">
    <span style="display:inline-block; width:100px"><b>'.$lang_admin_sc[10].':</b></span>
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[11].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[12].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[13].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[14].'">
    <input type="submit" class="frame_menu" name="parameter" value="'.$lang_admin_sc[15].'">
  </div>
  </form>
</div>';
//------------------------------------------------------------------------------
echo '
<div style="border:1px solid #0D638A; height:468px; overflow: auto;">
<table style="width:100%">';
if ( !isset ( $_POST [ 'parameter' ] ) )
 {
  echo '
  <tr>
    <td class="bg1" style="vertical-align:top; padding:10px;">
    '.$lang_admin_sc[18].'
    </td>
  </tr>';
 }
else
 {
  echo '
  <tr>
    <td class="th2" style="height:18px; text-align:center; font-weight:bold; padding:2px; border:none; border-bottom:1px solid #0D638A;">'.$lang_admin_sc[19].'</td>
  </tr>';
 }
echo '
<tr>
  <td class="bg1" style="vertical-align:top; padding:10px; border:none;">';
//------------------------------------------------------------------------------
// get function
if ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == 'phpinfo' )
 {
  // phpinfo
  echo '
  <style>
  body {background-color: #fff; color: #222; font-family: sans-serif;}
  pre {margin: 0; font-family: monospace;}
  a:link {color: #009; text-decoration: none; background-color: #fff;}
  a:hover {text-decoration: underline;}
  table {border-collapse: collapse; border: 0; width: 934px; box-shadow: 1px 2px 3px #ccc;}
  .center {text-align: center;}
  .center table {margin: 1em auto; text-align: left;}
  .center th {text-align: center !important;}
  td, th {border: 1px solid #666; font-size: 75%; vertical-align: baseline; padding: 4px 5px;}
  h1 {font-size: 150%;}
  h2 {font-size: 125%;}
  .p {text-align: left;}
  .e {background-color: #ccf; width: 300px; font-weight: bold;}
  .h {background-color: #99c; font-weight: bold;}
  .v {background-color: #ddd; max-width: 300px; overflow-x: auto;}
  .v i {color: #999;}
  img {float: right; border: 0;}
  hr {width: 934px; background-color: #ccc; border: 0; height: 1px;}
  </style>
  ';

  ob_start();
  phpinfo();
  $info = ob_get_contents();
  $info = preg_replace("/^.*?\<body\>/is", "", $info);
  $info = preg_replace("/<\/body\>.*?$/is", "", $info);
  ob_end_clean();
  echo $info;
 }
elseif ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[6]" )
 {
  // server variables
  echo '<table style="border:1px solid #a4a4a4">';
  foreach ( $_SERVER as $key => $value )
   {
    echo '<tr><td class="bg3" style="width:35%">'.$key.'</td><td class="bg2" style="width:65%">'; if ( $value == "" ) { echo '&nbsp;'; } else { echo $value; } echo '</td></tr>';
   }
  echo '</table>';
 }
elseif ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[7]" )
 {
  // session variables
  echo '<table style="border:1px solid #a4a4a4">';
  echo '<tr><td class="bg3" style="width:210px">session_cache_expire</td><td class="bg2">'.@session_cache_expire().'</td></tr>';
  echo '<tr><td class="bg3">session_cache_limiter</td><td class="bg2">'.@session_cache_limiter().'</td></tr>';
  echo '<tr><td class="bg3">session_get_cookie_params</td><td class="bg2"><pre>'; print_r(@session_get_cookie_params()); echo'</pre></td></tr>';
  echo '<tr><td class="bg3">session_id</td><td class="bg2">'.@session_id().'</td></tr>';
  echo '<tr><td class="bg3">session_module_name</td><td class="bg2">'.@session_module_name().'</td></tr>';
  echo '<tr><td class="bg3">session_name</td><td class="bg2">'.@session_name().'</td></tr>';
  echo '<tr><td class="bg3">session_save_path</td><td class="bg2">'.@session_save_path().'</td></tr>';
  echo '<tr><td class="bg3">$_SESSION</td><td class="bg2"><pre>'; print_r ( $_SESSION ); echo'</pre></td></tr>';
  echo '</table>';
 }
elseif ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[11]" )
 {
  // ip addresses
  echo '<pre>';
  if ( isset ( $_SERVER [ 'SERVER_ADDR'            ] ) ) { echo '$_SERVER [ "SERVER_ADDR"            ]: '.$_SERVER [ 'SERVER_ADDR'            ].'<br>'; }
  echo '------------------------------------------------------------------ <br>';
  if ( isset ( $_SERVER [ 'REMOTE_ADDR'            ] ) ) { echo '$_SERVER [ "REMOTE_ADDR"            ]: '.$_SERVER [ 'REMOTE_ADDR'            ].'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_REMOTECLIENT_IP' ] ) ) { echo '$_SERVER [ "HTTP_X_REMOTECLIENT_IP" ]: '.$_SERVER [ 'HTTP_X_REMOTECLIENT_IP' ].'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_REAL_IP'         ] ) ) { echo '$_SERVER [ "HTTP_X_REAL_IP"         ]: '.$_SERVER [ 'HTTP_X_REAL_IP'         ].'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_FORWARDED_FOR'   ] ) ) { echo '$_SERVER [ "HTTP_X_FORWARDED_FOR"   ]: '.$_SERVER [ 'HTTP_X_FORWARDED_FOR'   ].'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_CLIENT_IP'         ] ) ) { echo '$_SERVER [ "HTTP_CLIENT_IP"         ]: '.$_SERVER [ 'HTTP_CLIENT_IP'         ].'<br>'; }
  if ( isset ( $_SERVER [ 'REMOTE_ADDR'            ] ) ) { echo 'getenv   ( "REMOTE_ADDR"            ): '.getenv   ( 'REMOTE_ADDR'            ).'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_REMOTECLIENT_IP' ] ) ) { echo 'getenv   ( "HTTP_X_REMOTECLIENT_IP" ): '.getenv   ( 'HTTP_X_REMOTECLIENT_IP' ).'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_REAL_IP'         ] ) ) { echo 'getenv   ( "HTTP_X_REAL_IP"         ): '.getenv   ( 'HTTP_X_REAL_IP'         ).'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_X_FORWARDED_FOR'   ] ) ) { echo 'getenv   ( "HTTP_X_FORWARDED_FOR"   ): '.getenv   ( 'HTTP_X_FORWARDED_FOR'   ).'<br>'; }
  if ( isset ( $_SERVER [ 'HTTP_CLIENT_IP'         ] ) ) { echo 'getenv   ( "HTTP_CLIENT_IP"         ): '.getenv   ( 'HTTP_CLIENT_IP'         ).'<br>'; }
  echo '</pre>';
 }
elseif ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[12]" )
 {
  // database
  if ( $db_active == 1 )
   {
    include ( 'config_db.php' );

    $link = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
    if ( !$link ) { f_exit ( $lang_admin_sc[25].'!' ); }

    echo '<pre>';
    echo 'mysqli_stat:               '.mysqli_stat($link)."\n";
    echo 'mysqli_get_client_info:    '.mysqli_get_client_info($link)."\n";
    echo 'mysqli_get_host_info:      '.mysqli_get_host_info($link)."\n";
    echo 'mysqli_get_server_info:    '.mysqli_get_server_info($link)."\n";
    echo 'mysqli_get_proto_info:     '.mysqli_get_proto_info($link)."\n";
    echo '<hr>';
    echo '<table style="font-family:monospace">';
    echo '<tr><td style="width:190px; line-height:19px">'.$lang_admin_sc[20].':</td><td>'.$db_host.'</td></tr>';
    echo '<tr><td style="width:190px; line-height:19px">'.$lang_admin_sc[21].':</td><td>'.$db_name.'</td></tr>';
    echo '<tr><td style="width:190px; line-height:19px">'.$lang_admin_sc[22].':</td><td>'.$db_user.'</td></tr>';
    echo '<tr><td style="width:190px; line-height:19px">'.$lang_admin_sc[23].':</td><td>'; for ( $i = 1 ; $i <= strlen ( $db_password ); $i++ ) { echo '*'; } echo '</td></tr>';
    echo '<tr><td style="width:190px; line-height:19px">'.$lang_admin_sc[24].':</td><td>'.$db_prefix.'</td></tr>';
    echo '</table>';
    echo '</pre>';

    #$db_selected = mysqli_select_db ( $link , $db_name );
    #if ( !$db_selected ) { f_exit ( mysql_error ( ) ); }
    $result = mysqli_query ( $link , 'SHOW TABLE STATUS' );

    while ( $row = mysqli_fetch_assoc ( $result ) ) { f ( $row ); $n [ ] = $row [ 'Name' ]; }
    echo '</table><br>'."\n";
    $t = false;

    foreach ( $n as $value_n )
     {
      $result = mysqli_query ( $link, 'SHOW COLUMNS FROM '.$value_n );
      if ( !$result ) { echo mysqli_error().'<br>'."\n"; }
      else
       {
        $result1 = mysqli_query ( $link, 'select * from '.$value_n );
        $i = 0;
        while ( $row = mysqli_fetch_assoc ( $result ) )
         {
          $row = array_merge ( array ( 'Table' => '' ) , $row , array ( '&nbsp;' => '' ) );
          $meta = mysqli_fetch_field ( $result1 , $i );
          $i++;

          foreach ( $meta as $key => $value )
           {
            if ( ( $key != 'name' ) && ( $key != 'table' ) )
             {
              $row [ $key ] = $value;
             }
           }
          f ( $row );
         }
       }
     }

    echo '</table>'.'<br>'."\n";
    $t = false;

    foreach( $n as $value_n )
     {
      $result = mysqli_query ( $link , 'SHOW INDEX FROM '.$value_n );
      if ( !$result ) { echo mysqli_error().'<br>'."\n"; }
      else
       {
        while ( $row = mysqli_fetch_assoc ( $result ) )
         {
          $row [ 'Table' ] = '';
          f ( $row );
         }
       }
     }
    echo '</table>';
    #f_exit ( '' );
   }
 }
elseif ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[13]" )
 {
  // file permissions
  echo '<table class="chmodtable">';
  if ( ( decoct ( fileperms ( "../backup/"      ) ) == 40777  ) || ( decoct ( fileperms ( "../backup/"      ) ) == 40775 ) || ( decoct ( fileperms ( "../backup/"      ) ) == 40770 ) ) { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">backup</td>     <td class="td3">'.folder_perms ( "../backup/" ).'</td>     <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">backup</td>     <td class="td3">'.folder_perms ( "../backup/" ).'</td>     <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../func/geoip/"  ) ) == 40777  ) || ( decoct ( fileperms ( "../func/geoip/"  ) ) == 40775 ) || ( decoct ( fileperms ( "../func/geoip/"  ) ) == 40770 ) ) { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">func/geoip</td> <td class="td3">'.folder_perms ( "../func/geoip/" ).'</td> <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">func/geoip</td> <td class="td3">'.folder_perms ( "../func/geoip/" ).'</td> <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/"         ) ) == 40777  ) || ( decoct ( fileperms ( "../log/"         ) ) == 40775 ) || ( decoct ( fileperms ( "../log/"         ) ) == 40770 ) ) { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">log</td>        <td class="td3">'.folder_perms ( "../log/" ).'</td>        <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">log</td>        <td class="td3">'.folder_perms ( "../log/" ).'</td>        <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/archive/" ) ) == 40777  ) || ( decoct ( fileperms ( "../log/archive/" ) ) == 40775 ) || ( decoct ( fileperms ( "../log/archive/" ) ) == 40770 ) ) { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">log/archive</td><td class="td3">'.folder_perms ( "../log/archive/" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">'.$icon_folder.'</td><td class="td2">log/archive</td><td class="td3">'.folder_perms ( "../log/archive/" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  echo '</table>';

  echo '<table class="chmodtable">';
  echo '<tr><th colspan="4">'.$icon_folder_th.' config</th></tr>';
  if ( ( decoct ( fileperms ( "config.php"                 ) ) == 100666 ) || ( decoct ( fileperms ( "config.php"                 ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">config.php</td>                <td class="td3">'.file_perms ( "config.php" ).'</td>                <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">config.php</td>                <td class="td3">'.file_perms ( "config.php" ).'</td>                <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "config_db.php"              ) ) == 100666 ) || ( decoct ( fileperms ( "config_db.php"              ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">config_db.php</td>             <td class="td3">'.file_perms ( "config_db.php" ).'</td>             <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">config_db.php</td>             <td class="td3">'.file_perms ( "config_db.php" ).'</td>             <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "pattern_site_name.inc"      ) ) == 100666 ) || ( decoct ( fileperms ( "pattern_site_name.inc"      ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">pattern_site_name.inc</td>     <td class="td3">'.file_perms ( "pattern_site_name.inc" ).'</td>     <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">pattern_site_name.inc</td>     <td class="td3">'.file_perms ( "pattern_site_name.inc" ).'</td>     <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "pattern_string_replace.inc" ) ) == 100666 ) || ( decoct ( fileperms ( "pattern_string_replace.inc" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">pattern_string_replace.inc</td><td class="td3">'.file_perms ( "pattern_string_replace.inc" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">pattern_string_replace.inc</td><td class="td3">'.file_perms ( "pattern_string_replace.inc" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "tracking_code.php"          ) ) == 100666 ) || ( decoct ( fileperms ( "tracking_code.php"          ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">tracking_code.php</td>         <td class="td3">'.file_perms ( "tracking_code.php" ).'</td>         <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">tracking_code.php</td>         <td class="td3">'.file_perms ( "tracking_code.php" ).'</td>         <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "tracking_code_xhtml.php"    ) ) == 100666 ) || ( decoct ( fileperms ( "tracking_code_xhtml.php"    ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">tracking_code_xhtml.php</td>   <td class="td3">'.file_perms ( "tracking_code_xhtml.php" ).'</td>   <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">tracking_code_xhtml.php</td>   <td class="td3">'.file_perms ( "tracking_code_xhtml.php" ).'</td>   <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  echo '</table>';

  echo '<table class="chmodtable">';
  echo '<tr><th colspan="4">'.$icon_folder_th.' css</th></tr>';
  if ( ( decoct ( fileperms ( "../css/print.css" ) ) == 100666 ) || ( decoct ( fileperms ( "../css/print.css" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">print.css</td><td class="td3">'.file_perms ( "../css/print.css" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">print.css</td><td class="td3">'.file_perms ( "../css/print.css" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../css/style.css" ) ) == 100666 ) || ( decoct ( fileperms ( "../css/style.css" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">style.css</td><td class="td3">'.file_perms ( "../css/style.css" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">style.css</td><td class="td3">'.file_perms ( "../css/style.css" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  echo '</table>';

  echo '<table class="chmodtable">';
  echo '<tr><th colspan="4">'.$icon_folder_th.' log</th></tr>';
  if ( ( decoct ( fileperms ( "../log/cache_memory_address.php"     ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_memory_address.php"     ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_memory_address.php</td>    <td class="td3">'.file_perms ( "../log/cache_memory_address.php" ).'</td>    <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_memory_address.php</td>    <td class="td3">'.file_perms ( "../log/cache_memory_address.php" ).'</td>    <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/cache_time_stamp.php"         ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_time_stamp.php"         ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_time_stamp.php</td>        <td class="td3">'.file_perms ( "../log/cache_time_stamp.php" ).'</td>        <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_time_stamp.php</td>        <td class="td3">'.file_perms ( "../log/cache_time_stamp.php" ).'</td>        <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/cache_time_stamp_archive.php" ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_time_stamp_archive.php" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_time_stamp_archive.php</td><td class="td3">'.file_perms ( "../log/cache_time_stamp_archive.php" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_time_stamp_archive.php</td><td class="td3">'.file_perms ( "../log/cache_time_stamp_archive.php" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/cache_visitors.php"           ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_visitors.php"           ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors.php</td>          <td class="td3">'.file_perms ( "../log/cache_visitors.php" ).'</td>          <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors.php</td>          <td class="td3">'.file_perms ( "../log/cache_visitors.php" ).'</td>          <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/cache_visitors_archive.php"   ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_visitors_archive.php"   ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors_archive.php</td>  <td class="td3">'.file_perms ( "../log/cache_visitors_archive.php" ).'</td>  <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors_archive.php</td>  <td class="td3">'.file_perms ( "../log/cache_visitors_archive.php" ).'</td>  <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/cache_visitors_counter.php"   ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_visitors_counter.php"   ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors_counter.php</td>  <td class="td3">'.file_perms ( "../log/cache_visitors_counter.php" ).'</td>  <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/cache_visitors_counter.php</td>  <td class="td3">'.file_perms ( "../log/cache_visitors_counter.php" ).'</td>  <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/index_days.php"               ) ) == 100666 ) || ( decoct ( fileperms ( "../log/index_days.php"               ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/index_days.php</td>              <td class="td3">'.file_perms ( "../log/index_days.php" ).'</td>              <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/index_days.php</td>              <td class="td3">'.file_perms ( "../log/index_days.php" ).'</td>              <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/last_logins.dta"              ) ) == 100666 ) || ( decoct ( fileperms ( "../log/last_logins.dta"              ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/last_logins.dta</td>             <td class="td3">'.file_perms ( "../log/last_logins.dta" ).'</td>             <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/last_logins.dta</td>             <td class="td3">'.file_perms ( "../log/last_logins.dta" ).'</td>             <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/last_timestamp.dta"           ) ) == 100666 ) || ( decoct ( fileperms ( "../log/last_timestamp.dta"           ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/last_timestamp.dta</td>          <td class="td3">'.file_perms ( "../log/last_timestamp.dta" ).'</td>          <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/last_timestamp.dta</td>          <td class="td3">'.file_perms ( "../log/last_timestamp.dta" ).'</td>          <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/logdb.dta"                    ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb.dta"                    ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb.dta</td>                   <td class="td3">'.file_perms ( "../log/logdb.dta" ).'</td>                   <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb.dta</td>                   <td class="td3">'.file_perms ( "../log/logdb.dta" ).'</td>                   <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/logdb_backup.dta"             ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb_backup.dta"             ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb_backup.dta</td>            <td class="td3">'.file_perms ( "../log/logdb_backup.dta" ).'</td>            <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb_backup.dta</td>            <td class="td3">'.file_perms ( "../log/logdb_backup.dta" ).'</td>            <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/logdb_temp.dta"               ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb_temp.dta"               ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb_temp.dta</td>              <td class="td3">'.file_perms ( "../log/logdb_temp.dta" ).'</td>              <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/logdb_temp.dta</td>              <td class="td3">'.file_perms ( "../log/logdb_temp.dta" ).'</td>              <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/pattern_browser.dta"          ) ) == 100666 ) || ( decoct ( fileperms ( "../log/pattern_browser.dta"          ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_browser.dta</td>         <td class="td3">'.file_perms ( "../log/pattern_browser.dta" ).'</td>         <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_browser.dta</td>         <td class="td3">'.file_perms ( "../log/pattern_browser.dta" ).'</td>         <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/pattern_operating_system.dta" ) ) == 100666 ) || ( decoct ( fileperms ( "../log/pattern_operating_system.dta" ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_operating_system.dta</td><td class="td3">'.file_perms ( "../log/pattern_operating_system.dta" ).'</td><td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_operating_system.dta</td><td class="td3">'.file_perms ( "../log/pattern_operating_system.dta" ).'</td><td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/pattern_referer.dta"          ) ) == 100666 ) || ( decoct ( fileperms ( "../log/pattern_referer.dta"          ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_referer.dta</td>         <td class="td3">'.file_perms ( "../log/pattern_referer.dta" ).'</td>         <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_referer.dta</td>         <td class="td3">'.file_perms ( "../log/pattern_referer.dta" ).'</td>         <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/pattern_resolution.dta"       ) ) == 100666 ) || ( decoct ( fileperms ( "../log/pattern_resolution.dta"       ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_resolution.dta</td>      <td class="td3">'.file_perms ( "../log/pattern_resolution.dta" ).'</td>      <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_resolution.dta</td>      <td class="td3">'.file_perms ( "../log/pattern_resolution.dta" ).'</td>      <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/pattern_site_name.dta"        ) ) == 100666 ) || ( decoct ( fileperms ( "../log/pattern_site_name.dta"        ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_site_name.dta</td>       <td class="td3">'.file_perms ( "../log/pattern_site_name.dta" ).'</td>       <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/pattern_site_name.dta</td>       <td class="td3">'.file_perms ( "../log/pattern_site_name.dta" ).'</td>       <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  if ( ( decoct ( fileperms ( "../log/timestamp_cache_update.dta"   ) ) == 100666 ) || ( decoct ( fileperms ( "../log/timestamp_cache_update.dta"   ) ) == 100660 ) ) { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/timestamp_cache_update.dta</td>  <td class="td3">'.file_perms ( "../log/timestamp_cache_update.dta" ).'</td>  <td class="td4">'.$icon_chmod_ok.'</td></tr>'; } else { echo '<tr><td class="td1">&nbsp;</td><td class="td2">log/timestamp_cache_update.dta</td>  <td class="td3">'.file_perms ( "../log/timestamp_cache_update.dta" ).'</td>  <td class="td4">'.$icon_chmod_error.'</td></tr>'; }
  echo '</table>';
  echo '<table class="chmodtable">';
  echo read_installed_themes();
  echo '</table>';
 }
elseif ( ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[14]" ) || ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[15]" ) )
 {
  // configuration
  $error_counter = 0;
  //------------------------------------------------------------------------------
  // Message
  if ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[15]" )
   {
    echo '<div style="width:99%; min-height:35px; margin:4px 0px 10px 0px; border:1px solid #CC0000; padding:2px; background:#F9FBE0; color:#CC0000; text-align:left; font-size:11px;"><img src="../images/alert.gif" style="border:0; margin:2px 15px 0px 10px; float:left" alt="">'.$lang_admin_sc[40].'</div>';
   }
  //------------------------------------------------------------------------------
  // check Server operating system + authority
  @error_reporting ( 3 );
  echo $lang_admin_sc[28].': '.php_uname().'<br>'.$lang_admin_sc[29].' config.php: ';
  $handle = @fopen ( 'config.php' , 'a' );
  if ( $handle ) { fclose ( $handle ); echo '<b><span style="color:green">'.$lang_admin_sc[30].'</span></b>';} else { echo '<b><span style="color:#CC0000">'.$lang_admin_sc[31].'</span></b>'; }
  echo '<hr>';
  //------------------------------------------------------------------------------
  echo '<table>';
  //------------------------------------------------------------------------------
  // check script_domain
  echo '<tr><td style="text-align:right; vertical-align:top; padding:5px 20px"><b>$script_domain:</b></td><td>'.$script_domain;
  if ( ( substr ( $script_domain , 0 , 7 ) != 'http://' ) && ( substr ( $script_domain , 0 , 8 ) != 'https://' ) ) { display_error ( $lang_admin_sc[33] ); }
  if ( ( ( substr ( $script_domain , 7 ) != $_SERVER [ 'HTTP_HOST' ] ) && ( substr ( $script_domain , 7 ) != 'www.'.$_SERVER [ 'HTTP_HOST' ] ) ) && ( ( substr ( $script_domain , 8 ) != $_SERVER [ 'HTTP_HOST' ] ) && ( substr ( $script_domain , 8 ) != 'www.'.$_SERVER [ 'HTTP_HOST' ] ) ) ) { display_error ( ''.$lang_admin_sc[34].' "<font color="green">'.$_SERVER [ "HTTP_HOST" ].'</font>"' ); }
  if ( substr_count ( $script_domain , '/' ) != 2 ) { display_error ( $lang_admin_sc[35] ); }
  checklink ( $script_domain );
  echo '</td></tr>';
  //------------------------------------------------------------------------------
  // check script_path
  echo '<tr><td style="text-align:right; vertical-align:top; padding:5px 20px"><b>$script_path:</b></td><td>'.$script_path;
  if ( substr ( dirname ( $_SERVER [ 'SCRIPT_NAME' ] ) , 1 ).substr ( dirname ( $_SERVER [ 'SCRIPT_NAME' ] ) , 0 , 1 ) != $script_path.'config/' ) { display_error ( $lang_admin_sc[36] ); }
  checklink ( $script_domain.'/'.$script_path );
  checklink ( $script_domain.'/'.$script_path."pws.php" );
  echo '</td></tr>';
  //------------------------------------------------------------------------------
  // check exception_domain
  echo '<tr><td style="text-align:right; vertical-align:top; padding:5px 20px"><b>$exception_domain:</b></td><td><pre style="padding:4px">'; print_r ( $exception_domain ); echo '</pre><br>';
  foreach ( $exception_domain as $value )
   {
    checklink ( $value );
   }
  echo '</td></tr>';
  //------------------------------------------------------------------------------
  echo '</table>';
  //------------------------------------------------------------------------------
  // error result
  echo '<br><div style="text-align:center; font-weight:bold; color:';
  if ( $error_counter == 0 ) { echo 'green'; } else { echo '#CC0000'; }
  echo '">'.$error_counter.' '.$lang_admin_sc[39].'</div>'."\n";
  //------------------------------------------------------------------------------
  // create javascript & image-code
  #A# Script immer ausgeben, execute + Abfrage-/Verarbeitungs-Folge + $exception_ip_address + 2 Befehlstasten
  echo '<hr>
  <div style="margin-bottom:8px"><b>JavaScript & Image-Code</b></div>
  &lt;script type="text/javascript" src="'.$script_domain.'/'.$script_path.'pws.php?mode=js">&lt;/script&gt;<br>';
  if ( file_exists ( "../plugins/onclick/pws_file.php" ) )
   {
    echo '&lt;script type="text/javascript" src="'.$script_domain.'/'.$script_path.'plugins/onclick/pws_file.php">&lt;/script&gt;<br>';
   }
  echo '&lt;noscript&gt;&lt;img src="'.$script_domain.'/'.$script_path.'pws.php?mode=img" style="border:0; width:1px; height:1px" alt="noscript-img"&gt;&lt;/noscript&gt;'."\n";
  //------------------------------------------------------------------------------
  // Logging-Test
  if ( isset ( $_POST [ 'parameter' ] ) && $_POST [ 'parameter' ] == "$lang_admin_sc[15]" )
   {
    echo '<hr>
    <div style="margin-bottom:8px"><b>Logging-Test</b></div>
    <ul style="padding-left:15px">';
    ################################################################################
    ### get ip address ###
    if     ( $get_ip_address == 1 )  { $ip_address = $_SERVER [ 'REMOTE_ADDR'            ]; }
    elseif ( $get_ip_address == 2 )  { $ip_address = $_SERVER [ 'HTTP_X_REMOTECLIENT_IP' ]; }
    elseif ( $get_ip_address == 3 )  { $ip_address = $_SERVER [ 'HTTP_X_FORWARDED_FOR'   ]; }
    elseif ( $get_ip_address == 4 )  { $ip_address = $_SERVER [ 'HTTP_CLIENT_IP'         ]; }
    elseif ( $get_ip_address == 5 )  { $ip_address = getenv   ( 'REMOTE_ADDR'            ); }
    elseif ( $get_ip_address == 6 )  { $ip_address = getenv   ( 'HTTP_X_REMOTECLIENT_IP' ); }
    elseif ( $get_ip_address == 7 )  { $ip_address = getenv   ( 'HTTP_X_FORWARDED_FOR'   ); }
    elseif ( $get_ip_address == 8 )  { $ip_address = getenv   ( 'HTTP_CLIENT_IP'         ); }
    else   { $ip_address = $_SERVER [ 'REMOTE_ADDR' ]; }
    //------------------------------------------------------------------------------
    // check for ip-address exclude
    $exception_ip_address_ok = false;

    for ( $x = 0 ; $x < count ( $exception_ip_addresses ) ; $x++ )
     {
      $ip_pattern = preg_replace( "/\./" , "\." , $exception_ip_addresses [ $x ] );
      $ip_pattern = preg_replace( "/\*/" , ".*" , $ip_pattern );
      if ( preg_match ( "/".$ip_pattern."/" , $ip_address ) ) { $exception_ip_address_ok = true; break; }
     }

    $arrUrl [ "host" ] = strtolower ( $_SERVER [ 'HTTP_HOST' ]);
    $exception_domain_ok = false;

    foreach ( $exception_domain as $value )
     {
      if ( preg_match ( "/\.".strtolower ( $value )."$/",".".$arrUrl [ "host" ] ) ) { $exception_domain_ok=true; break; }
     }

    if ( $exception_ip_address_ok )
     {
      echo '<div style="font-weight:bold; color:#CC0000">'.$lang_admin_sc[47].'</div></ul>';
     }
    elseif ( isset ( $_COOKIE [ "dontcount" ] ) )
     {
      echo '<div style="font-weight:bold; color:#CC0000">'.$lang_admin_sc[48].'</div></ul>';
     }
    elseif ( ! $exception_domain_ok )
     {
      echo '<div style="font-weight:bold; color:#CC0000">'.$lang_admin_sc[49].'</div></ul>';
     }
    else
     {
      echo '
      <script> document.write("<font color=\"green\">'.$lang_admin_sc[42].'.</font><br>'.$lang_admin_sc[44].'");</script>
      <noscript><font color="#CC0000">'.$lang_admin_sc[43].'!</font><br>'.$lang_admin_sc[45].'</noscript>
      <br><br>
      <script src="'.$script_domain.'/'.$script_path.'pws.php?mode=js"></script>
      <img src="'.$script_domain.'/'.$script_path.'pws.php?mode=img&ref='.$lang_admin_sc[41].' img" style="border:0; width:2; height:2" alt="">';
      // ------------------------------
      if ( file_exists ( '../plugins/lasthits/index.php' ) )
       {
        echo '<a href="../plugins/lasthits/index.php" target="_blank">'.$lang_admin_sc[46].'</a></ul>';
       }
      // ------------------------------
      // check https
      $protocol_https = 'http';
      if ( !empty ( $_SERVER [ 'HTTPS' ] ) )
       {
        if ( $_SERVER [ 'HTTPS' ] !== "off" ) { $protocol_https = 'https'; }
        else { $protocol_https = 'http'; }
       }
      else { $protocol_https = 'http'; }
      // ------------------------------
      $_GET [ 'mode' ] = 'img';
      $_GET [ 'ref'  ] = $lang_admin_sc[41].' include';
      $_SERVER [ 'HTTP_REFERER' ] = $protocol_https.'://'.$_SERVER [ 'HTTP_HOST' ].'/syscheck.php?'.$_SERVER [ 'QUERY_STRING' ]; // site_name
      error_reporting ( 0 );
      ob_start();
      chdir('../');
      include ( 'pws.php' );
      ob_end_clean();
     }
   }
 }
//------------------------------------------------------------------------------
echo '
</td>
</tr>
</table>
</div>';
//------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>
