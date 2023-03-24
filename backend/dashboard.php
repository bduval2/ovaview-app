<?php

    include_once('class.database.php');
    include_once('crypt.php');

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

    function addLog($user_id, $mood, $symptoms, $note, $year, $month, $date) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 
        
        $user_crypt = password_hash($user_id, PASSWORD_DEFAULT);
        $mood_crypt = encrypt($mood, $user_id);
        $symptoms_crypt = encrypt($symptoms, $user_id);
        $note_crypt = encrypt($note, $user_id);
        $year_crypt = encrypt($year, $user_id);
        $month_crypt = encrypt($month, $user_id);
        $date_crypt = encrypt($date, $user_id);
        
        $conn->query("insert into logs (id_crypt, mood, symptoms, note, year, month, day) values ('$user_crypt', '$mood_crypt', '$symptoms_crypt', '$note_crypt', '$year_crypt', '$month_crypt', '$date_crypt');");
    }

    // Test
    function testDashboard()
    {
        $user_id = 8201102724502253;
        addLog(8201102724502253, "Happy", "Hunger Acne Bloated", "I won TWO contests today.", 2023, 3, 20);
        addLog(8201102724502253, "Sad", "Gas Diarrhea", "Hi hello what is up loser.", 2023, 3, 14);
        addLog(8201102724502253, "Angry", "Bloated Spotting", "Bim Bap.", 2023, 3, 27);
        addLog(8201102724502253, "Anxious", "Ovu Pain Gas Irritability", "he maximum value depends on the system. 
                                    //32 bit systems have a maximum signed integer range of -2147483648 to 2147483647. 
                                    //So for example on such a system, intval('1000000000000') will return 2147483647. 
                                    //The maximum signed integer value for 64 bit systems is 9223372036854775807.", 2023, 3, 6);                          

        echo getDashboard($user_id);
    }
    

?>

