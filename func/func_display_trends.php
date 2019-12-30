<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  16/01/31                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function display_trends ( &$data , &$data_average , $parameter )
 {
  //----------------------------------------------------------------------------
  include ( "config/config.php" ); // include path to logfile
  include ( $language           ); // include language vars
  //----------------------------------------------------------------------------
  $trend_value         = 0;
  $trend_value_average = 0;

  foreach ( $data as $key => $value )
   {
    //--------------------------------------------------------------------------
    if ( $parameter == 1 ) { $key = " ".$key." "; }

    if ( ( $key % 2 ) == 0 ) { $background = ' style="background-color:rgba(0,0,0,.05)"'; } else { $background = ""; }
    echo '<tr'.$background.'>';
    echo '<td class="module-data">'.$key.'</td>';

    $difference         = ( int ) round ( $value - $trend_value );
    $difference_average = ( int ) round ( $data_average [ $key ] - $trend_value_average );

    if ( $trend_value == 0 ) { $difference_percent = 100; }
    else { $difference_percent = ( int ) round ( ( $value - $trend_value ) / $trend_value  * 100 ); }

    if ( $trend_value_average == 0 ) { $difference_percent_average = 100; }
    else { $difference_percent_average = ( int ) round ( ( $data_average [ $key ] - $trend_value_average ) / $trend_value_average  * 100 ); }

    //$howmuch_1 = $value;
    //$howmuch_2 = 100 - $value;
    //$howmuch_3 = $value - 100;

    $sum_total = max ( $data );

    $howmuch_1 = ( int ) round ( $value / $sum_total * 100 );
    $howmuch_2 = ( int ) 100 - ( $value / $sum_total * 100 );
    $howmuch_3 = ( int ) round ( $value / $sum_total * 100 -100 );

    echo '<td class="module-slidebar">';
    if ( trim ( $howmuch_2 ) == "100" )
     {
      // trend 100% (green)
      echo '<div class="progress progress-module" style="width:102px"><div class="progress-bar progress-bar-module progress-bar-module-minus" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div></div>';
     }
    else
     {
      if ( trim ( $howmuch_2 ) == "0" )
       {
        // trend 0% (red)
        echo '<div class="progress progress-module" style="width:102px"><div class="progress-bar progress-bar-module progress-bar-module-plus" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%"></div></div>';
       }
      else
       {
        if ( $difference > 0 )
         {
          // trend plus (green)
          echo '<div class="progress progress-module" style="width:102px"><div class="progress-bar progress-bar-module progress-bar-module-plus" role="progressbar" aria-valuenow="'.$howmuch_1.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$howmuch_1.'%"></div></div>';
         }
        else
         {
         	// trend minus (red)
         	echo '<div class="progress progress-module" style="width:102px"><div class="progress-bar progress-bar-module progress-bar-module-minus" role="progressbar" aria-valuenow="'.$howmuch_1.'" aria-valuemin="0" aria-valuemax="100" style="width:'.$howmuch_1.'%"></div></div>';
         }
       }
     }

    echo '</td>';

    if ( $parameter == 1 )
     {
      echo '<td class="module-hits">'.number_format ( $difference , 0 , "," , "." ).'</td>';
      echo '<td class="module-hits">'.number_format ( $value , 0 , "," , "." ).'</td>';
      echo '<td class="module-percent" style="border-right:1px outset #6f6f6f">'.$difference_percent.'%</td>';
      echo '<td class="module-hits" style="width:75px">'.number_format ( $difference_average , 0 , "," , "." ).'</td>';
      echo '<td class="module-hits" style="width:80px">'.number_format ( $data_average [ $key ] , 0 , "," , "." ).'</td>';
      echo '<td class="module-percent">'.$difference_percent_average.'%</td>';
     }
    else
     {
      echo '<td class="module-hits">'.number_format ( $difference_average , 0 , "," , "." ).'</td>';
      echo '<td class="module-hits">'.number_format ( $data_average [ $key ] , 0 , "," , "." ).'</td>';
      echo '<td class="module-percent" style="border-right:1px outset #6f6f6f">'.$difference_percent_average.'%</td>';
      echo '<td class="module-hits" style="width:75px">'.number_format ( $difference , 0 , "," , "." ).'</td>';
      echo '<td class="module-hits" style="width:80px">'.number_format ( $value , 0 , "," , "." ).'</td>';
      echo '<td class="module-percent">'.$difference_percent.'%</td>';
     }

    echo '</tr>'."\n";

    $trend_value         = $value;
    $trend_value_average = $data_average [ $key ];
    //--------------------------------------------------------------------------
   }
 }
//------------------------------------------------------------------------------
?>