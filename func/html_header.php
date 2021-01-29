<?php if ( !isset ( $_SERVER [ 'PHP_SELF' ] ) || basename ( $_SERVER [ 'PHP_SELF' ] ) == basename (__FILE__) ) { $error_path = '../'; include ( 'func_error.php' ); exit; };
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.3                                                      #
# File-Release-Date:  21/01/01                                                 #
# Official web site and latest version:    https://www.php-web-statistik.de    #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2021 by PHP Web Stat - All Rights Reserved.                      #
################################################################################
error_reporting(0);
//------------------------------------------------------------------------------
// auto detect html language
    if ( $language == 'language/german.php'     ) { $html_lang = 'lang="de"'; $lang = 'de'; }
elseif ( $language == 'language/english.php'    ) { $html_lang = 'lang="en"'; $lang = 'en'; }
elseif ( $language == 'language/dutch.php'      ) { $html_lang = 'lang="nl"'; $lang = 'nl'; }
elseif ( $language == 'language/italian.php'    ) { $html_lang = 'lang="it"'; $lang = 'it'; }
elseif ( $language == 'language/spanish.php'    ) { $html_lang = 'lang="es"'; $lang = 'es'; }
elseif ( $language == 'language/danish.php'     ) { $html_lang = 'lang="dk"'; $lang = 'dk'; }
elseif ( $language == 'language/finnish.php'    ) { $html_lang = 'lang="fi"'; $lang = 'fi'; }
elseif ( $language == 'language/french.php'     ) { $html_lang = 'lang="fr"'; $lang = 'fr'; }
elseif ( $language == 'language/turkish.php'    ) { $html_lang = 'lang="tr"'; $lang = 'tr'; }
elseif ( $language == 'language/portuguese.php' ) { $html_lang = 'lang="pt"'; $lang = 'pt'; }
else   { $html_lang = 'lang="en"'; $lang = 'en'; }
//------------------------------------------------------------------------------
// calendar language
if ( $language == 'language/german.php' ) { $calendar_lang = 'de'; } else { $calendar_lang = 'en'; }
//------------------------------------------------------------------------------
// set version number, revision number & theme to zero
if ( !isset ( $version_number  ) ) { $version_number = null;  }
if ( !isset ( $revision_number ) ) { $revision_number = null; }
if ( !isset ( $theme           ) ) { $theme = null;           }
//------------------------------------------------------------------------------
// HTML Header (index)
if ( ( $loginpassword_ask == 1 ) && ( $autologout == 1 ) )
 {
  $logout_time = $autologout_time * 60;
  $logout_meta = "\n  <meta http-equiv=\"refresh\" content=\"".$logout_time."; url=index.php?parameter=autologout\">";
 }

$html_header_in = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">'.$logout_meta.'
  <title>PHP Web Stat '.$version_number.$revision_number.'</title>
  <meta name="title" content="PHP Web Stat '.$version_number.$revision_number.'">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'style.css?ver='.time().'">
  <link rel="stylesheet" type="text/css" href="css/print.css">
  <link rel="stylesheet" type="text/css" href="func/floatbox/floatbox.css">
  <link rel="shortcut icon" href="images/favicon.ico">
  <script src="js/win_open.js"></script>
  <script src="js/toggle_tab.js"></script>
  <script src="func/floatbox/floatbox.js"></script>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
</head>
<body id="body-index">
';
//------------------------------------------------------------------------------
// HTML Header (counter)
$html_header_co = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Counter '.$version_number.'</title>
  <meta name="title" content="PHP Web Stat - Counter '.$version_number.'">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'counter.css?ver='.time().'">
  <link rel="shortcut icon" href="images/favicon.ico">
  <script src="js/ticker.js">
    /*
    Text and/or Image Crawler Script &copy; 2009 John Davenport Scheuer
    as first seen in http://www.dynamicdrive.com/forums/ username: jscheuer1
    This Notice Must Remain for Legal Use
    */
  </script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (archive)
$html_header_ar = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat Archive</title>
  <meta name="title" content="PHP Web Stat Archive">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'style.css?ver='.time().'">
  <link rel="stylesheet" type="text/css" href="func/calendar/css/jscal2.css">
  <link rel="stylesheet" type="text/css" href="func/calendar/css/border-radius.css">
  <link rel="stylesheet" type="text/css" href="func/calendar/css/steel/steel.css">
  <script src="js/win_open.js"></script>
  <script src="func/calendar/js/jscal2.js"></script>
  <script src="func/calendar/js/lang/'.$calendar_lang.'.js"></script>
  <style type="text/css">
    body { margin:0; }
  </style>
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (detail_view)
$html_header_dv = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Details</title>
  <meta name="title" content="PHP Web Stat">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'style.css?ver='.time().'">
  <link rel="stylesheet" type="text/css" href="css/print.css">
  <style>
    body { margin:5px; }
  </style>
  <script src="js/table_sort_dv.js"></script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (cookie)
