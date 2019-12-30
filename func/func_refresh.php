<?php if ( !isset ( $_SERVER [ "PHP_SELF" ] ) || basename ( $_SERVER [ "PHP_SELF" ] ) == basename (__FILE__) ) { $error_path = "../"; include ( "func_error.php" ); exit; };
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/10/31                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
echo"<script>
/* <![CDATA[ */
creator_iframe=\"func/func_load_creator.php?parameter=update_stat_cache\"
control_iframe=\"func/func_timestamp_control.php?parameter=stat\"

//check browser
ie=0
ns4=0
dom=0
if(document.getElementById)
dom=1
if(document.layers)
ns4=1

// write refresh display
function refresh_display()
 {
  if(ns4)
    document.write('<layer name=\"refresh\" z-index=\"10\" width=\"323\" height=\"196\" visibility=\"show\">')
  else
    document.write('<div id=\"refresh\" style=\"visibility:hidden\">')
    document.write('<div class=\"header\">".$lang_refresh[1]."</div>')
    document.write('<div class=\"indicator\"><img src=\"images/loading_indicator_48.gif\" title=\"loading\" alt=\"loading\"><br><iframe name=\"creator\" src=\"\" style=\"width:10px; height:10px; background:transparent; border:0; overflow:hidden\"></iframe></div>')
    document.write('<div class=\"info\">".$lang_refresh[2]."<br>".$lang_refresh[3]."</div>')
    document.write('<div class=\"clearfix\"></div>')
    document.write('<div class=\"c-frame\">".$lang_refresh[4]."<br><iframe name=\"control\" src=\"\" style=\"width:200px; height:22px; margin-top:-2px; background:transparent; border:0; overflow:hidden\"></iframe></div>')

  if(ns4)
    document.write('<\/layer>')
  else
    document.write('<\/div>')
 }

function getobj(obj)
 {
  return(ns4?document.layers[obj]:document.getElementById(obj).style)
 }

// show refresh display
function start(iframe1,iframe2)
 {
  ns4?getobj('refresh').visibility=\"show\":getobj('refresh').visibility=\"visible\"
  self.frames[\"creator\"].location.href=iframe1
  self.frames[\"control\"].location.href=iframe2
 }
/* ]]> */
</script>
";
//------------------------------------------------------------------------------
?>