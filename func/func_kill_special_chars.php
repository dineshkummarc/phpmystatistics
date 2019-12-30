<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     4.0.x                                                    #
# File-Release-Date:  18/01/21                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright � 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function kill_special_chars ( $value )
 {
 	$value = str_replace( "�"    , "&szlig;" , $value ); // replace �
  $value = str_replace( "ß"   , "&szlig;" , $value ); // replace �
  $value = str_replace( "�"   , "&szlig;" , $value ); // replace �
  //--------------------
  $value = str_replace( "�"    , "&Auml;"  , $value ); // replace �
  $value = str_replace( "�"    , "&auml;"  , $value ); // replace �
  $value = str_replace( "ä"   , "&auml;"  , $value ); // replace �
  $value = str_replace( "�"   , "&auml;"  , $value ); // replace �
  $value = str_replace( "¼"   , "&auml;"  , $value ); // replace �
  $value = str_replace( "�"   , "&auml;"  , $value ); // replace �
  //--------------------
  $value = str_replace( "�"    , "&Ouml;"  , $value ); // replace �
  $value = str_replace( "�"    , "&ouml;"  , $value ); // replace �
  $value = str_replace( "ö"   , "&ouml;"  , $value ); // replace �
  $value = str_replace( "�"   , "&ouml;"  , $value ); // replace �
  //--------------------
  $value = str_replace( "�"    , "&Uuml;"  , $value ); // replace �
  $value = str_replace( "�"    , "&uuml;"  , $value ); // replace �
  $value = str_replace( "�?"   , "&uuml;"  , $value ); // replace �
  $value = str_replace( "�?"   , "&uuml;"  , $value ); // replace �
  $value = str_replace( "ü"   , "&uuml;"  , $value ); // replace �
  $value = str_replace( "�"   , "&uuml;"  , $value ); // replace �
  //--------------------
  $value = str_replace( "\""   , "&quot;"  , $value ); // replace "
  $value = str_replace( "\\"   , ""        , $value ); // delete  \
  $value = str_replace( "<"    , ""        , $value ); // delete  <
  $value = str_replace( ">"    , ""        , $value ); // delete  >
  return $value;
 }
//------------------------------------------------------------------------------
?>