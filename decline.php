<?php
$user = $_GET['user'];
$rqst = $_GET['rqst'];
$rqno = $_GET['rqno'];

if (isset($user) && isset($rqst) && isset($rqno)) {

    unlink("../phpdata/" . $user . "/" . "helpreq/" . $rqst . ".txt");

    echo "AK " . $rqno;

}
