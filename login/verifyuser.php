<!DOCTYPE html>
<html>
  <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link href="../css/main.css" rel="stylesheet" media="screen">
    <meta charset="UTF-8">
    <title>Verify User</title>
  </head>
  <body>
<?php
require 'includes/functions.php';
include 'config.php';
//Pulls variables from url. Can pass 1 (verified) or 0 (unverified/blocked) into url
$uid = $_GET['uid'];
$verify = $_GET['v'];
$e = new SelectEmail;
$eresult = $e->emailPull($uid);
$email = $eresult['email'];
$username = $eresult['username'];
$v = new Verify;
if (isset($uid) && !empty(str_replace(' ', '', $uid)) && isset($verify) && !empty(str_replace(' ', '', $verify))) {
    //Updates the verify column on user
    $vresponse = $v->verifyUser($uid, $verify);
    //Success
    if ($vresponse == 'true') {
        echo $activemsg;
        //Send verification email
        $m = new MailSender;
        $m->sendMail($email, $username, $uid, 'Active');
    } else {
        //Echoes error from MySQL
        echo $vresponse;
    }
} else {
    //Validation error from empty form variables
    echo 'An error occurred... click <a href="index.php">here</a> to go back.';
};
?>
</body>
</html>