<?php
$json = file_get_contents("php://input");
$data = json_decode($json,true);
if(empty($data[0]["phonenumber"]) || $data[0]["phonenumber"] == null){
    return "Invalid Request";
}

require_once("prepend.php");
require_once("preload.php");
$usr_data['name'] = $data[0]["u_name"] != null ? $data[0]["u_name"] : $data[0]["phonenumber"];
$usr_data['email'] = $data[0]["u_email"];
$usr_data['phone_number'] = $data[0]["phonenumber"];
$usr_data['password'] = $data[0]["password"];
$usr_data['hash'] = "";
$data[0] = "";

$aes = new AES($usr_data["phone_number"],$_CONFIG["aes_enc_client_key"],256);
$phone_num = $aes->decrypt();
if(ctype_digit($phone_num)){
    $phone_num = trim($phone_num, " ");
    if(strpos($phone_num,"-")){
        $phone_num = str_replace("", "-", $phone_num);
    }
    if(strpos($phone_num,"+")){
        $phone_num = str_replace("", "+", $phone_num);
    }
    if(strlen($phone_num)>13){
        exit("[{\"response\":\"Invalid Phone Number\"}]");
    }
    $aes->setData($phone_num);
    $aes->setKey($_CONFIG["aes_enc_key"]);
    $usr_data['phone_number'] = $aes->encrypt();
    $phone_number = "";
    unset($phone_num);
}
else{
    exit("[{\"response\":\"Bad Request\"}]");
}

$aes->setData($usr_data['password']);
$aes->setKey($_CONFIG["aes_enc_client_key"]);
$password = $aes->decrypt();
if(!empty($password) && $password != null){
    $usr_data['password'] = Crypto_Provider::encrypt($password,"password",$_CONFIG["crypto_provider_salt"]);
    $password = "";
    unset($password);
}
else{
    exit("[{\"response\":\"Please enter the password\"}]");
}

$aes->setData($usr_data['name']);
$aes->setKey($_CONFIG["aes_enc_client_key"]);
$name = $aes->decrypt();
$aes->setData($name);
$aes->setKey($_CONFIG["aes_enc_key"]);
$usr_data['name'] = $aes->encrypt();

$name = "";
unset($name);


$aes->setData($usr_data['email']);
$aes->setKey($_CONFIG["aes_enc_client_key"]);
$email = $aes->decrypt();
if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $aes->setData($email);
    $aes->setKey($_CONFIG["aes_enc_key"]);
    $usr_data['email'] = $aes->encrypt();
    $email = "";
    unset($email);
}
else{
    exit("[{\"response\":\"Invalid Email\"}]");
}

$usr_data['hash'] = Crypto_Provider::encrypt($usr_data['phone_number'], "hash", $_CONFIG["crypto_provider_salt"]);
$encpass = Crypto_Provider::encrypt($aes->decrypt(),"password", $_CONFIG["crypto_provider_salt"]);
$db = new DB_Api();
if($db->query_bind("insert into users (`u_name`, `u_phoneno`, `u_email`, `u_passwrd`, `u_hash`) values(:u_name, :u_phoneno, :u_email, :u_passwrd, :u_hash)", array(':u_name' => $usr_data['name'], ':u_phoneno' => $usr_data['phone_number'], ':u_email' => $usr_data['email'], ':u_passwrd' => $usr_data['password'], ':u_hash' => $usr_data['hash'])))
    echo json_encode("Sign up Successful, Please Login to the account");
else
    echo json_encode("Signup Failed, Please try again!");
?>