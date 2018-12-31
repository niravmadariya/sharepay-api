<?php
$json = file_get_contents("php://input");
if($json == ""){
    exit("Invalid Request");
}
$data = json_decode($json,true);
if($data[0]["hash"]=="" || $data[0]["hash"] == null){
    exit("Invalid Request");
}
require("prepend.php");
require("preload.php");
$key = $_CONFIG["aes_enc_key"];
if(empty($data[0]["hash"]) || empty($data[0]["splitwith1"]) || empty($data[0]["amount"]) || empty($data[0]["paidby"])){
    exit("Invalid Request");
}
$aes = new AES("","",256);
function enc_phone($aes, $phone, $key){
    return Crypto_Provider::aes_crypto_provider_enc($aes, $phone, $key);
}
//Maximum split to 5 people is supported as of now.
$hash = $data[0]["hash"];
$amount = $data[0]["amount"];
$paidby = $data[0]["paidby"];
$db = new DB_Api();
// assuming all the users to split is registered.
$paidby = enc_phone($aes, $paidby, $key);
$phone_numbers = $db->quote(enc_phone($aes, $data[0]["splitwith1"], $key));
if(isset($data[0]["splitwith2"]))
	$phone_numbers.= ", ".$db->quote(enc_phone($aes, $data[0]["splitwith2"], $key));
if(isset($data[0]["splitwith3"]))
	$phone_numbers.= ", ".$db->quote(enc_phone($aes, $data[0]["splitwith3"], $key));
if(isset($data[0]["splitwith4"]))
	$phone_numbers.= ", ".$db->quote(enc_phone($aes, $data[0]["splitwith4"], $key));
if(isset($data[0]["splitwith5"]))
	$phone_numbers.= ", ".$db->quote(enc_phone($aes, $data[0]["splitwith5"], $key));
$query = "select u_hash from users where u_phoneno in (".$phone_numbers.")";
//Replace this method with query_bind
$db->query($query);
$data = $db->fetchAll();
$splitwith = "";
foreach($data as $key=> $value){
    $splitwith.=$value."-";
}
if(substr($splitwith, -1) == "-"){
	$splitwith = substr($splitwith, 0, strlen($splitwith)-1);
}
$query = "insert into transaction (`hash`, `splitwith`, `amount`, `paidby`) values (:hash, :splitwith, :amount, :paidby)";
if($db->query_bind($query, array(':hash' => $hash, ':splitwith' => $splitwith, ':amount' => $amount, ':paidby' => $paidby)))
	echo json_encode("Successfully added");
else
	echo json_encode("Adding transaction failed, Please try again!");
?>