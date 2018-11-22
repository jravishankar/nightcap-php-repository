<?php
$user = $_GET['user'];
$rqst = $_GET['rqst'];
$rqno = $_GET['rqno'];

if (isset($user) && isset($rqst) && isset($rqno)) {

  $sobers = scandir("../phpdata/Sober/");

  #Deletes the help request from every user except the one who accepted
  for ($i = 0; $i < count($sobers); ++$i) {

    #Only checks through text files
    if (substr($sobers[$i],-4)!=".txt") continue;

    $requests = scandir( "../phpdata/" . (substr($sobers[$i], 0, strlen($sobers[$i])-4))  . "/" . "helpreq/");

    for ($j = 0; $j < count($requests); ++$j) {

      if (strcmp(substr($requests[$j], 0, strlen($requests[$j])-4), $rqst) == 0) {

         unlink("../phpdata/" . (substr($sobers[$i], 0, strlen($sobers[$i])-4))  . "/" . "helpreq/" . $requests[$j]);

      }

    }

  }

  unlink("../phpdata/Help/" . $rqst . ".txt");

  #Need to send requestee the info of the helper
  $helploc = file("../phpdata/" . $user . "/loc.txt", FILE_IGNORE_NEW_LINES);
  $helper = "../phpdata/" . $rqst . "/" . "helper.txt";
  $helpfile = fopen($helper, "w") or die("Unable to open file!");
  fwrite($helpfile, $user . "\n" . $helploc[0]);
  fclose($helpfile);

  #Sends helper info of drunk person
  $drunkloc = file("../phpdata/" . $rqst . "/loc.txt", FILE_IGNORE_NEW_LINES);
  $helpee = "../phpdata/" . $user . "/" . "helping.txt";
  $drunkfile = fopen($helpee, "w") or die("Unable to open file");
  fwrite($drunkfile, $rqst . "\n" . $drunkloc[0]);
  fclose($drunkfile);

  echo "AK " . $rqno;
  
}
?>
