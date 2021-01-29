<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.3                                                      #
# File-Release-Date:  21/01/01                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2021 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function db_query ( $query, $switch, $cancel )
 {
  global $dirname;
  global $filename;
  //----------------------------------------------------------------------------
  // include db prefix
      if ( isset ( $dirname ) && $dirname == 'config'  ) { include ( 'config_db.php' ); }
  elseif ( isset ( $dirname ) && $dirname == 'plugins' ) { include ( '../../config/config_db.php' ); }
    else { include ( 'config/config_db.php' ); }
  //----------------------------------------------------------------------------
  $db_entries      = array ();
  $db_connection   = 0;
  $db_counter      = 0;
  $db_number_rows  = 0;
  $db_query_result = 0;
  $db_temp         = 0;
  $db_temp_counter = 0;
  $db_error        = 0;
  //----------------------------------------------------------------------------
  $db_connection = mysqli_connect ( $db_host , $db_user , $db_password , $db_name );
  //----------------------------------------------------------------------------
  if ( mysqli_connect_errno() )
   {
   	if ( $cancel == 1 ) { echo '<meta http-equiv="refresh" content="2; URL='.$_SERVER ["PHP_SELF"].'\">'; }
    else
     {
      if ( isset ( $filename ) && $filename == 'setup' ) { $db_error = mysqli_error(); $GLOBALS [ "connection_error" ] = 5; }
      else
       {
        $db_error = mysqli_error();
        if ( isset ( $db_error ) ) { exit ( $db_error ); } else { echo 'Database connection failure'; exit; }
       }
     }
   }
  //----------------------------------------------------------------------------
  $query_result = mysqli_query ( $db_connection , $query );
  //----------------------------------------------------------------------------
  if ( !$query_result )
   {
    if ( isset ( $filename ) && $filename == 'setup' ) { $db_error = mysqli_error(); $GLOBALS [ "connection_error" ] = 5; }
    else
     {
      $db_error = mysqli_error();
      if ( isset ( $db_error ) ) { exit ( $db_error ); } else { echo 'Database connection failure'; exit; }
     }
   }
  //----------------------------------------------------------------------------
  if  ( $switch == 1 )
   {
    $db_number_rows = mysqli_num_rows ( $query_result );
    while ( $db_temp = mysqli_fetch_row ( $query_result ) )
     {
      for ( $db_temp_counter = 0 ; $db_temp_counter < count ( $db_temp ) ; $db_temp_counter++ )
       {
        $db_entries [ $db_counter ] [ $db_temp_counter ] = $db_temp[ $db_temp_counter ];
       }
      $db_counter++;
     }
   }
  //----------------------------------------------------------------------------
  mysqli_close( $db_connection );
  return $db_entries;
  //----------------------------------------------------------------------------
 }
//------------------------------------------------------------------------------
?>