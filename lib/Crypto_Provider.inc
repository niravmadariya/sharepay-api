<?php
class Crypto_Provider{
    public static function encrypt($data, $type, $key){
        if($type==="password")
            $encdata = strtolower(md5(strtolower(md5($data.$key.$data))));
        else if($type==="number")
            $encdata = strtolower(md5($data.$key.$data));
        else if($type==="hash")
            $encdata = strtolower(md5($data.$key."hash".$key.$data));
        return $encdata;
    }
}
?>