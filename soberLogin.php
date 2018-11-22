<?php
$user = $_GET['user'];
$rqno = $_GET['rqno'];

if(isset($user) && isset($rqno)) {

   $addSober = "../phpdata/Sober/" . $user . ".txt";
   $file = fopen($addSober, "w") or die("Unable to open file!");
   fwrite($file, "");

   $helpreqs = scandir("../phpdata/Help/");

   #Updates helpreqs directory with all current help requests
   #NEED TO FILTER BASED ON PREFERENCES
   for ($i = 0; $i < count($helpreqs); ++$i) {

      if (substr($helpreqs[$i],-4)!=".txt") continue;

      $userinfo = file("../phpdata/" . $user  . "/user.txt", FILE_IGNORE_NEW_LINES);
      $helpinfo = file("../phpdata/Help/" . $helpreqs[$i], FILE_IGNORE_NEW_LINES);

      if (strcmp($userinfo[2], $helpinfo[1]) == 0 || strcmp($helpinfo[1], "None") == 0 || (strcmp($helpinfo[1], "Male/Female") == 0) && ((strcmp($userinfo[2], "Other") != 0)) || ((strcmp($helpinfo[1], "Male/Other") == 0) && (strcmp($userinfo[2], "Female") != 0)) || ((strcmp($helpinfo[1], "Female/Other") == 0) && (strcmp($userinfo[2], "Male") != 0))) {

         $newreq = "../phpdata/" . $user . "/" . "helpreq/" .  $helpreqs[$i];
         $reqfile = fopen($newreq, "w") or die("Unable to open file!");
         fwrite($reqfile, $helpinfo[0]);
         fclose($reqfile);

      }

   }

   echo "AK " . $rqno . "|";

}

?>
