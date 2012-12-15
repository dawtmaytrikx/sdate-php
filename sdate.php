#!/usr/bin/php
<?php
/*
 * This script will convert gregorian dates into Shire Reckoning.
 * Written by dawt on Sterday, the 25th day of Foreyule in the year 7472, by Shire Reckoning.
 * 
 * License: CC-BY-NC (http://creativecommons.org/licenses/by-nc/3.0/)
 */ 
function ordinal_suffix($number) { //thx to http://stackoverflow.com/users/349620/iacopo
    $ends = array('th','st','nd','rd','th','th','th','th','th','th');
    if (($number % 100) >= 11 && ($number % 100) <= 13) { return $number.'th'; }
    else { return $number.$ends[$number % 10]; }
}

function sdate() {
    $wdays = array('Sterday', 'Sunday', 'Monday', 'Trewsday', 'Hevensday', 'Mersday', 'Highday');
    $months = array('Afteryule', 'Solmath', 'Rethe', 'Astron', 'Thrimidge', 'Forelithe', 'Afterlithe', 'Wedmath', 'Halimath', 'Winterfilth', 'Blotmath', 'Foreyule');
    $holidays = array('Yule', 'Lithe', 'Mid-year\'s day', 'Overlithe');
    
    $time = time();
    #$time = mktime(1,1,1,6,21,2011); //for debugging
    $daynum = date('z', $time) + 10;
    
    if (date('L', $time)) {
        if ($daynum > 182) {
            $leap = 1;
            if ($daynum == 183) {
                $holiday = $holidays[3];
                $shd = 1;
            }
            $daynum--;
        }
    }
    if ($daynum > 364) { $daynum -= 365; }
    
    $wdaynum = $daynum;
    if (($daynum > 182) && ($leap = 1)) $wdaynum--;
    $wday = $wdays[$wdaynum % 7];
    
    $mdaynum = $daynum;
    if ($daynum > 0) $mdaynum--;
    if ($daynum > 181) $mdaynum--;
    if (($daynum > 182) && ($leap = 1)) $mdaynum--;
    if ($daynum > 183) $mdaynum--;
    
    $mday = $mdaynum % 30 + 1;
    
    $year = date('Y', ($time + 10*24*60*60)) - 1958 + 1418 + 6000;
    
    if ($daynum == 0) { $holiday = $holidays[0]; $mday = 2; echo "Happy New Year!\r\n"; }
    if ($daynum == 181) { $holiday = $holidays[1]; $mday = 1; }
    if ($daynum == 182 && !isset($holiday)) { $holiday = $holidays[2]; $shd = 1; }
    if ($daynum == 183 && !isset($holiday)) { $holiday = $holidays[1]; $mday = 2; }
    if ($daynum == 364) { $holiday = $holidays[0]; $mday = 1; }
    
    if (!isset($holiday)) $month = $months[floor($mdaynum / 30)];
    $ordmday = ordinal_suffix($mday);
    
    if (!isset($holiday)) return "Today is $wday, the $ordmday day of $month in the year $year, by Shire Reckoning.\r\n";
    else if (!isset($shd)) return "Celebrate $wday, the $ordmday day of $holiday in the year $year, by Shire Reckoning.\r\n";
    else return "Celebrate $holiday in the year $year, by Shire Reckoning.\r\n";
}

echo sdate();
exit(0);
?>
