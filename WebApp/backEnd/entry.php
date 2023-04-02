<?php

    include_once('class.database.php');
    include_once('crypt.php');

    function exists($user_id) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $success = false;

        $users = $conn->query("SELECT * FROM users;");
        foreach ($users as $user) {
            if (password_verify($user_id, $user['id_crypt'])) {
                $success = true;
                break;
            }
        }

        return $success;
    }

    function auth($user_id) {  
        return exists($user_id);
    }

    function rand_16dig_int()
    {
        return rand ( 1000000000000000, 9999999999999999 );
    }

    function register($consent = FALSE) {
    // consent: - true/yes/1 if user consents to their data being processed
    //          - false/no/0 if user does not give their consent
    
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Generate new user ID
        $user_id = rand_16dig_int();
        while (exists($user_id)) {
            $user_id = rand_16dig_int();
        }

        // Encrypt
        $user_crypt =  password_hash($user_id, PASSWORD_DEFAULT);
        $consent_crypt = encrypt($consent, $user_id);
        
        $conn->query("insert into users (id_crypt, consent) values ('$user_crypt', '$consent_crypt');");
        return $user_id;
    }

    // Test
    function testRegisterAuth()
    {
        $user_id = register();
        echo $user_id;
        echo "<br>";
        echo auth($user_id);
    }

?>