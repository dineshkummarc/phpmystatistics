<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/04/26                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == 'update_stat_cache' )
 {
  echo "<meta http-equiv=\"refresh\" content=\"0; url=../cache_creator.php?loadfile=1\">";
 }
//------------------------------------------------------------------------------
if ( isset ( $_GET [ 'parameter' ] ) && $_GET [ 'parameter' ] == 'create_stat_cache' )
 {
  echo "<meta http-equiv=\"refresh\" content=\"0; url=../cache_creator.php?loadfile=2\">";
 }
//------------------------------------------------------------------------------
?>