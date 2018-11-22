<?php
$user = $_GET['user'];
$loc = $_GET['loc'];
$conn = $_GET['conn'];
$ssid = $_GET['ssid'];


if(isset($user) && isset($loc) && (strcmp($loc, "0.0 0.0") != 0)) {

   #Updates the user's location in the database
   $lines = file("../phpdata/" . $user . "/" . "loc.txt", FILE_IGNORE_NEW_LINES);
   $lat_long = explode("_", $loc);
   $lines[0] = $lat_long[0] . " " . $lat_long[1] . " " . $lat_long[2];
   file_put_contents("../phpdata/" . $user . "/" . "loc.txt", $lines);
   $my_lat = $lat_long[0];
   $my_long = $lat_long[1];
   $my_alt = $lat_long[2];

   #Looks through the user's help requests and echoes them with HR tag
   $helparr = scandir("../phpdata/" . $user . "/" . "helpreq/", FILE_IGNORE_NEW_LINES);

   for ($i = 0; $i < count($helparr); ++$i) {

      if (substr($helparr[$i],-4)!=".txt") continue;

      $drunkloc = file("../phpdata/" . $user . "/" . "helpreq/" . $helparr[$i], FILE_IGNORE_NEW_LINES);
      echo "HR " . (substr($helparr[$i], 0, strlen($helparr[$i])-4))  . " " . $drunkloc[0] . "|";
      file_put_contents("../phpdata/" . $user . "/" . "helpreq/" . $helparr[$i], $drunkloc);

   }

   #Looks through the user's messages and echoes them with MG tag
   $msgarr = scandir("../phpdata/" . $user . "/messages/");

   for ($j = 0; $j < count($msgarr); ++$j) {

      if (substr($msgarr[$j], -4) != ".txt") continue;

      if (strcmp($msgarr[$j], "number.txt") != 0) {

         $msg = file("../phpdata/" . $user . "/messages/" . $msgarr[$j], FILE_IGNORE_NEW_LINES);
         echo "MG " . substr($msgarr[$j], 7, -4) . " " . $msg[0] . " " . $msg[1] . "|";
         unlink("../phpdata/" . $user . "/messages/" . $msgarr[$j]);

      }

   }

   if (file_exists("../phpdata/" . $user . "/done.txt")) {

      echo "DN Fin|";

   }


   #For drunk user, updates their helper's file and sends back these updates with HB tag
   if (file_exists("../phpdata/" . $user . "/helper.txt")) {

     $helper = file("../phpdata/" . $user . "/helper.txt", FILE_IGNORE_NEW_LINES);

     #make variables for cleaerer coding (set helper[0] = some varname)
     $soberloc = file("../phpdata/" . $helper[0] . "/loc.txt", FILE_IGNORE_NEW_LINES);
     $helper[1] = $soberloc[0];
     #echo "HB " . $helper[0] . " " . $helper[1] . "|";

     #Checks for the user's location
     $locs = scandir("../phpdata/Locations/");
     $location = "";

     for ($i = 0; $i < count($locs); ++$i) {

       if (substr($locs[$i],-4)!=".txt") continue;
       $place = file("../phpdata/Locations/" . $locs[$i], FILE_IGNORE_NEW_LINES);
       $loclat = explode("_", $place[0]);
       $loclong = explode("_", $place[1]);
       $minlat = $lat[0];
       $maxlat = $lat[1];
       $minlong = $long[0];
       $maxlong = $long[1];

       if ((($minlat < $my_lat) && ($maxlat > $my_lat))  &&  (($minlong < $my_long) && ($maxlong > $my_long))) {

         $location .= substr($locs[$i], 0, -4);
         break;

       }

     }

     file_put_contents("../phpdata/" . $user . "/helper.txt", $helper[0] . "\n" . $helper[1] . "\n" . $location);
     echo "HB " . $helper[0] . " " . $location . "|";

     #Checks if user's helper has been disconnected
     if (time()-filemtime("../phpdata/" . $helper[0] . "/loc.txt") > 6 && (strcmp($conn, "yes") == 0)) {

        echo "DN Con|";

     }



   }


   #For sober user, updates their helpee's file and sends back these updates with HP tag
   if (file_exists("../phpdata/" . $user . "/helping.txt")) {

     $helpee = file("../phpdata/" . $user . "/helping.txt", FILE_IGNORE_NEW_LINES);
     $drnkloc =  file("../phpdata/" . $helpee[0] . "/loc.txt", FILE_IGNORE_NEW_LINES);
     $helpee[1] = $drnkloc[0];
     #echo "HP " . $helpee[0] . " " . $helpee[1] . "|";

     #Checks for the user's location
     $locs = scandir("../phpdata/Locations/");
     $location1 = "";

     for ($i = 0; $i < count($locs); ++$i) {

       if (substr($locs[$i],-4)!=".txt") continue;
       $place = file("../phpdata/Locations/" . $locs[$i], FILE_IGNORE_NEW_LINES);
       $loclat = explode("_", $place[0]);
       $loclong = explode("_", $place[1]);
       $minlat = $lat[0];
       $maxlat = $lat[1];
       $minlong = $long[0];
       $maxlong = $long[1];

       if ((($minlat < $my_lat) && ($maxlat > $my_lat))  &&  (($minlong < $my_long) && ($maxlong > $my_long))) {

         $location1 .= substr($locs[$i], 0, -4);
         break;

       }

     }

     file_put_contents("../phpdata/" . $user . "/helping.txt", $helpee[0] . "\n" . $helpee[1] . "\n" . $locaton1);
     echo "HP " . $helpee[0] . " " . $location1 . "|";

     #Checks if user's helper has been disconnected
     if (time()-filemtime("../phpdata/" . $helpee[0] . "/loc.txt") > 6 && (strcmp($conn, "yes") == 0)) {

        echo "DN Con|";

     }

   }
}

?>
