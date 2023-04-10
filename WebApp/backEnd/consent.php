<?php
    // Helper methods to get and update consent

    include_once('class.database.php');
    include_once('crypt.php');

    /*
	* Get consent of a given user.
    *
    * @param string $user_id User for which we want to get consent
	*/
    function getConsent($user_id) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        $users = $conn->query("SELECT * FROM users;");
        foreach ($users as $user) {
            if (password_verify($user_id, $user['id_crypt'])) {
                $consent = decrypt($user['consent'], $user_id);
                break;
            }
        }

        // Returns a boolean, true if user consents, false otherwise
        return filter_var($consent, FILTER_VALIDATE_BOOLEAN);
    }

    /*
	* Update consent for a given user.
    *
    * @param string $user_id User for which we want to update consent
    * @param boolean $consent Updated consent
	*/
    function updateConsent($user_id, $consent) {
        // Get connection to database
        $db = Database::getInstance();
        $conn = $db->getConnection(); 

        // Find corresponding user
        $users = $conn->query("SELECT * FROM users;");
        foreach ($users as $user) {
            $id_crypt = $user['id_crypt'];
            if (password_verify($user_id, $id_crypt)) {
                // Update consent
                $consent_crypt = encrypt($consent, $user_id);
                $conn->query("UPDATE users SET consent = '$consent_crypt'
                                          WHERE id_crypt = '$id_crypt';");
                break;
            }
        }
    }

    // TESTS
    function unit_testGetConsent($expectedOutput, $consent) {
        include_once('entry.php');
        $user = register($consent);
        echo "This should output " . $expectedOutput . ':';
        echo '<br>';
        echo getConsent($user);
        echo '<br>';
    }
    
    
    function testGetConsent()
    {
        unit_testGetConsent('1', TRUE);
        unit_testGetConsent('1', 'true');
        unit_testGetConsent('1', 'yes');
        unit_testGetConsent('1', 1);
        unit_testGetConsent('nothing', FALSE);
        unit_testGetConsent('nothing', 'false');
        unit_testGetConsent('nothing', 'no');
        unit_testGetConsent('nothing', 0);
    }

    function unit_testUpdateConsent($expectedOutput, $updated_consent)
    {
        include_once('entry.php');
        $user = register(rand(0,1));
        echo 'Initial consent:';
        echo '<br>';
        echo getConsent($user);
        echo '<br>';
        echo "New consent should be " . $expectedOutput . ':';
        echo '<br>';
        updateConsent($user, $updated_consent);
        echo getConsent($user);
        echo '<br>';
    }
    
    function testUpdateConsent()
    {
        unit_testUpdateConsent('1', TRUE);
        unit_testUpdateConsent('1', 'true');
        unit_testUpdateConsent('1', 'yes');
        unit_testUpdateConsent('1', 1);
        unit_testUpdateConsent('nothing', FALSE);
        unit_testUpdateConsent('nothing', 'false');
        unit_testUpdateConsent('nothing', 'no');
        unit_testUpdateConsent('nothing', 0);
    }

?>

