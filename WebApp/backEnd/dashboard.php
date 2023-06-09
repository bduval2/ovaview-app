<?php
    // Logs table manipulation helpers

    include_once('class.database.php');
    include_once('crypt.php');

    /*
	* Pull all data entries for the user associated to the user_id account.
    *
    * @param string $user_id This is the 16-digit user identifier
    * @return string JSON representation of all user entries.
	*/
    function getDashboard($user_id) {
        $events = array();
        
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $user_logs = $conn->query("SELECT * FROM logs;");
        foreach ($user_logs as $log) {
            if (password_verify($user_id, $log['id_crypt'])) {
                $event = array (
                    "mood" => decrypt($log['mood'], $user_id),
                    "symptoms" => decrypt($log['symptoms'], $user_id),
                    "note" => decrypt($log['note'], $user_id),
                    "year" => intval(decrypt($log['year'], $user_id)),
                    "month" => intval(decrypt($log['month'], $user_id)),
                    "day" => intval(decrypt($log['day'], $user_id))
                );
                $events[] = $event;
            }
        }

        return json_encode($events);
    }

    /*
	* Add a log the the logs table.
    *
    * @param string $user_id User for which we want to add an entry
    * @param string $mood
    * @param string $symptoms
    * @param string $note
    * @param string $year
    * @param string $month
    * @param string $date
	*/
    function addLog($user_id, $mood, $symptoms, $note, $year, $month, $date) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 
        
        // Encrypt and hash all data
        $user_crypt = password_hash($user_id, PASSWORD_DEFAULT);
        $mood_crypt = encrypt($mood, $user_id);
        $symptoms_crypt = encrypt($symptoms, $user_id);
        $note_crypt = encrypt($note, $user_id);
        $year_crypt = encrypt($year, $user_id);
        $month_crypt = encrypt($month, $user_id);
        $date_crypt = encrypt($date, $user_id);
        
        // Add entry to the database
        $conn->query("insert into logs (id_crypt, mood, symptoms, note, year, month, day) values ('$user_crypt', '$mood_crypt', '$symptoms_crypt', '$note_crypt', '$year_crypt', '$month_crypt', '$date_crypt');");
    }

    /*
	* Updates a log in the logs table.
    *
    * @param string $user_id User for which we want to update an entry
    * @param string $mood Updated mood
    * @param string $symptoms Updated symtoms
    * @param string $note Updates note
    * @param string $year 
    * @param string $month
    * @param string $date
	*/
    function updateLog($user_id, $mood, $symptoms, $note, $year, $month, $date) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs
        $user_logs = $conn->query("SELECT * FROM logs;");
        foreach ($user_logs as $log) {
            $id_crypt = $log['id_crypt'];
            if (password_verify($user_id, $id_crypt)) {
                // Find the log to update
                $old_year_crypt = $log['year'];
                $old_month_crypt = $log['month'];
                $old_date_crypt = $log['day'];
                if (    $date == decrypt($old_date_crypt, $user_id) and 
                        $month == decrypt($old_month_crypt, $user_id) and 
                        $year == decrypt($old_year_crypt, $user_id)) {
                    
                    // Update the log
                    $mood_crypt = encrypt($mood, $user_id);
                    $symptoms_crypt = encrypt($symptoms, $user_id);
                    $note_crypt = encrypt($note, $user_id);
                    
                    $conn->query("UPDATE logs SET mood = '$mood_crypt',
                                                  symptoms = '$symptoms_crypt',
                                                  note = '$note_crypt'
                                               WHERE
                                                   id_crypt = '$id_crypt'
                                                   and year = '$old_year_crypt' 
                                                   and month = '$old_month_crypt'
                                                   and day =  '$old_date_crypt';");
                    break;
                }
            }
        }
    }

    /*
	* Deletes a log from the logs table for a given date.
    *
    * @param string $user_id User for which we want to delete an entry
    * @param string $year 
    * @param string $month
    * @param string $date
	*/
    function deleteLog($user_id, $year, $month, $date) {
          // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user logs
        $user_logs = $conn->query("SELECT * FROM logs;");
        foreach ($user_logs as $log) {
            $id_crypt = $log['id_crypt'];
            if (password_verify($user_id, $id_crypt)) {
                // Find the log to delete
                $old_year_crypt = $log['year'];
                $old_month_crypt = $log['month'];
                $old_date_crypt = $log['day'];
                if (    $date == decrypt($old_date_crypt, $user_id) and 
                        $month == decrypt($old_month_crypt, $user_id) and 
                        $year == decrypt($old_year_crypt, $user_id)) {
                    
                    // Delete the log
                    $conn->query("DELETE FROM logs WHERE
                                                   id_crypt = '$id_crypt'
                                                   and year = '$old_year_crypt' 
                                                   and month = '$old_month_crypt'
                                                   and day =  '$old_date_crypt';");
                    break;
                }
            }
        }  
    }

     // TESTS
    function testGetDashboard()
    {
        addLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                          

        echo getDashboard(6022449822463324);
    }

    function testUpdateLog() {
        addLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                          

        echo getDashboard(6022449822463324);
        echo "<br>";
        updateLog(6022449822463324, "Sad", "Hunger Spotting", "Nevermind", 2023, 3, 27);
        echo "<br>";
        echo getDashboard(6022449822463324);

    }

    function testDeleteLog() {
        addLog(6022449822463324, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addLog(6022449822463324, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addLog(6022449822463324, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addLog(6022449822463324, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system", 2023, 3, 6);                          

        echo getDashboard(6022449822463324);
        echo "<br>";
        deleteLog(6022449822463324, 2023, 3, 27);
        echo "<br>";
        echo getDashboard(6022449822463324);
    }
?>

