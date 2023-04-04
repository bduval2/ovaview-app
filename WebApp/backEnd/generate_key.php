<?php
    include_once('crypt.php');
    $private_key = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    $index_key = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
    echo 'Your private key: ' . base64_encode($private_key);
    echo "<br>";
    echo  'Your index key: ' . base64_encode($index_key);
    echo "<br>";
?>