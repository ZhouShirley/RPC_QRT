<?php

include('config/setup.php');
$pageid= $_GET['pageid'];
$q = "SELECT * FROM pages WHERE id = $pageid";
$r = mysqli_query($dbc, $q);
$opened = mysqli_fetch_assoc($r);

echo $pageid;
echo $opened['emp_id'];
echo ('leader id is '. $opened['leader_id']);

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require 'functions/PHPMailer/PHPMailerAutoload.php';
require_once('functions/PHPMailer/class.phpmailer.php');
ini_set('max_execution_time', 300);
//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;

//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';

//Set the hostname of the mail server
$mail->Host = 'PWAT1INCAS02.eig.ecogrp.ca';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6

//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 25;

//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';

//Whether to use SMTP authentication
$mail->SMTPAuth = false;

//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = ""; //shirley.zhou@economical.com

//Password to use for SMTP authentication
$mail->Password = "";

//Set who the message is to be sent from
$mail->setFrom('WFO_Coaching@economical.com', 'Xiaoli Zhou');

//Set an alternative reply-to address
//$mail->addReplyTo('shirley.zhou@economical.com', 'Shirley Zhou');

//Set who the message is to be sent to
$mail->addAddress('shirley.zhou@economical.com', 'Shirley Zhou');
//$mail->addAddress('kirill.savine@economical.com', 'Kirill Savine');
//Set the subject line
$mail->Subject = 'Trying the PHP email sent test';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
$mail->Body = 'Hello, this is my message.';
//Replace the plain text body with one ?created manually
$mail->AltBody = 'This is a plain-text message body';

//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}


?>