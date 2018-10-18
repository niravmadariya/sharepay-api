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
$aes = new AES($data[0]["password"],$_CONFIG["aes_enc_key"],256);
$encpass = Crypto_Provider::encrypt($aes->decrypt(),"password", $_CONFIG["crypto_provider_salt"]);
$db = new DB_Api();
$db->query("select `u_id`,`u_name`,`u_phoneno`,`u_email`,`u_hash` from users where `u_phoneno`='".$phone."' and `u_passwrd`='".$encpass."'");
$data = $db->fetchAll();
if($data == "" || $data == null){
    echo "Invalid Phone Number or Password";
}
else {
    echo json_encode($db->fetchAll());
}
?>