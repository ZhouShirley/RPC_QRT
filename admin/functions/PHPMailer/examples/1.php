<?php
$fp = fsockopen('tcp://smtp.gmail.com', 587, $errno, $errstr, 10);
echo fgets($fp, 128);
fclose($fp);