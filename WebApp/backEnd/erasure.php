<?php
    // Account and logs deletion helpers

    include_once('class.database.php');
    include_once('crypt.php');
    include_once('dashboard.php');
    include_once('entry.php');

    /*
	Erase all logs for the input user

    @param string $user_id 
	*/
    function eraseAllLogs($user_id) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Retrieve all logs that belong that belong to this user in the logs table
        $id_crypts = array();
        $user_logs = $conn->query("SELECT * FROM logs;");
        foreach ($user_logs as $log) {
            $id_crypt = $log['id_crypt'];
            if (password_verify($user_id, $id_crypt)) {
                $id_crypts[] = $id_crypt;   
            }
        }
        // Delete all logs from table
        $id_crypts = "('" . implode("','", $id_crypts) . "')";
        $conn->query("DELETE FROM logs where id_crypt IN " . $id_crypts . ";");  
    }

    /*
	Erase user from users table and all logs for the input user

    @param string $user_id 
	*/
    function eraseAccount($user_id) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $users = $conn->query("SELECT * FROM users;");
        foreach ($users as $user) {
            $id_crypt = $user['id_crypt'];
            if (password_verify($user_id, $id_crypt)) {
                $conn->query("DELETE FROM users where id_crypt = '$id_crypt' ;");   
                break;
            }
        }

        eraseAllLogs($user_id);
    }

    // TESTS
    function testErrasure()
    {
        $user_id = register() ;
        $user_id = 1345;
        addLog($user_id, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addLog($user_id, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addLog($user_id, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addLog($user_id, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depen", 2023, 3, 6);

        $user_id2 = register() ;
        addLog($user_id2, "Happy", "Hunger Acne Bloated", "1", 2023, 3, 20);
        addLog($user_id2, "Sad", "Gas Diarrhea", "2", 2023, 3, 14);
        addLog($user_id2, "Angry", "Bloated Spotting", "3", 2023, 3, 27);
        addLog($user_id2, "Anxious", "Ovu Pain Gas Irritability", "4", 2023, 3, 6);

        echo getDashboard($user_id);  
        echo "<br>";       
        echo getDashboard($user_id2);  
        echo "<br>";              
        eraseAll($user_id);
        echo getDashboard($user_id);
        echo "<br>";       
        echo getDashboard($user_id2);  
    }
    

?>

