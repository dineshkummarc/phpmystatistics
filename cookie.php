<?php @session_start();
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/06/04                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
include ( 'config/config.php'   ); // include path to logfile
include ( 'func/func_crypt.php' ); // include password comparison function
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset( $_REQUEST ['language'] ) )
 {
  switch ( $_REQUEST ['language'] )
   {
    case "de": $strLanguageFile = "language/german.php";     $lang = "de"; break;
    case "en": $strLanguageFile = "language/english.php";    $lang = "en"; break;
    case "nl": $strLanguageFile = "language/dutch.php";      $lang = "nl"; break;
    case "it": $strLanguageFile = "language/italian.php";    $lang = "it"; break;
    case "es": $strLanguageFile = "language/spanish.php";    $lang = "es"; break;
    case "dk": $strLanguageFile = "language/danish.php";     $lang = "dk"; break;
    case "fr": $strLanguageFile = "language/french.php";     $lang = "fr"; break;
    case "tr": $strLanguageFile = "language/turkish.php";    $lang = "tr"; break;
    case "hu": $strLanguageFile = "language/hungarian.php";  $lang = "hu"; break;
    case "pt": $strLanguageFile = "language/portuguese.php"; $lang = "pt"; break;
    case "he": $strLanguageFile = "language/hebrew.php";     $lang = "he"; break;
    case "ru": $strLanguageFile = "language/russian.php";    $lang = "ru"; break;
    case "rs": $strLanguageFile = "language/serbian.php";    $lang = "rs"; break;
    case "fi": $strLanguageFile = "language/finnish.php";    $lang = "fi"; break;
    default:   $strLanguageFile = $language;  // include language vars from config file
  }
}
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( $language ); // include language vars from config file
 }
//------------------------------------------------------------------------------
$version_info = file("index.php"); // include stat version and release date
eval($version_info[32]);
eval($version_info[33]);
eval($version_info[34]);
//------------------------------------------------------------------------------
// opt-out style
if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { $bgcolor  = '#'.$_REQUEST ['bgcolor'];   } else { $bgcolor  = 'transparent'; }
if ( isset ( $_REQUEST ['color'     ] ) ) { $color    = '#'.$_REQUEST ['color'  ];   } else { $color    = '#000000';     }
if ( isset ( $_REQUEST ['fontsize'  ] ) ) { $fontsize = $_REQUEST ['fontsize'].'px'; } else { $fontsize = '12px';        }
if ( isset ( $_REQUEST ['stylesheet'] ) )
 {
  $stylesheet = '<link rel="stylesheet" type="text/css" href="'.$_REQUEST ['stylesheet'].'">';
 }
else
 {
  $stylesheet = null;
 }
//------------------------------------------------------------------------------
// html header for opt-out
$html_header = '<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Statistik '.$version_number.$revision_number.'</title>
  <style type="text/css">
   body             { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: '.$fontsize.'; background-color: '.$bgcolor.'; color: '.$color.' }
   .info            { margin-bottom: 10px }
   a, a:active      { color: '.$color.'; text-decoration: none }
   a:hover, a:focus { color: '.$color.'; text-decoration: underline; outline: 0 }
   .pagelink:link, .pagelink:active { color: '.$color.'; text-decoration: none }
   .pagelink:hover, .pagelink:focus { color: '.$color.'; text-decoration: underline; outline: 0 }
  </style>
  '.$stylesheet.'
