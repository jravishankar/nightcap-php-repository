<?php
$user = $_GET['user'];
$gend = $_GET['gend'];
$rqno = $_GET['rqno'];

if (isset($user) && isset($gend) && isset($rqno)){

   if (!file_exists("../phpdata/" . $user)) {
   mkdir("../phpdata/" . $user);
   mkdir("../phpdata/" . $user . "/helpreq");
   mkdir("../phpdata/" . $user . "/messages");

   #Creates location file for user
   $loctxt = "../phpdata/" . $user . "/loc.txt";
   $locfile = fopen($loctxt, "w") or die("Unable to open file!");
   fwrite($locfile, "37 38");
   fclose($locfile);

   #Creates user info file
   $year = rand(18, 21);
   $usertxt = "../phpdata/" . $user . "/user.txt";
   $userfile = fopen($usertxt, "w") or die("Unable to open file!");
   fwrite($userfile, $user . "Person" . "\n" . "###########" . "\n" . $gend . "\n" . $user . "@middlebury.edu" . "\n" . "20" . (string) $year);
   fclose($userfile);

   #Creates messages file
   $msgtxt = "../phpdata/" . $user . "/messages" . "/number.txt";
   $msgfile = fopen($msgtxt, "w") or die("Unable to open file!");
   fwrite($msgfile, "1");
   fclose($msgfile);

   }

   echo "AK " . $rqno . "|";
}

?>
