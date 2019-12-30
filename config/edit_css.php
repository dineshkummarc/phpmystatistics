<?php @session_start(); if ( $_SESSION [ 'hidden_func' ] != md5_file ( 'config.php' ) ) { $error_path = '../'; include ( '../func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/05/14                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
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
if ( !in_array ( $_GET [ 'action' ] , array ( "stat" , "theme" , "counter" , "print" ) ) ) { $_GET [ 'action' ] = "stat"; }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'action' ] ) && $_GET [ 'action' ] == 'stat' )
 {
  if ( isset ( $_POST [ 'save' ] ) )
   {
    $content = stripslashes ( trim ( $_POST [ 'content' ] ) );
    $css_file = fopen ( "../css/style.css" , "r+" );
    flock ( $css_file , LOCK_EX );
     ftruncate ( $css_file , 0 );
     fwrite ( $css_file , $content );
    flock ( $css_file , LOCK_UN );
    fclose ( $css_file );
   }
  //------------------------------
  $read_css_file = "../css/style.css" ;
  $form = '<form style="margin:0px;" name="edit" action="'.$_SERVER [ 'PHP_SELF' ].'?action=stat" method="post">';
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'action' ] ) && $_GET [ 'action' ] == 'theme' )
 {
  if ( isset ( $_POST [ 'save' ] ) )
   {
    $content = stripslashes ( trim ( $_POST [ 'content' ] ) );
    $css_file = fopen ( "../".$theme."style.css" , "r+" );
    flock ( $css_file , LOCK_EX );
     ftruncate ( $css_file , 0 );
     fwrite ( $css_file , $content );
    flock ( $css_file , LOCK_UN );
    fclose ( $css_file );
   }
  //------------------------------
  $read_css_file =  "../".$theme."style.css" ;
  $form = '<form style="margin:0px;" name="edit" action="'.$_SERVER [ 'PHP_SELF' ].'?action=theme" method="post">';
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'action' ] ) && $_GET [ 'action' ] == 'counter' )
 {
  if ( isset ( $_POST [ 'save' ] ) )
   {
    $content = stripslashes ( trim ( $_POST [ 'content' ] ) );
    $css_file = fopen ( "../".$theme."counter.css" , "r+" );
    flock ( $css_file , LOCK_EX );
     ftruncate ( $css_file , 0 );
     fwrite ( $css_file , $content );
    flock ( $css_file , LOCK_UN );
    fclose ( $css_file );
   }
  //------------------------------
  $read_css_file =  "../".$theme."counter.css" ;
  $form = '<form style="margin:0px;" name="edit" action="'.$_SERVER [ 'PHP_SELF' ].'?action=counter" method="post">';
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'action' ] ) && $_GET [ 'action' ] == 'print' )
 {
  if ( isset ( $_POST [ 'save' ] ) )
   {
    $content = stripslashes ( trim ( $_POST [ 'content' ] ) );
    $css_file = fopen ( "../css/print.css" , "r+" );
    flock ( $css_file , LOCK_EX );
     ftruncate ( $css_file , 0 );
     fwrite ( $css_file , $content );
    flock ( $css_file , LOCK_UN );
    fclose ( $css_file );
   }
  //------------------------------
  $read_css_file = "../css/print.css" ;
  $form = '<form style="margin:0px;" name="edit" action="'.$_SERVER [ 'PHP_SELF' ].'?action=print" method="post">';
 }
//------------------------------------------------------------------------------
include ( '../func/html_header.php' ); // include html header
//------------------------------------------------------------------------------
echo '
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
<tr>
 <td align="center" bgcolor="#D7E2EA" style="padding:10px; color:#000000; border-bottom:1px solid #0D638A;">
 '.$form.'
 <textarea name="content" rows="15" style="width:100%; height:380px; background-color:#F9FAFB;">
';
if ( isset ( $_GET [ 'action' ] ) )
 {
  readfile ( $read_css_file );
 }
 echo '</textarea>
 </td>
</tr>
<tr>
 <td class="th2 center" style="height:24px; padding:2px;">
 <input type="hidden" name="save" value="1">
 <input type="submit" class="submit" value="'.$lang_admin_f[1].'">
 </form>
 </td>
</tr>
</table>
';
//------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>