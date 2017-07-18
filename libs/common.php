<?php

function RndStr($ln) {
 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
 $randstring = '';
 for ($i = 0; $i < $ln; $i++) {
  $randstring .= $characters[rand(0, strlen($characters)-1)];
 }
 return $randstring;
}

function pathToRoot () {
  $stepsToRoot=count( explode('/', $_SERVER['SCRIPT_NAME']) ) - 2;
  $w="";
  for ($i=0; $i<$stepsToRoot; $i++) {
    $w.='../';
  }
  return $w;
}

function delTree($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
} 

function PChiffreU ( $u, $p, &$s1, &$s2 ) {
 $ctx = hash_init('sha256');
 $s1=RndStr(22);
 $s2=RndStr(22);

 hash_update($ctx,$u.$s1); 
 hash_update($ctx,$p.$s2); 

 return hash_final($ctx); 
} 

function PVerifU ( $u, $p, $s1, $s2 ) {
 $ctx = hash_init('sha256');

 hash_update($ctx,$u.$s1); 
 hash_update($ctx,$p.$s2); 

 return hash_final($ctx); 
} 

function PChiffreR ( $p, &$key ) {
  $key=RndStr(mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
   
  $iv = mcrypt_create_iv(
      mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC),
      MCRYPT_DEV_URANDOM
  );
  
  $e = base64_encode(
      $iv .
      mcrypt_encrypt(
          MCRYPT_RIJNDAEL_256,
          substr(hash('sha512', $key, false),0,mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
          $p,
          MCRYPT_MODE_CBC,
          $iv
      )
  );
  
  return $e ;
}

function PDechiffreR ($e, $key) {
  $data = base64_decode($e);
  $iv = substr($data, 0, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC));
  
  $d = rtrim(
      mcrypt_decrypt(
          MCRYPT_RIJNDAEL_256,
          substr(hash('sha512', $key, false),0,mcrypt_get_key_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
          substr($data, mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC)),
          MCRYPT_MODE_CBC,
          $iv
      ),
      "\0"
  );
  
  return $d;
}
?>