<?php

    include('class.database.php');
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

    function register() {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $user_id = rand_16dig_int();
        while (exists($user_id)) {
            $user_id = rand_16dig_int();
        }

        $user_crypt =  password_hash($user_id, PASSWORD_DEFAULT);
        $conn->query("insert into users (id_crypt) values ('$user_crypt');");
        return $user_id;
    }

    // Test
    $user_id = register();
    echo $user_id;
    echo "<br>";
    echo auth($user_id);

?>