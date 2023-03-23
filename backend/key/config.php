<?php
        // Establish connection to database
        $conn = new PDO('sqlite:periodTracking.db');
        if ($conn != null) {
            echo 'Successfully connected to the SQLite database.';
            echo "<br>";
        }
        else {
            echo 'Could not connect to the SQLite database.';
        }

        $master_key = '115792089237316195423570985008687907853269984665640564039457584007913129639936';
?>