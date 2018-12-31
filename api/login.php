<?php
$json = file_get_contents("php://input");
if($json == ""){
    exit("Invalid Request");
}
$data = json_decode($json,true);
if($data[0]["phonenumber"]=="" || $data[0]["phonenumber"] == null){
    return "Invalid Request";
}
require("prepend.php");
require("preload.php");
$phone = $data[0]["phonenumber"];
$aes = new AES($data[0]["password"],$_CONFIG["aes_enc_client_key"],256);
$encpass = Crypto_Provider::encrypt($aes->decrypt(),"password", $_CONFIG["crypto_provider_salt"]);
$phone = Crypto_Provider::aes_crypto_provider($aes, $phone, $_CONFIG["aes_enc_client_key"], $_CONFIG["aes_enc_key"]);
$db = new DB_Api();
$db->query_bind("select `u_id`,`u_name`,`u_phoneno`,`u_email`,`u_hash` from users where u_phoneno = :u_phoneno and u_passwrd = :u_passwrd", array(':u_phoneno'=>$phone,':u_passwrd'=>$encpass));
$data = $db->fetchAll();
$data = $data[0];
if($data == "" || $data == null){
    echo "Invalid Phone Number or Password";
}
foreach($data as $key=>$value){
    if($key === "u_hash" || $key === "u_id") continue;
    $data[$key] = Crypto_Provider::aes_crypto_provider($aes, $value, $_CONFIG["aes_enc_key"], $_CONFIG["aes_enc_client_key"]);
}
if($data == "" || $data == null){
    echo json_encode("Invalid Phone Number or Password");
}
else {
    echo json_encode($data);
}
?>