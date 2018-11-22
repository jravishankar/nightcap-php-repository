<?php
$user = $_GET['user'];
$rqno = $_GET['rqno'];

if (isset($user) isset($rqno)) {

  unlink("../phpdata/" . $user . "/done.txt");

  echo "AK " . $rqno . "|";

}

?>
