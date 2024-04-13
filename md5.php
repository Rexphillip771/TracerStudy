<?php 
$encrypted = encryptIt($input);
$decrypted = decryptIt($encrypted);

function encryptIt($q)
{
  $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $qEncoded = base64_encode(openssl_encrypt($q, 'aes-256-cbc', $cryptKey, 0, $iv));
  return $qEncoded;
}

function decryptIt($q)
{
  $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
  $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
  $qDecoded = openssl_decrypt(base64_decode($q), 'aes-256-cbc', $cryptKey, 0, $iv);
  return $qDecoded;
}
?>
