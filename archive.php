<?php @session_start(); if ( $_SESSION [ 'hidden_stat' ] != md5_file ( 'config/config.php' ) ) { include ( 'func/func_error.php' ); exit; }
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  17/07/15                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
include ( 'config/config.php'      ); // include config
include ( $language                ); // include language
include ( 'func/func_read_dir.php' ); // include read directory function
include ( 'func/html_header.php'   ); // include html header
//------------------------------------------------------------------------------
echo '
<div style="margin-top:10px">
  <div>
    <p>'.$lang_archive[4].'</p>
    <form action="index.php" method="post" target="index">
    <div class="form-group">
      <div class="input-group">
        <input type="text" class="form-control" name="from_timestamp" id="f_date_a">
        <span class="input-group-btn" style="width:0px;"></span>
        <input type="text" class="form-control" name="until_timestamp" id="f_calcdate">
        <input type="hidden" name="archive" value="1">
        <span class="input-group-btn">
          <button type="submit" class="btn" onclick="show_archive();"><span class="glyphicon glyphicon-ok"></span> '.$lang_archive[5].'</button>
        </span>
      </div>
    </div>
    </form>
  </div>
  <br>';

  $archive_files = read_dir ( "log/archive" );
  asort ( $archive_files );
  echo '
  <div>
    <p>'.$lang_archive[6].'</p>
    <form action="index.php" method="get" target="index">
    <div class="form-group">
      <div class="input-group">
        <select class="form-control" style="height:34px" name="archive_save" size="1">';
        foreach ( $archive_files as $value )
         {
          $temp = substr ( $value , strrpos ( $value , "/" ) + 1 );
          $temp = substr ( $temp , 0 , strlen ($temp ) - 4 );
          $temp = explode ( "-" , $temp );
          echo "<option value=\"".$value."\">".date ( "Y-m-d" , trim ( $temp [ 0 ] ) )." - ".date ( "Y-m-d" , trim ( $temp [ 1 ] )  )."</option>";
         }
        echo '
        </select>
        <input type="hidden" name="parameter" value="finished">
        <span class="input-group-btn">
          <button type="submit" class="btn" style="height:34px" onclick="show_archive();"><span class="glyphicon glyphicon-ok"></span> '.$lang_archive[7].'</button>
        </span>
      </div>
    </div>
    </form>
  </div>
</div>

<script type="text/javascript">
  Calendar.setup({
      trigger      :   "f_date_a",
      inputField   :   "f_date_a",   // id of the input field
      align        :   "ct",         // alignment (defaults to "Bl")
      dateFormat   :   "%d-%m-%Y",   // format of the input field
      onSelect     :   function(cal) { cal.hide() }
  });
  Calendar.setup({
      trigger      :   "f_calcdate",
      inputField   :   "f_calcdate", // id of the input field
      align        :   "ct",         // alignment (defaults to "Bl")
      dateFormat   :   "%d-%m-%Y",   // format of the input field
      onSelect     :   function(cal) { cal.hide() }
  });
</script>';
//------------------------------------------------------------------------------
include ( 'func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>