<?php
	// Encryption helpers

    /*
	Encrypts data using some key

    @param string $data
    @param string $key Encryption key
    @return string Encrypted data
	*/
    function encrypt($data, $key) {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
    
    /*
	Decrypt data using some key

    @param string $data Encrypted data
    @param string $key Encryption key
    @return string Decrypted data
	*/
    function decrypt($data, $key) {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($data), 2),2,null);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    /*
	Get a blind index given a user ID and an index key. 

    @param string $user_id The user index
    @param string $index_key The input key must be of size SODIUM_CRYPTO_PWHASH_SALTBYTES
	@return string Blind index for the input ID
    */
    function getIDBlindIndex(string $user_id, string $index_key): string {
        $key = base64_decode($index_key);
        return bin2hex(
            sodium_crypto_pwhash(
                32,
                $user_id,
                $key,
                SODIUM_CRYPTO_PWHASH_OPSLIMIT_MODERATE,
                SODIUM_CRYPTO_PWHASH_MEMLIMIT_MODERATE
            )
        );
    }
?>