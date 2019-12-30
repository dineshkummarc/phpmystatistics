<?php @session_start();
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/06/02                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
##### !!! never change this value !!! #####
$stat_version = file ( "../index.php" ); // include stat version
eval ( $stat_version [ 32 ] );
eval ( $stat_version [ 33 ] );
$last_edit = "2018";
//------------------------------------------------------------------------------
/* Filter $_GET and $_POST Vars */
function array_map_R ( $func , $arr )
 {
	if ( is_array ( $arr ) )
	 {
    $newArr = array();
    foreach ( $arr as $key => $value )
     {
      $newArr [ $key ] = ( is_array ( $value ) ? array_map_R ( $func , $value ) : $func ( $value ) );
     }
    return $newArr;
   }
  else
   {
    return $func ( $arr );
   }
 }

$_POST = array_map_R ( 'strip_tags' , $_POST );
$_GET  = array_map_R ( 'strip_tags' , $_GET  );

if ( !get_magic_quotes_gpc() )
 {
	$_POST = array_map_R ( 'addslashes' , $_POST );
	$_GET  = array_map_R ( 'addslashes' , $_GET  );
 }
//------------------------------------------------------------------------------
$strLanguageFile = "";
if ( isset ( $_GET [ 'lang' ] ) || isset ( $_POST [ 'lang' ] ) )
 {
  switch ( ( isset ( $_POST [ 'lang' ] ) ? $_POST [ 'lang' ] : $_GET [ 'lang' ] ) )
   {
    case "de":    $strLanguageFile = "../language/german_setup.php";     $lang = "de";    break;
    case "en":    $strLanguageFile = "../language/english_setup.php";    $lang = "en";    break;
    case "nl":    $strLanguageFile = "../language/dutch_setup.php";      $lang = "nl";    break;
    case "it":    $strLanguageFile = "../language/italian_setup.php";    $lang = "it";    break;
    case "es":    $strLanguageFile = "../language/spanish_setup.php";    $lang = "es";    break;
    case "dk":    $strLanguageFile = "../language/danish_setup.php";     $lang = "dk";    break;
    case "fr":    $strLanguageFile = "../language/french_setup.php";     $lang = "fr";    break;
    case "tr":    $strLanguageFile = "../language/turkish_setup.php";    $lang = "tr";    break;
    case "pt":    $strLanguageFile = "../language/portuguese_setup.php"; $lang = "pt";    break;
    case "fi":    $strLanguageFile = "../language/finnish_setup.php";    $lang = "fi";    break;
    default: $strLanguageFile = "../language/german_setup.php"; $lang = "de"; // include language vars from config file
   }
 }
//-------------------------------
if ( file_exists ( $strLanguageFile ) )
 {
  include ( $strLanguageFile );
 }
else
 {
  include ( '../language/german_setup.php' ); // include language vars
  $lang = "de";
 }