$html_header_ck = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat</title>
  <meta name="title" content="PHP Web Stat">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'style.css?ver='.time().'">
  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
  <![endif]-->
</head>
<body onload="document.login.password.focus(); document.login.password.select();">
';
//------------------------------------------------------------------------------
// HTML Header (sysinfo)
$html_header_si = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Sysinfo</title>
  <meta name="title" content="PHP Web Stat - Sysinfo">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <link rel="stylesheet" type="text/css" href="'.$theme.'style.css?ver='.time().'">
  <link rel="stylesheet" type="text/css" href="css/print.css">
  <link rel="stylesheet" type="text/css" href="func/floatbox/floatbox.css">
  <link rel="shortcut icon" href="images/favicon.ico">
  <script src="func/floatbox/floatbox.js"></script>
</head>
<body id="body-sysinfo">
';
//------------------------------------------------------------------------------
// HTML Header (admin)
$html_header_ad1 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>PHP Web Stat - Admin Center</title>
  <meta name="title" content="PHP Web Stat - Admin-Center" />
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="expires" content="0" />
  <link rel="stylesheet" type="text/css" href="../css/style.css" />
  <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css?ver='.time().'" />
  <link rel="shortcut icon" href="images/favicon.ico" />
  <!--[if lt IE 7]>
   <script type="text/javascript" src="../js/unitpngfix.js"></script>
  <![endif]-->
</head>
<body onload="document.login.password.focus(); document.login.password.select();">
';
//------------------------------------------------------------------------------
// HTML Header (cache_panel)
$html_header_ad2 = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat - Cache Panel</title>
  <meta name="title" content="PHP Web Stat - Cache Panel">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css?ver='.time().'">
  <link rel="shortcut icon" href="../images/favicon.ico">
  <style>
    body { margin:0px; }
  </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (db_transfer)
$html_header_ad3 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>PHP Web Stat</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="expires" content="0">
  <link rel="stylesheet" type="text/css" href="../'.$theme.'style.css?ver='.time().'">
  <style type="text/css">
    body { background: #808080 url(../images/admin/bg_transfer.gif) center center no-repeat; background-attachment:fixed; margin:0px; }
  </style>
  <script type="text/javascript">
    function db_transfer_finished(){
      window.close();
      opener.location.href="setup.php?step=admincenter_database&lang='.$lang.'";
    }
  </script>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (backup , delete_archive , delete_backup , delete_index , edit_css , edit_site_name , edit_string_replace , file_version , repair , reset , func_last_logins_sho)
$html_header_ad4 = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <title>PHP Web Stat</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
  <style type="text/css">
    body { margin:0px; }
  </style>
</head>
<body>
';
//------------------------------------------------------------------------------
// HTML Header (syscheck)
$html_header_ad5 = '<!DOCTYPE html>
<html '.$html_lang.'>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Web Stat</title>
  <meta name="title" content="PHP Web Stat">
  <link rel="stylesheet" type="text/css" href="../css/style.css">
  <link rel="stylesheet" type="text/css" href="../css/admin.css">
  <style>
    body { margin:0px; }
  </style>
</head>
<body>
';
//------------------------------------------------------------------------------
$file_name = pathinfo ( $_SERVER [ 'PHP_SELF' ] );
//------------------------------------------------------------------------------
// main directory
if ( $file_name [ "basename" ] == "index.php"               ) { echo $html_header_in; }
if ( $file_name [ "basename" ] == "counter.php"             ) { echo $html_header_co; }
if ( $file_name [ "basename" ] == "archive.php"             ) { echo $html_header_ar; }
if ( $file_name [ "basename" ] == "detail_view.php"         ) { echo $html_header_dv; }
if ( $file_name [ "basename" ] == "cookie.php"              ) { echo $html_header_ck; }
if ( $file_name [ "basename" ] == "sysinfo.php"             ) { echo $html_header_si; }
//------------------------------------------------------------------------------
// folder config
if ( $file_name [ "basename" ] == "setup.php"               ) { echo $html_header_ad1; }
if ( $file_name [ "basename" ] == "admin.php"               ) { echo $html_header_ad1; }
if ( $file_name [ "basename" ] == "cache_panel.php"         ) { echo $html_header_ad2; }
if ( $file_name [ "basename" ] == "db_transfer.php"         ) { echo $html_header_ad3; }
if ( $file_name [ "basename" ] == "backup.php"              ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "delete_archive.php"      ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "delete_backup.php"       ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "delete_index.php"        ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "edit_css.php"            ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "edit_site_name.php"      ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "edit_string_replace.php" ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "file_version.php"        ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "repair.php"              ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "reset.php"               ) { echo $html_header_ad4; }
//------------------------------------------------------------------------------
// folder func
if ( $file_name [ "basename" ] == "func_last_logins_show.php" ) { echo $html_header_ad4; }
if ( $file_name [ "basename" ] == "syscheck.php"              ) { echo $html_header_ad5; }
//------------------------------------------------------------------------------
?>