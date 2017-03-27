<?php
/* Configuration Info
 * Enter your configuration information below.
 */
 
//Database Information

/* DB Name
 * Enter the name of your database below.
 */
define('DB_NAME', 'qrt');

/* DB Username
 * Enter the username of the user with access to the database below.
 */
define('DB_USER', 'shirley');

/* DB Password
 * Enter the above user's password below.
 */
define('DB_PASS', '');

//SALT Information

/* Site Key
 * Enter your site key below.
 */
define('SITE_KEY', 'tIVLEabZMrxm!%4ZHJWnXAjxbPt4mYGtyb!@$%&^%VQJsxGjOIdej#OT3EhCpxqC5Bu6KSOJM$$##VJV9jLF5uWiiFXm1G');

/* NONCE SALT
 * Enter your NONCE SALT below.
 */
define('NONCE_SALT', 'fxmAMC5TiY2_)(eh2DfbOOX4*&F73ldggm8KZP35N48t3OVbTaoOpaOlLydef#_+kvusgNgafnuujTPdazfzqpDy');

/* AUTH SALT
 * Enter your AUTH SALT below.
 */
define('AUTH_SALT', 'g)(*)Um9SXCqWWvSDm6&^&k3iwMqPghWzTgqMSiy)(&*&RaAoMdbyLNuRdvH(gwL0fA7Umlmy4ZvH04r2xjp7KH2ahNNc');

$link = mysqli_connect('eco72648',DB_USER,DB_PASS,DB_NAME) or die('Could not connect because:'.mysqli_connect_error());

define('ENCRYPTION_KEY', 'd0a7e7997b6d5fcd55f4b5c32611b87cd923e88837b63bf2941ef819dc8ca282');
// Encrypt Function
function mc_encrypt($encrypt, $key){
    $encrypt = serialize($encrypt);
    $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC), MCRYPT_DEV_URANDOM);
    $key = pack('H*', $key);
    $mac = hash_hmac('sha256', $encrypt, substr(bin2hex($key), -32));
    $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $encrypt.$mac, MCRYPT_MODE_CBC, $iv);
    $encoded = base64_encode($passcrypt).'|'.base64_encode($iv);
    return $encoded;
}
// Decrypt Function
function mc_decrypt($decrypt, $key){
    $decrypt = explode('|', $decrypt.'|');
    $decoded = base64_decode($decrypt[0]);
    $iv = base64_decode($decrypt[1]);
    if(strlen($iv)!==mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)){ return false; }
    $key = pack('H*', $key);
    $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $decoded, MCRYPT_MODE_CBC, $iv));
    $mac = substr($decrypted, -64);
    $decrypted = substr($decrypted, 0, -64);
    $calcmac = hash_hmac('sha256', $decrypted, substr(bin2hex($key), -32));
    if($calcmac!==$mac){ return false; }
    $decrypted = unserialize($decrypted);
    return $decrypted;
}
?>