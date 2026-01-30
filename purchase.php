<?php
 $ReqCardNumber = "<card>4012000000001097</card>";
 $ReqCvv = "<cvv2>123</cvv2>";
 $ReqExpMonth = "<expmonth>12</expmonth>";
 $ReqExpYear = "<expyear>2026</expyear>";
 $ReqAmount = "<amt>100.00</amt>";
 $encryptionFlag = 0;  // added for AES migration
 $strmember = "<member>test</member>";
 $ReqLangid = "<langid>USA</langid>";
 $ReqAction = "<action>1</action>" ;
 //.$_REQUEST['action']
 $ReqCurrencyCode = "<currencycode>356</currencycode>";
 $TranportalId = "  ";
 $ReqTranportalPassword = "<password>password1</password>";
 $ReqCurrency = "<currency>356</currency>";
 $ReqTranportalId="<id>".$TranportalId."</id>";
$ReqAmount="<amt>100.00</amt>";
 $ReqTrackId="<trackId>".rand(10,1000011)."</trackId>";
 $ReqLangid="langid=USA";
 $ReqType="<type>C</type>";
 $ResponseUrl="http://localhost/PHPUMI/umitranportalhttp/GetHandlerResponse.php";
 $ReqResponseUrl="responseURL=".$ResponseUrl;
 $ErrorUrl="http://localhost/PHPUMI/umitranportalhttp/GetHandlerResponse.php";
 $ReqErrorUrl="errorURL=".$ErrorUrl;
 $ReqUdf1="<udf1>Test1</udf1>";
 $ReqUdf2="<udf2>Test2</udf2>";
 $ReqUdf3="<udf3>Test3</udf3>";
 $ReqUdf4="<udf4>Test4</udf4>";
 $ReqUdf5="<udf5>Test5</udf5>";
/* Now merchant sets all the inputs in one string for encrypt and then passing to the Payment Gateway URL
 */
 $param="<request>".$ReqCardNumber.$ReqCvv.$ReqCurrencyCode.$ReqExpYear.$ReqExpMonth.
 $ReqType.$strmember.$ReqAmount.$ReqAction.
 $ReqUdf1.$ReqUdf2.$ReqUdf3.$ReqUdf4.$ReqUdf5.$ReqCurrency.isset($ReqCustId).$ReqTrackId
 .$ReqTranportalId.$ReqTranportalPassword."</request>";
 print_r($param);
 $termResourceKey="51261103202951261103203151261103";  
if (strlen($termResourceKey) == 32) {// added by vignesh for AES migration
  $param=encryptDataAES($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".
 $ResponseUrl."&errorURL=".$ErrorUrl;
 }else{
  $param=encryptData($param,$termResourceKey)."&tranportalId=".$TranportalId."&responseURL=".
 $ResponseUrl."&errorURL=".$ErrorUrl;
 }
 print_r("Location: https://securepaymentstest.hdfcuat.bank.in:7443/PG/VPAS.htm?
 actionVPAS=VbvVEReqProcessHTTP&trandata=".$param); /* Redirect browser */
 exit();
 function encryptDataAES($payload, $key){// added by vignesh for AES migration
  $cipher = 'aes-256-gcm';
  $str1 = substr($key,0,6);
  $str1 .= substr($key,-7,-1);
  $iv = $str1;
  $tag = '';
  $encrypted = openssl_encrypt($payload, $cipher,  $key,  OPENSSL_RAW_DATA, $iv,$tag,'', 16 );
  $encrypted = $encrypted . $tag;
  $encrypted = bin2hex($encrypted);
}
  return $encrypted;
 //DES Encryption Method Starts
 function encryptData($payload, $key) {
  //$block = mcrypt_get_block_size ( 'tripledes', 'ecb' ); wont't work in php 7.x version
  $chiper = "des-ede3";  //Algorthim used to encrypt
  if((strlen($payload)%8)!=0) {
 //Perform right padding
 $payload = rightPadZeros($payload);
  }
  //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($chiper));
  $encrypted = openssl_encrypt($payload, $chiper, $key,OPENSSL_RAW_DATA | 
OPENSSL_ZERO_PADDING);
  $encrypted=unpack('C*', ($encrypted));
  $encrypted=byteArray2Hex($encrypted);
 //     print_r($encrypted);
 //     exit();
  return strtoupper($encrypted);
 }
 //DES Encryption Method Ends
 function rightPadZeros($Str) {
  if(null == $Str){
 return null;
  }
  $PadStr = $Str;
  for ($i = strlen($Str);($i%8)!=0; $i++) {
 $PadStr .= "^";
  }
}
  return $PadStr;
 function byteArray2Hex($byteArray) {
  $chars = array_map("chr", $byteArray);
  $bin = join($chars);
  return bin2hex($bin);
 }
 ?>
