<?php
    // Master logs table manipulation helpers

    /*
    * !!!
	* We recognize this method of storing keys is not safe and users are able to 
    * access them and therefore could read the master_logs table.
    * !!!
	*/
    // Generate values using ./generate_key.php script
    $private_key = ""; // INSERT PRIVATE KEY HERE
    $index_key = ""; // INSERT BLIND INDEX KEY HERE
    
    include_once('class.database.php');
    include_once('crypt.php');
    
    /*
	* Add a log the the master logs table.
    *
    * @param string $user_id User for which we want to add an entry
    * @param string $mood
    * @param string $symptoms
    * @param string $note
    * @param string $year
    * @param string $month
    * @param string $date
	*/
    function addMasterLog($user_id, $mood, $symptoms, $year, $month, $date) {
        global $private_key;
        global $index_key;
       
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Encrypt and hash all data.
        $user_crypt = getIDBlindIndex($user_id, $index_key);
        $mood_crypt = encrypt($mood, $private_key);
        $symptoms_crypt = encrypt($symptoms, $private_key);
        $year_crypt = encrypt($year, $private_key);
        $month_crypt = encrypt($month, $private_key);
        $date_crypt = encrypt($date, $private_key);
        
        // Add entry to the database
        $conn->query("insert into master_logs (id_crypt, mood, symptoms, year, month, day) values ('$user_crypt', '$mood_crypt', '$symptoms_crypt', '$year_crypt', '$month_crypt', '$date_crypt');");
    }

    /*
	* Updates a log in the master logs table.
    *
    * @param string $user_id User for which we want to update an entry
    * @param string $mood Updated mood
    * @param string $symptoms Updated symtoms
    * @param string $note Updates note
    * @param string $year 
    * @param string $month
    * @param string $date
	*/
    function updateMasterLog($user_id, $mood, $symptoms, $year, $month, $date) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs for that day
        $idcrypt = getIDBlindIndex($user_id, $index_key);
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

                $conn->query("UPDATE master_logs SET mood = '$mood_crypt',
                                                     symptoms = '$symptoms_crypt'
                                           WHERE id_crypt = '$id_crypt'
                                                 and year = '$old_year_crypt' 
                                                 and month = '$old_month_crypt'
                                                 and day =  '$old_date_crypt';");
                break;
            }
        }
    }

    /*
	* Deletes a log from the master logs table for a given date.
    *
    * @param string $user_id User for which we want to delete an entry
    * @param string $year 
    * @param string $month
    * @param string $date
	*/
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

    /*
	* Deletes all logs from the logs table for a given user.
    *
    * @param string $user_id User for which we want to delete all logs
	*/
    function deleteAllMasterLogs($user_id) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Delete logs 
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $conn->query("DELETE FROM master_logs WHERE id_crypt = '$id_crypt';");   
    }

    /*
	* Predicts the next start date of menstruations using the master logs table
    *
    * @param string $user_id User for which we want to make a prediction
    * @return array Array containing the year, month and day of the predicted next period.
	*/
    function predict($user_id) {
        global $private_key;
        global $index_key;
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Get all user logs
        $id_crypt = getIDBlindIndex($user_id, $index_key);
        $user_logs = $conn->query("SELECT * FROM master_logs WHERE id_crypt = '$id_crypt';");
 
        // Find most recent entry
        $most_recent_date = strtotime("0-0-0");

        // Get all user entry dates and compare them to the most recent one
        foreach ($user_logs as $log) {
            $year = decrypt($log['year'], $private_key);
            $month = decrypt($log['month'], $private_key);
            $day = decrypt($log['day'], $private_key);
            $curr_date = strtotime("$year-$month-$day");
            
            if ( $curr_date > $most_recent_date ) {  
                $most_recent_date = $curr_date;
            }
        }

        $most_recent_date = strtotime("+1 month", $most_recent_date);

        $most_recent_year = date("Y", $most_recent_date) ." "; 
        $most_recent_month = date("m", $most_recent_date)." "; 
        $most_recent_day = date("d", $most_recent_date); 
        
        $periodDate = array(
            "year" => $most_recent_year,
            "month" => $most_recent_month,
            "day" => $most_recent_day
        );

        return json_encode($periodDate);
    }

     // TESTS
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
            echo '{' . $year . ', ' . $month . ', ' . $day . ', ' . $mood . ', ' . $symptoms . '}';
            echo '<br>';
        }
    }

    
    function testPredict() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", 2023, 5, 15);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", 2023, 5, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", 2023, 2, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 6, 8);                         
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 4, 7);                        
        addMasterLog(423524213214, "Anxious", "Ovu Pain Gas Irritability", 2021, 3, 6);                        
        $date = predict(6022449822463324);
        echo $date["year"] . " " . $date["month"] . " " . $date["day"];
    }

    function testAddMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", 2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", 2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", 2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 3, 6);                         
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 3, 6);                        
        addMasterLog(423524213214, "Anxious", "Ovu Pain Gas Irritability", 2023, 3, 6);                        
        printMasterLogs(6022449822463324);
        printMasterLogs(423524213214);
    }

    function testUpdateMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated", 2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea", 2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting", 2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 3, 6);                          
        printMasterLogs(6022449822463324);
        updateMasterLog(6022449822463324, "Sad", "Hunger Spotting",  2023, 3, 27);
        printMasterLogs(6022449822463324);
    }

    function testDeleteMasterLog() {
        addMasterLog(6022449822463324, "Happy", "Hunger Acne Bloated",2023, 3, 20);
        addMasterLog(6022449822463324, "Sad", "Gas Diarrhea",2023, 3, 14);
        addMasterLog(6022449822463324, "Angry", "Bloated Spotting",  2023, 3, 27);
        addMasterLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", 2023, 3, 6);                          
        printMasterLogs(6022449822463324);
        deleteMasterLog(6022449822463324, 2023, 3, 27);
        printMasterLogs(6022449822463324);

    }
?>