//------------------------------------------------------------------------------
include ( 'config.php'             ); // include adminpassword
include ( '../func/func_crypt.php' ); // include password comparison function
//------------------------------------------------------------------------------
if ( ( !$_SESSION [ 'hidden_admin' ] ) && ( passCrypt ( $_POST [ 'password' ] ) != $adminpassword ) && ( md5 ( $_POST [ 'password' ] ) != md5 ( $adminpassword ) ) )
 {
  //------------------------------------------------------------------------------
  /* login */
  echo '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Stat - Setup</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="func/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body onload="document.login.password.focus(); document.login.password.select();">
  <div id="ground" style="width:960px">
    <div id="content">

      <div id="header" style="margin-bottom:15px; border: 1px solid #606060; -webkit-box-shadow:none; -moz-box-shadow:none; -o-box-shadow:none; box-shadow:none">
        <div class="container-fluid" style="margin-left:0; margin-right:0">
          <div class="brand">
            <a href="http://www.php-web-statistik.de" target="_blank" style="float:left; margin-right:20px"><img src="../images/system.png" alt="PHP Web Stat" title="PHP Web Stat"></a>
            <div class="brand-inline">
              <div class="brand-name">PHP Web Stat</div>
              <div class="script-ver">Version '.$version_number.$revision_number.'</div>
            </div>
          </div>
          <div class="align-left" style="margin-top:15px; margin-left:50px; font-size:20px; line-height:20px">
            <b>'.$lang_setup[1].'</b>
          </div>
          <div class="align-right" style="line-height:50px">
            <a href="https://www.php-web-statistik.de/manual/" target="new"><span class="glyphicon glyphicon-new-window"></span> Online Manual</a>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>

      <div class="sys-module" style="width:90%; margin-bottom:15px">
        <div class="sys-module-header">'.$lang_setup[2].'</div> <!-- /.sys-modul-header -->
        <div class="sys-module-content" style="padding:0 5px 3px 5px">
        '.$lang_setup[3].'
        </div> <!-- /.sys-module-content -->
      </div> <!-- /.sys-module -->

      <div id="login" style="position:relative; margin-top:40px; margin-bottom:40px">
        <div class="title">LOGIN</div>
        <div class="pic"><img src="../images/login_key.png" alt=""></div>
        <div class="info">'.$lang_login[1].'</div>
        <div class="data-input">
          <p style="margin-top:0; margin-bottom:8px">'.$lang_login[2].'</p>
          <form name="login" action="setup.php" method="post">
          <div class="form-group">
            <label class="sr-only" for="password">'.$lang_login[3].'</label>
            <div class="input-group">
              <div class="input-group-addon"><span class="glyphicon glyphicon-lock fa-lg"></span></div>
              <input type="password" name="password" id="password" class="form-control" placeholder="'.$lang_login[3].'">
              <input type="hidden" name="lang" value="'.$lang.'">
              <input type="hidden" name="step" value="check_chmod">
            </div>
          </div>
          <button type="button" class="btn btn-sm" style="float:right; margin-left:8px" onclick="window.close()">'.$lang_login[5].'</button>
          <button type="submit" class="btn btn-sm" style="float:right"><span class="glyphicon glyphicon-log-in"></span> '.$lang_login[4].'</button>
          </form>
        </div>
      </div>

    </div> <!-- /#content -->
    <div id="footer" class="text-center" style="font-size:14px; padding-top:7px">
      Copyright &copy; '.$last_edit.' <a href="https://www.php-web-statistik.de" target="_blank">PHP Web Stat</a>
    </div>
  </div> <!-- /#ground -->';
  include ( '../func/html_footer.php' ); // include html footer
  exit;
  //------------------------------------------------------------------------------
 }
