<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/12/29                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function plugin_include ( $var )
 {
  include ( 'config/config.php' ); // include path to logfile
  include ( $language           ); // include language vars
  //-------------------------------------------------
  $plugin_files_read = read_dir ( 'plugins/' );
  asort ( $plugin_files_read );
  //-------------------------------------------------
  foreach ( $plugin_files_read as $value )
   {
    if ( file_exists ( 'plugins/'.$value.'/stat_var.php' ) )
     {
      $plugin_link  = null;
      $plugin_modal = null;
      $plugin_js    = null;

      include ( 'plugins/'.$value.'/stat_var.php' );

      if ( ( $db_active == 0 ) || ( $db_active == 1 ) && ( $plugin_database == 1 ) )
       {
        if ( $var == "link"  ) { echo $plugin_link; }
        if ( $var == "modal" ) { echo $plugin_modal; }
        if ( $var == "js"    ) { echo $plugin_js; }
       }

      unset ( $plugin_version   );
      unset ( $plugin_release   );
      unset ( $plugin_author    );
      unset ( $plugin_website   );
      unset ( $plugin_database  );
      unset ( $plugin_directory );
      unset ( $plugin_name      );
      unset ( $plugin_link      );
      unset ( $plugin_modal     );
      unset ( $plugin_js        );
     }
   }
 }
//------------------------------------------------------------------------------
?>