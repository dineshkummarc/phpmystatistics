<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/01/28                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

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
?>