else
 {
  //------------------------------------------------------------------------------
  /* if login successful */
  $_SESSION [ 'hidden_admin' ] = md5 ( time ( ) );
  $_SESSION [ 'hidden_stat'  ] = md5_file ( "config.php" );
  //------------------------------------------------------------------------------
  echo '<!DOCTYPE html>
  <html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Web Stat - Setup</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css">
    <script type="text/javascript">
     function db_transfer(){
      myleft=(screen.width)?(screen.width-470)/2:100;mytop=(screen.height)?(screen.height-320)/2:100;
      settings="width=440,height=260,top=" + mytop + ",left=" + myleft + ",scrollbars=no,location=no,directories=no,status=yes,menubar=no,toolbar=no,resizable=no,dependent=yes";
      win=window.open("db_transfer.php?lang='.$lang.'","import",settings);
      win.focus();
     }
    </script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="func/html5shiv.js"></script>
    <![endif]-->
  </head>
  <body>
  <div id="ground" style="width:960px">
  <div id="content">

  <div id="header" style="margin-bottom:15px; border: 1px solid #606060; -webkit-box-shadow:none; -moz-box-shadow:none; -o-box-shadow:none; box-shadow:none">
    <div class="container-fluid" style="margin-left:0; margin-right:0">
      <div class="brand">
        <a href="http://www.php-web-statistik.de" target="_blank" style="float:left; margin-right:20px"><img src="../images/system.png" alt="PHP Web Stat" title="PHP Web Stat"></a>
        <div class="brand-inline">
          <div class="brand-name">PHP Web Stat</div>
          <div class="script-ver">Version '.$version_number.$revision_number.'</div>
        </div>
      </div>
      <div class="align-left" style="margin-top:15px; margin-left:50px; font-size:20px; line-height:20px">
        <b>'.$lang_setup[1].'</b>
      </div>
      <div class="align-right" style="line-height:50px">
        <a href="https://www.php-web-statistik.de/manual/" target="new"><span class="glyphicon glyphicon-new-window"></span> Online Manual</a>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>';
  //------------------------------------------------------------------------------
  if ( ( !isset ( $_GET [ 'step' ] ) ) && ( $_GET [ 'step' ] != "admincenter_database" ) )
   {
    if ( ( !isset ( $_POST [ 'step' ] ) ) || ( $_POST [ 'step' ] != "admincenter_database" ) )
     {
      if ( ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'check_chmod' ) || ( !isset ( $_POST [ 'step' ] ) ) )
       {
        // check chmod
        echo '
        <form action="setup.php" method="post">
        <div class="sys-module" style="width:90%; margin-bottom:15px">
          <div class="sys-module-header">'.$lang_setup[2].'</div>
          <div class="sys-module-content" style="padding:0 5px 3px 5px">
          '.$lang_setup[3].'
          </div> <!-- /.sys-module-content -->
        </div> <!-- /.sys-module -->

        <div class="sys-module" style="width:90%; margin-bottom:10px">
          <div class="sys-module-header">'.$lang_chmod[1].'</div>
          <div class="sys-module-content" style="padding:0 5px 3px 5px">';
          if (
              // config folder
              ( ( decoct ( fileperms ( "config.php"                ) ) == 100666 ) || ( decoct ( fileperms ( "config.php"                ) ) == 100660 ) ) &&
              ( ( decoct ( fileperms ( "config_db.php"             ) ) == 100666 ) || ( decoct ( fileperms ( "config_db.php"             ) ) == 100660 ) ) &&
              // log folder
              ( ( decoct ( fileperms ( "../log/"                   ) ) == 40777  ) || ( decoct ( fileperms ( "../log/" ) ) == 40775 ) || ( decoct ( fileperms ( "../log/" ) ) == 40770 ) ) &&
              ( ( decoct ( fileperms ( "../log/cache_visitors.php" ) ) == 100666 ) || ( decoct ( fileperms ( "../log/cache_visitors.php" ) ) == 100660 ) ) &&
              ( ( decoct ( fileperms ( "../log/logdb.dta"          ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb.dta"          ) ) == 100660 ) ) &&
              ( ( decoct ( fileperms ( "../log/logdb_backup.dta"   ) ) == 100666 ) || ( decoct ( fileperms ( "../log/logdb_backup.dta"   ) ) == 100660 ) )
             )
           {
            if ( is_writable ( 'pattern_string_replace.inc' ) === TRUE )
             {
              echo '
              <img src="../images/admin/done.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b>'.$lang_chmod[2].'</b><br>
              '.$lang_chmod[3].' '.$lang_chmod[4].'<br>
              <input type="hidden" name="lang" value="'.$lang.'">
              <input type="hidden" name="step" value="choose">
              <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
              <button type="submit" class="btn btn-sm" style="float:right; margin:0 5px 7px 0">'.$lang_footer[1].'</button>
              <div class="clearfix"></div>';
             }
            else
             {
              echo '
              <img src="../images/admin/error.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b><font color="#c40000">'.$lang_chmod[5].'</font></b><br>
              '.$lang_chmod[6].'<br><br>'.$lang_chmod[7].'<br><br>'.$lang_chmod[8].'<br>
              <input type="hidden" name="lang" value="'.$lang.'">
              <input type="hidden" name="step" value="choose">
              <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
              <button type="submit" class="btn btn-sm" style="float:right; margin:0 5px 7px 0">'.$lang_footer[1].'</button>
              <button type="button" class="btn btn-sm" style="float:right; margin-right:10px" onclick="location.href=\''.$_SERVER[ 'PHP_SELF' ].'?lang='.$lang.'\'">'.$lang_footer[2].'</button>
              <div class="clearfix"></div>';
             }
           }
          else
           {
            echo '
            <img src="../images/admin/error.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b><font color="#c40000">'.$lang_chmod[5].'</font></b><br>
            '.$lang_chmod[6].'<br><br>'.$lang_chmod[7].'<br><br>'.$lang_chmod[8].'<br>
            <input type="hidden" name="lang" value="'.$lang.'">
            <input type="hidden" name="step" value="choose">
            <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
            <button type="submit" class="btn btn-sm" style="float:right; margin:0 5px 7px 0">'.$lang_footer[1].'</button>
            <button type="button" class="btn btn-sm" style="float:right; margin-right:10px" onclick="location.href=\''.$_SERVER[ 'PHP_SELF' ].'?lang='.$lang.'\'">'.$lang_footer[2].'</button>
            <div class="clearfix"></div>';
           }
        echo '</div> <!-- /.sys-module-content -->
        </div> <!-- /.sys-module -->
        </form>';
       }
     }
   }
  //------------------------------------------------------------------------------
  if ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'choose' )
   {
    // choose
    echo '
    <form action="setup.php" method="post">
    <div class="sys-module" style="width:90%; margin-bottom:10px">
      <div class="sys-module-header">'.$lang_choose[1].'</div>
      <div class="sys-module-content">
        <table class="sys-table" style="font-size:12px">
        <tr>
          <td class="sys-info" style="width:50%">'.$lang_choose[2].'<br><div class="small">'.$lang_choose[3].'<br><br>'.$lang_choose[4].'<br><br>'.$lang_choose[5].'<br><br></div></td>
          <td class="sys-result" style="width:50%; vertical-align:top">
          <select name="step" size="1" style="width:250px; margin-top:5px">
           <option value="admincenter_textfile">'.$lang_choose[6].'</option>
           <option value="connection">'.$lang_choose[7].'</option>
          </select>
          <input type="hidden" name="lang" value="'.$lang.'">
          <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
          </td>
        </tr>
        </table>
        <button type="submit" class="btn btn-sm" style="float:right; margin:10px">'.$lang_footer[1].'</button>
        <div class="clearfix"></div>
      </div> <!-- /.sys-module-content -->
    </div> <!-- /.sys-module -->
    </form>';
   }
  //------------------------------------------------------------------------------
  if ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'admincenter_textfile' )
   {
    $counter = 0;
    $file_save = file ( "config.php" );
    $config_file = fopen ( "config.php" , "r+" );
    flock ( $config_file , LOCK_EX );
     ftruncate ( $config_file , 0 );
     foreach ( $file_save as $key => $value )
      {
       if ( $counter == 4 )
        {
         fwrite ( $config_file , " \$db_active                   = 0;\n" );
        }
       else
        {
         fwrite ( $config_file , $value );
        }
       $counter++;
      }
    flock ( $config_file , LOCK_UN );
    fclose ( $config_file );

    // goadmin
    echo '
    <img src="../images/admin/done.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b>'.$lang_goadmin[1].'</b><br><br>
    '.$lang_goadmin[2].'<br><br>'.$lang_goadmin[3].'<br><br>
    <button type="button" class="btn btn-sm" style="float:right; margin:0 5px 0 0" onclick="location.href=\'admin.php?action=settings&lang='.$lang.'\'">'.$lang_footer[1].'</button>
    <div class="clearfix"></div>';
   }
  //------------------------------------------------------------------------------
  if ( ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'admincenter_database' ) || ( isset ( $_GET [ 'step' ] ) && $_GET [ 'step' ] == 'admincenter_database' ) )
   {
    // goadmin
    echo '
    <img src="../images/admin/done.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b>'.$lang_goadmin[1].'</b><br><br>
    '.$lang_goadmin[2].'<br><br>'.$lang_goadmin[3].'<br><br>
    <button type="button" class="btn btn-sm" style="float:right; margin:0 5px 0 0" onclick="location.href=\'admin.php?action=settings&lang='.$lang.'\'">'.$lang_footer[1].'</button>
    <div class="clearfix"></div>';
   }
  //------------------------------------------------------------------------------
  if  ( ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'connection' ) || ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'connection_save' ) )
   {
    if ( $_POST [ 'step' ] == 'connection_save' )
     {
      $config_file_db = fopen ( "config_db.php" , "r+" );
      flock ( $config_file_db , LOCK_EX );
       ftruncate ( $config_file_db , 0 );
       fwrite ( $config_file_db , "<?php\n" );

       fwrite ( $config_file_db , "\n/* database connection */\n" );
       fwrite ( $config_file_db , " \$db_host     = \"".$_POST [ 'db_host' ]."\";\n" );
       fwrite ( $config_file_db , " \$db_name     = \"".$_POST [ 'db_name' ]."\";\n" );
       fwrite ( $config_file_db , " \$db_user     = \"".$_POST [ 'db_user' ]."\";\n" );
       fwrite ( $config_file_db , " \$db_password = \"".$_POST [ 'db_password' ]."\";\n" );

       fwrite ( $config_file_db , "\n/* database settings */\n" );
       fwrite ( $config_file_db , " \$db_prefix   = \"".$_POST [ 'db_prefix' ]."\";\n" );

       fwrite ( $config_file_db , "\n?>" );
      flock ( $config_file_db , LOCK_UN );
      fclose ( $config_file_db );
     }
    // ---------------------------------------------------------------------------
    // connection
    include ( 'config_db.php' );
    echo '
    <form name="db_connection" action="setup.php" method="post">
    <div class="sys-module" style="width:90%; margin-bottom:10px">
      <div class="sys-module-header">'.$lang_db_connect[2].'</div>
      <div class="sys-module-content">
      <table class="sys-table">
      <tr>
        <td class="sys-info" style="width:50%">'.$lang_db_connect[3].'<br><div class="small">'.$lang_db_connect[4].'</div></td>
        <td class="sys-result" style="width:50%"><input type="text" name="db_host" size="40" value="'.$db_host.'" style="width:95%"></td>
      </tr>
      <tr>
        <td class="sys-info">'.$lang_db_connect[5].'<br><div class="small">'.$lang_db_connect[6].'</div></td>
        <td class="sys-result"><input type="text" name="db_name" size="40" value="'.$db_name.'" style="width:95%"></td>
      </tr>
      <tr>
        <td class="sys-info">'.$lang_db_connect[7].'<br><div class="small">'.$lang_db_connect[8].'</div></td>
        <td class="sys-result"><input type="text" name="db_user" size="40" value="'.$db_user.'" style="width:95%"></td>
      </tr>
      <tr>
        <td class="sys-info">'.$lang_db_connect[9].'<br><div class="small">'.$lang_db_connect[10].'</div></td>
        <td class="sys-result"><input type="password" name="db_password" size="40" value="'.$db_password.'" style="width:95%"></td>
      </tr>
      </table>
      </div> <!-- /.sys-module-content -->
    </div> <!-- /.sys-module -->

    <div class="sys-module" style="width:90%; margin-bottom:10px">
      <div class="sys-module-header">'.$lang_db_connect[1].'</div>
      <div class="sys-module-content">
      <table class="sys-table">
      <tr>
        <td class="sys-info" style="width:50%">'.$lang_db_prefix[1].'<br><div class="small">'.$lang_db_prefix[2].'<br><br></div></td>
        <td class="sys-result" style="width:50%"><input type="text" name="db_prefix" size="40" value="'.$db_prefix.'" style="width:95%;"></td>
      </tr>';
      // -------------------------------------------------------------------------
      /* check to exists the db_tables */
      $connection_error = 1;
      //--------------------------------------------------------------------------
      $dirname  = "config";
      $filename = "setup";
      include ( '../func/func_db_connect.php' );
      // -------------------------------------------------------------------------
      if ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'connection_save' )
       {
        $query        = "SHOW TABLES LIKE '".$db_prefix."_main'";
        $result       = db_query ( $query , 1 , 0 );
        $table_exists = count ( $result );

        if ( $connection_error == 5 )
         { }
        else
         {
          if ( $table_exists == 0 )
           {
            echo '<tr><td colspan="2" style="padding:10px 10px 10px 20px; background-color:transparent; color:#c40000; font-size:14px"><img src="../images/alert.gif" style="margin:0px 20px 0px 0px" alt=""><b>'.$lang_db_prefix[3].'</b><br><br>'.$lang_db_prefix[4].'<button type="button" class="btn btn-sm" style="float:right" onclick="db_transfer();">'.$lang_db_prefix[5].'</button><div class="clearfix"></div></td></tr>';
           }
         }
       }
      // -------------------------------------------------------------------------
      echo '</table>
      </div> <!-- /.sys-module-content -->
    </div> <!-- /.sys-module -->';
    // ---------------------------------------------------------------------------
    if ( isset ( $_POST [ 'step' ] ) && $_POST [ 'step' ] == 'connection_save' )
     {
      $counter = 0;
      $file_save = file ( "config.php" );
      $config_file = fopen ( "config.php" , "r+" );
      flock ( $config_file , LOCK_EX );
       ftruncate ( $config_file , 0 );
       foreach ( $file_save as $key => $value )
        {
         if ( $counter == 4 )
          {
           fwrite ( $config_file , " \$db_active                   = 1;\n" );
          }
         else
          {
           fwrite ( $config_file , $value );
          }
         $counter++;
        }
      flock ( $config_file , LOCK_UN );
      fclose ( $config_file );
      $_SESSION [ 'hidden_func' ] = md5_file ( "config.php" );
      if ( $connection_error == 5 )
       {
        echo'
        <div style="width:90%; margin:0 auto; padding:0 5px 5px 5px; border:1px solid #a1a1a1; color:#c40000; background-color:#ffffeb">
        <img src="../images/admin/error.png" style="vertical-align:middle; margin:5px 15px 5px 0px" alt=""><b>'.$lang_db_connect[13].'</b><br><br>
        '.$lang_db_connect[14].'
        </div>
        <input type="hidden" name="step" value="connection_save">
        <input type="hidden" name="lang" value="'.$lang.'">
        <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
        <button type="submit" class="btn btn-sm" style="float:right; margin:10px 5px 0 0">'.$lang_db_connect[12].'</button>
        <div class="clearfix"></div>';
       }
      else
       {
        if ( $table_exists == 1 )
         {
          echo '
          <div style="width:90%; margin:0 auto; color:#c40000"><b>'.$lang_db_connect[11].'</b></div>
          <input type="hidden" name="step" value="admincenter_database">
          <input type="hidden" name="lang" value="'.$lang.'">
          <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
          <button type="submit" class="btn btn-sm" style="float:right; margin:0 5px 0 0">'.$lang_footer[1].'</button>
          <div class="clearfix"></div>';
         }
       }
     }
    else
     {
      echo '
      <input type="hidden" name="step" value="connection_save">
      <input type="hidden" name="lang" value="'.$lang.'">
      <input type="hidden" name="hidden_admin" value="'.$_SESSION [ 'hidden_admin' ].'">
      <input type="hidden" name="hidden_func" value="'.$_SESSION [ 'hidden_func' ].'">
      <button type="submit" class="btn btn-sm" style="float:right; margin:0 5px 0 0">'.$lang_db_connect[12].'</button>
      <div class="clearfix"></div>';
     }
    // ---------------------------------------------------------------------------
    echo '
    </form>';
   }
  //------------------------------------------------------------------------------
  echo '
  </div> <!-- /#content -->
  <div id="footer" class="text-center" style="font-size:14px; padding-top:7px">
    Copyright &copy; '.$last_edit.' <a href="http://www.php-web-statistik.de" target="_blank">PHP Web Stat</a>
  </div>
  </div> <!-- /#ground -->';
 }
//------------------------------------------------------------------------------
include ( '../func/html_footer.php' ); // include html footer
//------------------------------------------------------------------------------
?>
