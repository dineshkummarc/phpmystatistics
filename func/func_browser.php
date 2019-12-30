<?php
################################################################################
#                           P H P - W E B - S T A T                            #
################################################################################
# This file is part of php-web-stat.                                           #
# Open-Source Statistic Software for Webmasters                                #
# Script-Version:     5.0                                                      #
# File-Release-Date:  18/06/23                                                 #
# Official web site and latest version:    http://www.php-web-statistik.de     #
#==============================================================================#
# Authors: Holger Naves, Reimar Hoven                                          #
# Copyright © 2018 by PHP Web Stat - All Rights Reserved.                      #
################################################################################

//------------------------------------------------------------------------------
function browser_detection ( $browser_search )
{
 //--------------------------------
 $browser_patterns = array
  (
   //--------------------------------------------------------------------------------------------------
   "(firefox).(([0-9]{1,2}\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                   => "Firefox",
   "(Opera\/9.80.+Version).([0-9]{1,2}\.[0-9]{1,3})"                        => "Opera",
   "(opera).([0-9]{1,2}\.[0-9]{1,3})"                                       => "Opera",
   "(opera).([0-9]{1,2}\.[0-9x]{1,3})"                                      => "Opera23",
   "(Edge).([0-9]{1,3}\.[0-9]{1,4})"                                        => "Edge",
   "(ChromePlus).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,3})?)" => "ChromePlus",
   "(Chrome).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?(\.[0-9]{1,4})?)"     => "Google Chrome",
   "(Version).([0-9]{1,2}\.[0-9]{1,3}?(\.[0-9]{1,3})?).+(safari)"           => "Safari",
   "(safari).([0-9]{1,3}(\.[0-9]{1,3})?)"                                   => "Safari",
   //--------------------------------------------------------------------------------------------------
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+(crazy browser)"                       => "IE CrazyBrowser",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+slimBrowser"                           => "IE SlimBrowser",
   "(msie).([0-9]{1,2}\.[0-9]{1,2}).+(maxthon|myie2)"                       => "IE Maxthon",
   "(Trident).+rv:([0-9]{1,2}\.[0-9]{1,2})"                                 => "Internet Explorer",
   "(msie) ([0-9]{1,2}\.[0-9]{1,2})"                                        => "Internet Explorer",
   //--------------------------------------------------------------------------------------------------
   "(seamonkey).([0-9]{1,3}(\.[0-9]{1,3})?)"                                => "Mozilla SeaMonkey",
   "(epiphany).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                  => "Mozilla Epiphany",
   "(Mnenhy).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                    => "Mozilla Mnenhy",
   "(mozilla).+rv:([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"               => "Mozilla",
   //--------------------------------------------------------------------------------------------------
   "(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})"                             => "Java",
   "(NetPositive)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "NetPositive",
   "(PHP)\/([0-9]{1,2}\.[0-9]{1,2})"                                        => "PHP",
   "(WebWasher)([0-9]{1,2}\.[0-9]{1,2})"                                    => "WebWasher",
   "(konqueror).([0-9]{1,2}(\.[0-9])?)"                                     => "Konqueror",
   "(lynx)"                                                                 => "Lynx",
   "(mosaic)"                                                               => "Mosaic",
   "(links).*([0-9]{1,2}\.[0-9]{1,2})"                                      => "Links",
   "(OffByOne)"                                                             => "OffByOne",
   "(ELinks)"                                                               => "ELinks",
   "(teleport pro)\/([0-9\.]{1,9})"                                         => "Teleport Pro",
   "(Amiga-AWeb)\/([0-9 ]{1}\.[0-9]{1,2}\.[0-9]{1,4})"                      => "Amiga-AWeb",
   "(amigavoyager)\/([0-9]{1}\.[0-9]{1,2}\.[0-9]{1,4})"                     => "AmigaVoyager",
   "(AvantGo)([0-9]{1}\.[0-9]{1,2})"                                        => "AvantGo",
   "(AvantGo)([0-9]{1}\.[0-9]{1,2})"                                        => "BrowserEmulator",
   "(cosmos)\/([0-9]{1,2}\.[0-9]{1,3})"                                     => "Cosmos",
   "(da)([0-9]{1,2}\.[0-9]{1,3})"                                           => "Download Accelerator",
   "(flashget)"                                                             => "FlashGet",
   "(GetRight)\/([0-9]{1,2}\.[0-9b]{1,3})"                                  => "GetRight",
   "(gigabaz)\/([0-9]{1,2}\.[0-9]{1,3})"                                    => "GigaBaz",
   "(ibrowse)\/([0-9]{1,2}\.[0-9]{1,3})"                                    => "IBrowser",
   "(ICS) ([0-9]{1,2}\.[0-9]{1,3}\.[0-9]{1,3})"                             => "ICS",
   "(lwp-trivial)\/([0-9]{1,2}\.[0-9]{1,3})"                                => "lpw-trivial",
   "(msproxy)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "MSProxy",
   "(NetAnts)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "NetAnts",
   "(offline explorer)\/([0-9]{1,2}\.[0-9]{0,3})"                           => "Offline Explorer",
   "(Penetrator)([0-9]{1,2}\.[0-9]{0,3})"                                   => "Penetrator",
   "(planetweb)\/([0-9]{1,2}\.[0-9ab]{0,4})"                                => "Planetweb",
   "(PowerNet)\/([0-9]{1,2}\.[0-9]{0,4})"                                   => "PowerNet",
   "(Rotondo)\/([0-9]{1,2}\.[0-9]{0,3})"                                    => "Rotondo",
   "(UP\.Browser)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "UP.Browser",
   "(w3m)"                                                                  => "W3M",
   "(WebCapture)([0-9]{1,2}\.[0-9]{0,3})"                                   => "WebCapture",
   "(WebCopier v)([0-9]{1,2}\.[0-9]{0,3})"                                  => "WebCopier",
   "(webcollage)\/([0-9]{1,2}\.[0-9]{0,3})"                                 => "Webcollage",
   "(WebScrape)\/([0-9]{1,2}\.[0-9]{0,3})"                                  => "WebScrape",
   "(web downloader)(\/[0-9]{1,2}\.[0-9]{0,1})"                             => "Web Downloader",
   "(mas downloader)(\/[0-9]{1,2}\.[0-9]{0,1})"                             => "Web Downloader",
   "(webstripper)\/([0-9]{1,2}\.[0-9]{0,3})"                                => "WebStripper",
   "(WebZIP)\/([0-9]{1,2}\.[0-9]{0,3})"                                     => "WebZIP",
   "(webtv)"                                                                => "WebTv",
   "(Wget)\/([0-9]{1,2}\.[0-9]{0,3})"                                       => "WGet",
   "(Dillo).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)"                     => "Dillo",
   //--------------------------------------------------------------------------------------------------
   "(^BlackBerry).*\/([0-9.]{1,10})"                                        => "Blackberry",
   "(BrowseX).*\/([0-9.]{1,10})"                                            => "BrowseX",
   "(Dolfin)\/([0-9.]{1,10})"                                               => "Dolfin",
   "(Fennec)\/([0-9.a-z]{1,10})"                                            => "Fennec",
   "(Fluid)\/([0-9.]{1,10})"                                                => "Fluid",
   "(IceCat)\/([0-9a-z.]{1,10})"                                            => "IceCat",
   "(^iPeng).*(iPhone|iPad)\/([0-9.]{1,10})"                                => "iPeng",
   "(Iron)\/([0-9.]{1,10})"                                                 => "Iron",
   "(Kylo)\/([0-9.]{1,10})"                                                 => "Kylo",
   "(midori)\/([0-9.]{1,10})"                                               => "midori",
   "(Miro)\/([0-9.]{1,10})"                                                 => "Miro",
   "(Plainview)\/([0-9.]{1,10})"                                            => "Plainview",
   "(Reeder)\/([0-9.+]{1,10})"                                              => "Reeder",
   "(Smart Bro)\/?([0-9.]{1,10})?"                                          => "Smart Bro",
   "(Stainless)\/([0-9.]{1,10})"                                            => "Stainless",
   "(Thunderbird)\/([0-9a-z.]{1,10})"                                       => "Thunderbird",
   "Uzbl"                                                                   => "Uzbl",
   "(AppleWebKit)\/([0-9.]{1,10}).*Gecko"                                   => "AppleWebKit",
   "(Wyzo)\/([0-9.]{1,10})"                                                 => "Wyzo",
   //--------------------------------------------------------------------------------------------------
   "msnbot"                                                                 => "MSN Bot",
   "googlebot"                                                              => "Google Bot",
   "mediapartners-google"                                                   => "Google Adsense",
   "inktomi"                                                                => "Yahoo Inktomi Bot",
   "slurp"                                                                  => "Yahoo Slurp Bot",
   "baiduspider"                                                            => "Robot",
   "job crawler"                                                            => "Robot",
   "analyzer"                                                               => "Robot",
   "arachnofilia"                                                           => "Robot",
   "aspseek"                                                                => "Robot",
   "bot"                                                                    => "Robot",
   "check"                                                                  => "Robot",
   "crawl"                                                                  => "Robot",
   "infoseek"                                                               => "Robot",
   "netoskop"                                                               => "Robot",
   "NetSprint"                                                              => "Robot",
   "openfind"                                                               => "Robot",
   "roamer"                                                                 => "Robot",
   "robot"                                                                  => "Robot",
   "rover"                                                                  => "Robot",
   "scooter"                                                                => "Robot",
   "search"                                                                 => "Robot",
   "siphon"                                                                 => "Robot",
   "spider"                                                                 => "Robot",
   "sweep"                                                                  => "Robot",
   "walker"                                                                 => "Robot",
   "WebStripper"                                                            => "Robot",
   "wisenutbot"                                                             => "Robot",
   "gulliver"                                                               => "Robot",
   "validator"                                                              => "Robot",
   "yandex"                                                                 => "Robot",
   "ask jeeves"                                                             => "Robot",
   "moget@"                                                                 => "Robot",
   "teomaagent"                                                             => "Robot",
   "infoNavirobot"                                                          => "Robot",
   "PPhpDig"                                                                => "Robot",
   "gigabaz"                                                                => "Robot",
   "Webclipping\.com"                                                       => "Robot",
   "RRC"                                                                    => "Robot",
   "netmechanic"                                                            => "Robot"
   //--------------------------------------------------------------------------------------------------
  );
  //--------------------------------
  $browser = "";
  //--------------------------------
  foreach ( $browser_patterns as $browser_pattern => $browser_name )
   {
    //--------------------------------
    if ( preg_match ( "/".$browser_pattern."/i" , $browser_search , $name ) )
     {
      //--------------------------------
      $browser = @$browser_name." ".@$name [ 2 ];
      break;
      //--------------------------------
     }
    //--------------------------------
   }
  return trim ( $browser );
  //--------------------------------
 }
//------------------------------------------------------------------------------
?>