<?php 
session_start();
function dump($txt)
{
    echo "<pre>";
    var_dump($txt);
    echo "</pre>";
}

function guidv4($data = null) 
{
    // Generate 16 bytes (128 bits) of random data or use the data passed into the function.
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    // Set version to 0100
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    // Set bits 6-7 to 10
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    // Output the 36 character UUID.
    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

define('HOST', 'localhost');
define('PORT', '3306');
define('DB', 'test');
define('USER', 'test');
define('PASS', 'test');

define('HOSPITAL_CODE', '0000');
define('MOPH_USER', 'test');
define('SECRET_KEY', 'test');
define('MOPH_TOKEN', 'https://test.com/');
define('MOPH_API_HOST', 'https://test.com/'); // Production Server

define('EPIDEM_HOST', 'https://test.com/api/');

$def_fullm_th = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน', '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม', '09' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');

$password_hash = strtoupper(hash_hmac('sha256', MOPH_USER, SECRET_KEY));

$time = $_SERVER['REQUEST_TIME'];

if(!empty($_SESSION['time_end']) && $time < $_SESSION['time_end']){

    $public_key = $_SESSION['public_key'];

}else{ 

    unset($_SESSION['time_end']);
    $_SESSION['time_end'] = $time+(60*10);

    $public_key_url = MOPH_TOKEN . "action=get&user=" . MOPH_USER . "&pass=$password_hash&hos=" . HOSPITAL_CODE;
    $public_key = file_get_contents($public_key_url);
    if($public_key == false){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $public_key_url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // skip https
        curl_setopt($curl, CURLOPT_HTTPHEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $public_key = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);
        echo "CURL ERROR: ".$error_msg;
    }

    $_SESSION['public_key'] = $public_key;
    
}

define('PUBLIC_KEY', $public_key);