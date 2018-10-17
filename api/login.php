<?php
$json = file_get_contents("php://input");
$data = json_decode($json,true);
if($data[0]["phonenumber"]=="" || $data[0]["phonenumber"] == null){
    return "Invalid Request";
}
require("prepend.php");
require("preload.php");
$phone = $data[0]["phonenumber"];
$aes = new AES($data[0]["password"],"YourKey",256);
$password = $aes->decrypt();
$encpass = Crypto_Provider::encrypt($password,"password");
$db = new DB_Api();
$db->query("select `u_id`,`u_name`,`u_phoneno`,`u_email`,`u_hash` from users where `u_phoneno`='".$phone."' and `u_passwrd`='".$encpass."'");
echo json_encode($db->fetchAll());
?>