<?php
    // Sign up and register helpers

    include_once('class.database.php');
    include_once('crypt.php');

    /*
	Checks if the input ID exists.

    @param string $user_id
    @return boolean True if the ID exists, false otherwise
	*/
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

    /*
	Authenticates a user

    @param string $user_id
    @return boolean True if the ID exists, false otherwise
	*/
    function auth($user_id) {  
        return exists($user_id);
    }

    /*
	Produces a random 16-digit identifier

    @return int
	*/
    function rand_16dig_int()
    {
        return rand ( 1000000000000000, 9999999999999999 );
    }

    /*
	Register a new user. Creates a new UID for that user and add it to the users table.

    @param boolean $consent True if the user gave their consent for data processing
    @return int The UID
	*/
    function register($consent = FALSE) {
    // consent: - true/yes/1 if user consents to their data being processed
    //          - false/no/0 if user does not give their consent
    
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Generate new user ID
        $user_id = rand_16dig_int();
        $exists = exists($user_id);
        while ($exists) {
            $user_id = rand_16dig_int();
            $exists = exists($user_id);
        }

        // Encrypt
        $user_crypt =  password_hash($user_id, PASSWORD_DEFAULT);
        $consent_crypt = encrypt($consent, $user_id);
        
        // Add new user to users table
        $conn->query("insert into users (id_crypt, consent) values ('$user_crypt', '$consent_crypt');");
        return $user_id;
    }

     // TESTS
    function testRegisterAuth()
    {
        $user_id = register();
        echo $user_id;
        echo "<br>";
        echo auth($user_id);
    }

?>