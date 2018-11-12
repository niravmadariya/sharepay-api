<?php
$json = file_get_contents("php://input");
$data = json_decode($json,true);
if(empty($data[0]["hash"]) || $data[0]["hash"] == null){
    return "Invalid Request";
}
require_once("prepend.php");
require_once("preload.php");
$hash = $data[0]["hash"];
$aes = new AES("","",256);
$hash = Crypto_Provider::aes_crypto_provider_dec($aes, $hash, $_CONFIG["aes_enc_client_key"]);
$db = new DB_Api();
$db->query_bind("select `u_id`,`u_name`,`u_phoneno`,`u_email` from users where u_hash = :u_hash", array(':u_hash'=>$hash));
$data = $db->fetchAll();
$data = $data[0];
if($data == "" || $data == null){
    echo "Invalid Request";
}
foreach($data as $key=>$value){
    if($key === "u_hash" ) continue;
    if($key === "u_id" ) continue;
    $data[$key] = Crypto_Provider::aes_crypto_provider($aes, $value, $_CONFIG["aes_enc_key"], $_CONFIG["aes_enc_client_key"]);
}
if($data == "" || $data == null){
    echo "Invalid Request";
}
else {
    echo json_encode($data);
}
?>