</head>
<body>
';
//------------------------------------------------------------------------------
if ( ( isset ( $_GET ['action'] ) ) && ( $_GET ['action'] == 'opt-out' ) )
 {
  if ( isset ( $_POST ['setcookie'] ) )
   {
    if ( ( isset ( $_COOKIE ['dontcount'] ) ) && ( $_COOKIE ['dontcount'] == 'ja' ) )
     {
      setcookie ( 'dontcount', $_COOKIE ['dontcount'], time()-3600*24*365*5 , '/' );
      echo $html_header;
      echo '<div class="info">'.$lang_setcookie[7].'</div>';
      echo '
      <form action="'.$_SERVER ['PHP_SELF'].'?action=opt-out" method="post">
       <input type="hidden" name="setcookie" value="0">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.$_REQUEST ['stylesheet'].'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()">
       <label for="stat-track"><b>'.$lang_setcookie[8].'</b></label>
      </form>
      </body>
      </html>';
     }
    else
     {
      setcookie ( 'dontcount', 'ja', time()+3600*24*365*5 , '/' );
      echo $html_header;
      echo '<div class="info">'.$lang_setcookie[9].'</div>';
      echo '
      <form action="'.$_SERVER ['PHP_SELF'].'?action=opt-out" method="post">
       <input type="hidden" name="setcookie" value="1">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.$_REQUEST ['stylesheet'].'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()" checked="checked">
       <label for="stat-track"><b>'.$lang_setcookie[10].'</b></label>
      </form>
      </body>
      </html>';
     }
   }
  else
   {
    if ( ( isset ( $_COOKIE ['dontcount'] ) ) && ( $_COOKIE ['dontcount'] == 'ja' ) )
     {
      echo $html_header;
      echo '<div class="info">'.$lang_setcookie[9].'</div>';
      echo '
      <form action="'.$_SERVER ['PHP_SELF'].'?action=opt-out" method="post">
       <input type="hidden" name="setcookie" value="1">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.$_REQUEST ['stylesheet'].'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()" checked="checked">
       <label for="stat-track"><b>'.$lang_setcookie[10].'</b></label>
      </form>
      </body>
      </html>';
     }
    else
     {
      echo $html_header;
      echo '<div class="info">'.$lang_setcookie[7].'</div>';
      echo '
      <form action="'.$_SERVER ['PHP_SELF'].'?action=opt-out" method="post">
       <input type="hidden" name="setcookie" value="0">';
       if ( isset ( $_REQUEST ['bgcolor'   ] ) ) { echo '<input type="hidden" name="bgcolor" value="'.substr ( $_REQUEST ['bgcolor'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['color'     ] ) ) { echo '<input type="hidden" name="color" value="'.substr ( $_REQUEST ['color'], 0, 6 ).'">'; }
       if ( isset ( $_REQUEST ['fontsize'  ] ) ) { echo '<input type="hidden" name="fontsize" value="'.substr ( $_REQUEST ['fontsize'], 0, 2 ).'">'; }
       if ( isset ( $_REQUEST ['language'  ] ) ) { echo '<input type="hidden" name="language" value="'.$_REQUEST ['language'].'">'; }
       if ( isset ( $_REQUEST ['stylesheet'] ) ) { echo '<input type="hidden" name="stylesheet" value="'.$_REQUEST ['stylesheet'].'">'; }
       echo '
       <input type="checkbox" id="stat-track" name="stat-track" onclick="this.form.submit()">
       <label for="stat-track"><b>'.$lang_setcookie[8].'</b></label>
      </form>
      </body>
      </html>';
     }
   }
 }
else
 {
  //------------------------------------------------------------------------------
  if ( ( $loginpassword_ask == 1 ) && ( $_SESSION ['loggedin'] != 'admin' ) )
   {
    if ( $clientpassword == "" )
     {
      $clientpassword = md5 ( time ( ) );
     }
    if ( ( !isset ( $_POST ['password'] ) ) || ( ( passCrypt ( $_POST ['password'] ) != $adminpassword ) && ( md5 ( $_POST ['password'] ) != md5 ( $adminpassword ) ) && ( passCrypt ( $_POST ['password'] ) != $clientpassword ) && ( md5 ( $_POST ['password'] ) != md5 ( $clientpassword ) ) ) )
     {
  	  include ( 'func/html_header.php' ); // include html header
  	  // login
  	  echo '
      <div id="login">
        <img src="images/loading_indicator_48.gif" style="width:1px; height:1px; display:none" alt="">
        <div class="title">PHP Web Stat</div>
        <div class="pic"><img src="images/login_key.png" alt=""></div>
        <div class="info">'.$lang_login[1].'</div>
        <div class="data-input">
          <p style="margin-top:0; margin-bottom:8px">'.$lang_login[2].'</p>
          <form name="login" action="cookie.php" method="post">
          <div class="form-group">
            <label class="sr-only" for="password">'.$lang_login[3].'</label>
            <div class="input-group">
              <div class="input-group-addon"><span class="glyphicon glyphicon-lock fa-lg"></span></div>
              <input type="password" name="password" id="password" class="form-control" placeholder="'.$lang_login[3].'">
            </div>
          </div>
          <button type="button" class="btn btn-sm" style="float:right; margin-left:8px" onclick="window.close()">'.$lang_login[5].'</button>
          <button type="submit" class="btn btn-sm" style="float:right"><span class="glyphicon glyphicon-log-in"></span> '.$lang_login[4].'</button>
          </form>
        </div>
        <div class="footer">
          Copyright &copy; '.$last_edit.' PHP Web Stat &nbsp;<b>&middot;</b>&nbsp; Version '.$version_number.$revision_number.'
        </div>
      </div>
      ';
   	  include ( 'func/html_footer.php' ); // include html footer
   	  exit;
     }
   }
  //------------------------------------------------------------------------------
  if ( ( isset ( $_COOKIE ['dontcount'] ) ) && ( $_COOKIE ['dontcount'] == 'ja' ) )
   {
    setcookie ( 'dontcount', $_COOKIE ['dontcount'], time()-3600*24*365*5 , '/' );
    $text = '<p>'.$lang_setcookie[6].' <span class="glyphicon glyphicon-remove" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:#c40000; cursor:default"></span></p><p>'.$lang_setcookie[3].'';
   }
  else
   {
    setcookie ( 'dontcount', 'ja', time()+3600*24*365*5 , '/' );
    $text = '<p>'.$lang_setcookie[5].' <span class="glyphicon glyphicon-ok" style="font-size:15px; vertical-align:middle; margin-top:-4px; color:green; cursor:default"></span></p><p>'.$lang_setcookie[1].'';
   }
  //------------------------------------------------------------------------------
  echo'<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3; url=index.php?action=backtostat">
    <title>PHP Web Statistik '.$version_number.$revision_number.'</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="'.$theme.'style.css">
  </head>
  <body>
  <div class="panel" style="position:absolute; top:50%; left:50%; width:400px; margin-top:-70px; margin-left:-200px">
    <div class="panel-heading"><span class="panel-title"><b>Cookie Info!</b></span></div>
    <div class="panel-body">'.$text.'</div>
  </div>
  </body>
  </html>';
 }
//------------------------------------------------------------------------------
?>
