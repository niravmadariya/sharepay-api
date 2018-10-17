<?php
class Crypto_Provider{
    public static function encrypt($data, $type){
        $salt = "YourSalt";
        if($type==="password")
            $encdata = strtolower(md5(strtolower(md5($data.$salt.$data))));
        else if($type==="number")
            $encdata = strtolower(md5($data.$salt.$data));
        else if($type==="hash")
            $encdata = strtolower(md5($data.$salt."hash".$salt.$data));
        return $encdata;
    }
}
?>