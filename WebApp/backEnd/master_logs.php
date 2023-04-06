<?php
    // generate values using ./generate_key.php script
    $private_key = "q2wLpF1k+UMNmSzrbGUuAQ=="; // INSERT PRIVATE KEY HERE
    $index_key = "u885cb0FBSy1Im/LooSMMg=="; // INSERT BLIND INDEX KEY HERE
    
    include_once('class.database.php');
    include_once('crypt.php');
    
    function addMasterLog($user_id, $mood, $symptoms, $note, $year, $month, $date) {
        global $private_key;
        global $index_key;
       
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $user_crypt = getIDBlindIndex($user_id, $index_key);
        $mood_crypt = encrypt($mood, $private_key);
        $symptoms_crypt = encrypt($symptoms, $private_key);
        $note_crypt = encrypt($note, $private_key);
        $year_crypt = encrypt($year, $private_key);
        $month_crypt = encrypt($month, $private_key);
        $date_crypt = encrypt($date, $private_key);
        
        $conn->query("insert into master_logs (id_crypt, mood, symptoms, note, year, month, day) values ('$user_crypt', '$mood_crypt', '$symptoms_crypt', '$note_crypt', '$year_crypt', '$month_crypt', '$date_crypt');");
    }

    function updateMasterLog($user_id, $mood, $symptoms, $note, $year, $month, $date) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs for that day
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $user_logs = $conn->query("SELECT * FROM master_logs WHERE id_crypt = '$id_crypt';");
        foreach ($user_logs as $log) {
            $old_year_crypt = $log['year'];
            $old_month_crypt = $log['month'];
            $old_date_crypt = $log['day'];
            if ( $date == decrypt($old_date_crypt, $private_key) and 
                 $month == decrypt($old_month_crypt, $private_key) and 
                 $year == decrypt($old_year_crypt, $private_key)) {
                    
                // Update the log
                $mood_crypt = encrypt($mood, $private_key);
                $symptoms_crypt = encrypt($symptoms, $private_key);
                $note_crypt = encrypt($note, $private_key);

                $conn->query("UPDATE master_logs SET mood = '$mood_crypt',
                                                     symptoms = '$symptoms_crypt',
                                                     note = '$note_crypt'
                                           WHERE id_crypt = '$id_crypt'
                                                 and year = '$old_year_crypt' 
                                                 and month = '$old_month_crypt'
                                                 and day =  '$old_date_crypt';");
                break;
            }
        }
    }

    function deleteMasterLog($user_id, $year, $month, $date) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs for that day
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $user_logs = $conn->query("SELECT * FROM master_logs WHERE id_crypt = '$id_crypt';");
        foreach ($user_logs as $log) {
            $old_year_crypt = $log['year'];
            $old_month_crypt = $log['month'];
            $old_date_crypt = $log['day'];
            if ( $date == decrypt($old_date_crypt, $private_key) and 
                 $month == decrypt($old_month_crypt, $private_key) and 
                 $year == decrypt($old_year_crypt, $private_key)) {
                // Delete the log
                $conn->query("DELETE FROM master_logs WHERE id_crypt = '$id_crypt'
                                                            and year = '$old_year_crypt' 
                                                            and month = '$old_month_crypt'
                                                            and day =  '$old_date_crypt';");
                 break;
            }
        }
    }

    function deleteAllMasterLogs($user_id) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs for that day
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $conn->query("DELETE FROM master_logs WHERE id_crypt = '$id_crypt';");   
    }

    // Test
    function printMasterLogs($user_id) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        echo 'Logs for user ' . $user_id ;
        echo '<br>';

        // Find corresponding user logs for that day
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $user_logs = $conn->query("SELECT * FROM master_logs WHERE id_crypt = '$id_crypt';");
        foreach ($user_logs as $log) {
            $year = decrypt($log['year'], $private_key);
            $month = decrypt($log['month'], $private_key);
            $day = decrypt($log['day'], $private_key);
            $mood = decrypt($log['mood'], $private_key);
            $symptoms = decrypt($log['symptoms'], $private_key);
            $note = decrypt($log['note'], $private_key);
            echo '{' . $year . ', ' . $month . ', ' . $day . ', ' . $mood . ', ' . $symptoms . ', ' . $note . '}';
            echo '<br>';
        }
    }

    function testAddMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                         
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                        
        addMasterLog(423524213214, "Anxious", "Ovu Pain Gas Irritability", "another user", 2023, 3, 6);                        
        printMasterLogs(6022449822463324);
        printMasterLogs(423524213214);
    }

    function testUpdateMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                          
        printMasterLogs(6022449822463324);
        updateMasterLog(6022449822463324, "Sad", "Hunger Spotting", "Nevermind", 2023, 3, 27);
        printMasterLogs(6022449822463324);
    }

    function testDeleteMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                          
        printMasterLogs(6022449822463324);
        deleteMasterLog(6022449822463324, 2023, 3, 27);
        printMasterLogs(6022449822463324);

    }

?>

