<?php
 $encryptionFlag = 0;  // added for AES migration
 $terminalResKey="51261103202951261103203151261103";
 /* Merchant (ME) checks, if error number is NOT present,then go for Encryption using required parameters 
*/
 /* NOTE - MERCHANT MUST LOG THE RESPONSE RECEIVED IN LOGS AS PER BEST PRACTICE */
 /*IMPORTANT NOTE - MERCHANT SHOULD UPDATE 
TRANACTION PAYMENT STATUS IN 
MERCHANT DATABASE AT THIS POSITION 
RESULT PAGE*/
 AND THEN REDIRECT CUSTOMER ON 
$ResTranData= 
"22a773681e7f5e12098d10950e7e8fba8f73045e2297e81f7d6162b6cd405910a184006072079c3d0089933bf907f5aa134309d6fc4a37f8eb3112f90fc579456f00485c20b0db52e21f5ba6ec88355e2f042652c9c26a27dad4c9a0435790e109bffadc3d3fcdec2ac3ac1020e3264bd7e487d2a76c83ad0facbc5f8bbddc6661ce7f8cd75d0babc491e321e53656ed7ee92fd8111a8675a702beb5b92517d349b6a88f23766f8cbfbef769147dd1cb8c630cafbbe5716ee19273ad5de4b9e5d9702834ae14dd41818acbd0804698e001d62b1f7c668fc116cb697c0ad7a937b3540902640cdf1027ba5bb63bd6a6ef80648c3f101c0b4a7a8630a973c13bbbf4d48ba005cac6fea5977abe225f3b14795ff84059a813a6d51564fc3d365e7b1e6e91adcb3df16510811e443f0e89d3b7625f2682c06001fb7866b8f6bf48eec09c82a92257572016307edc77469ab004fb94ef1ae79244bfe88169bdd73813da8f6daec4e779b4cd71f02c5f65a82a4e8959e51269e7c7721218193c0e57de22210c7eb5d4201951a5fe640b1d161f89c8f1d9a3db9447884c6bf8";
 if($ResTranData !=null)
 {
 }
  if (strlen($terminalResKey) == 32) {// added by vignesh for AES migration
 print_r($decrytedData=decryptDataAES($ResTranData,$terminalResKey)); 
  }else{
     print_r( $decrytedData=decryptData($ResTranData,$terminalResKey));
  }
   function decryptDataAES($data, $key) {// added by vignesh for AES 3ds2.0
 $cipher = 'aes-256-gcm';
 $tag_length = 16;
$data = hex2bin($data);
 $str1 = substr($key,0,6);
 $str1 .= substr($key,-7,-1);
 $iv = $str1;
 $ciphertext = substr($data, 0, -$tag_length);
 $tag = substr($data,-$tag_length);
 $decrypted = openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
 return $decrypted;
  }
 function decryptData($data, $key) {
  // $data = mcrypt_decrypt ( MCRYPT_3DES, $key, $data, MCRYPT_MODE_ECB); wont't work 
in php 7.x version
  $chiper = "des-ede3";  //Algorthim used to decrypt
  $data = hex2ByteArray($data);
  $data = byteArray2String($data);
  //$data = base64_encode($data);
  //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
  $decrypted = openssl_decrypt($data, $chiper, $key, OPENSSL_RAW_DATA|
 OPENSSL_ZERO_PADDING);
  return $decrypted;
 }
 function hex2ByteArray($hexString) {
  $string = hex2bin($hexString);
  return unpack('C*', $string);
 }
 function byteArray2String($byteArray) {
  $chars = array_map("chr", $byteArray);
  return join($chars);
 }
/* 
//Decryption Method for AES Algorithm Starts
 function decrypt($code,$key) { 
$code =  hex2ByteArray(trim($code));
 $code=byteArray2String($code);
 $iv = $key; 
$td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv); 
mcrypt_generic_init($td, $key, $iv);
 $decrypted = mdecrypt_generic($td, $code); 
mcrypt_generic_deinit($td);
 mcrypt_module_close($td); 
 return pkcs5_unpad($decrypted);
  }
  function hex2ByteArray($hexString) {
 $string = hex2bin($hexString);
 return unpack('C*', $string);
 }
 function byteArray2String($byteArray) {
 $chars = array_map("chr", $byteArray);
 return join($chars);
 }
 function pkcs5_unpad($text) {
 $pad = ord($text{strlen($text)-1});
 if ($pad > strlen($text)) {
    return false;
 }
 if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
    return false;
 }
 return substr($text, 0, -1 * $pad);
  }
 ?>
