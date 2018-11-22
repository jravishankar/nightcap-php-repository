<?php
$user = $_GET['user'];

$clean = scandir("../phpdata/" . $user . "/");
rmdir("../phpdata/" . $user . "/" . "helpreq/");

for ($j = 0; $j < count($clean); ++$j) {

   if (substr($clean[$j],-4)!=".txt") continue;
   unlink("../phpdata/" . $user . "/" . $clean[$j]);

}

rmdir("../phpdata/" . $user . "/");
?>
