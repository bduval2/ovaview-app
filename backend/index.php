<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
    </head>

    <body>

    <h1> Testing Database Encryption </h1>

    <?php
        // Establish connection to database
        include('key/config.php');
        
        // Get encryption methods
        include('crypt.php');

        // Encrypt user ID
        $user_id = 345366777;
        $user_crypt = password_hash($user_id, PASSWORD_DEFAULT);

        // Encrypt entry
        $entry = 'boom boom';
        $entry_crypt = encrypt($entry, $user_id);

        // Insert user log into database
        //$conn->query("insert into logs (id_crypt, entry) values ('$user_crypt', '$entry_crypt');");
        
         // Get and decrypt all user logs
        $user_logs = $conn->query("SELECT * FROM logs;");
        foreach ($user_logs as $log) {
            echo "here1";
            if (password_verify($user_id, $log['id_crypt']))
            {
                // TODO: Add all logs
                echo "here";
                echo decrypt($log['entry'], $user_id);
                echo "<br>";
            }
            
        }
        
        // Close the database connection
        $conn = null;
    ?>

    </body>
</html>
