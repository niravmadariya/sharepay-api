<?php
class Crypto_Provider{
    public static function encrypt($data, $type, $salt){
        if($type==="password")
            $encdata = strtolower(md5(strtolower(md5($data.$salt.$data))));
        else if($type==="number")
            $encdata = strtolower(md5($data.$salt.$data));
        else if($type==="hash")
            $encdata = strtolower(md5($data.$salt.$type.$salt.$data));
        return $encdata;
    }

    // AES Encryption -  does decryption of data with one key and encrypts the decrypted data with the another key
    public static function aes_crypto_provider($aes, $data, $key, $key2){
        $aes->setData($data);
        $aes->setKey($key);
        $aes->setData($aes->decrypt());
        $aes->setKey($key2);
        return $aes->encrypt();
    }
    // one way encryption provider
    public static function aes_crypto_provider_enc($aes, $data, $key){
        $aes->setData($data);
        $aes->setKey($key);
        return $aes->encrypt();
    }
    // one way decryption provider
    public static function aes_crypto_provider_dec($aes, $data, $key){
        $aes->setData($data);
        $aes->setKey($key);
        return $aes->decrypt();
    }
}
?>