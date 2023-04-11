<?php

    session_start();
        
    $user_id = $_SESSION['userid'];

    include_once('../backEnd/dashboard.php');
    include_once('../backEnd/master_logs.php');
    include_once('../backEnd/consent.php');

    $dashboardEntries = '{"events": ' . getDashboard($user_id) . '}';

    // Used to infuse the dashboard entries json into the javascript code.
    echo "<script>var event_data = $dashboardEntries;</script>";




    if(getConsent($user_id)){
        
        // Getting the predicted period
        $next_Period = predict($user_id);

        // Used to infuse the dashboard entries json into the javascript code.
        echo "<script>var nextPredictedPeriod = $next_Period;</script>";
    }

    






    // PHP code for adding entry to back end
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['myData'])){ 

        $data = $_POST["myData"];

        $obj = json_decode($_POST["myData"]);

        if ($obj != null) {
            $mood = $obj->mood;
            $symptoms = $obj->symptoms;
            $note = $obj->note;
            $year = $obj->year;
            $month = $obj->month;
            $date = $obj->day;

            
            // Adding the new entry to the database
            addLog($user_id, $mood, $symptoms, $note, $year, $month, $date);

            echo "<script>console.log('About to go in getConsent' );</script>";
            if(getConsent($user_id)){
                // Copying over to the master database if the user consented.
                addMasterLog($user_id, $mood, $symptoms, $year, $month, $date);
                
            }
        }

        unset($data);
    }



    // PHP code for deleting a specific entry from back end
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['deleteData'])){

        $data = $_POST["deleteData"];

        $obj = json_decode($_POST["deleteData"]);

        if ($obj != null) {
            $year = $obj->year;
            $month = $obj->month;
            $date = $obj->day;

            // Deleting the user's data from the databse
            deleteLog($user_id, $year, $month, $date);

            // Also deleting it from the master database, even if user revoked consent after creating it.
            deleteMasterLog($user_id, $year, $month, $date);
        }

        unset($data);
    }



    // PHP code for updating a specific entry from back end
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateData'])){

        $data = $_POST["updateData"];

        $obj = json_decode($_POST["updateData"]);

        if ($obj != null) {
            $mood = $obj->mood;
            $symptoms = $obj->symptoms;
            $note = $obj->note;
            $year = $obj->year;
            $month = $obj->month;
            $date = $obj->day;

            // Updating the user's entry in the databse
            updateLog($user_id, $mood, $symptoms, $note, $year, $month, $date);
            if(getConsent($user_id)){
                // Also updating the entry in the master database if the user consented.
                updateMasterLog($user_id, $mood, $symptoms, $year, $month, $date);
            }
        }

        unset($data);
    }



    // PHP code for deleting all logs
    if(isset($_POST['eraseData'])) {
        include_once('../backEnd/erasure.php');
  
        // Erase all logs from both databases for that user
        eraseAllLogs($user_id);
        deleteAllMasterLogs($user_id);

        echo "<script> window.location.href = 'dashboard.php'; </script>";
    }



    // PHP code for deleting user account
    if(isset($_POST['eraseAccount'])) {
        include_once('../backEnd/erasure.php');

        // Delete that user's log from the master database, and then call erase account (deletes that user's logs and deletes the user).
        deleteAllMasterLogs($user_id);
        eraseAccount($user_id);

        echo "<script> window.location.href = 'index.php'; </script>";
    }



    // PHP code for deleting all collected data from consenting users
    if(isset($_POST['eraseConsentedData'])){
        deleteAllMasterLogs($user_id);
    }



    // PHP code for logging out
    if(isset($_POST['logout'])) {
        
        // Removing the user id from the session and re-directing
        unset($_SESSION['userid']);
        echo "<script> window.location.href = 'index.php'; </script>";
    }



    // PHP code for updating consent
    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateConsent'])){

        $data = $_POST["updateConsent"];

        $obj = json_decode($_POST["updateConsent"]);

        if ($obj != null) {
            $updatedConsent = $obj->consent;
            
            updateConsent($user_id, $updatedConsent);

            // If the user opted-out of sending us data (rescinded consent), delete the data we collected
            if($updatedConsen == false){
                deleteAllMasterLogs($user_id);
            }
        }

        unset($data);
    }



    if(getConsent($user_id)){
        
        // If user consents, infuse the value into javascript
        echo "<script>var consent = true;</script>";
    }
    else{
        echo "<script>var consent = false;</script>";
    }

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="./css/style.css" rel="stylesheet">
    
    </head>
    <body style="background: #f8f9fd;">

        <!-- Nav Bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
            <div class="container-fluid">

                <!-- Left side of nav-bar -->
                <a class="navbar-brand" href="#">
                    <img src="./images/branding-icon.png" alt="Blood Droplet Icon" width="30" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Links to pages. Collapses into hamburger menu on smaller screens. -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="./index-logged-in.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./privacy-policy-logged-in.php">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                    </ul>


                    
                    <!-- Right side of nav-bar -->
                    <form class="" method="post">
                        <!-- Button trigger offcanvas menu -->
                        <input type="button" class="btn btn-dark" onclick="myFunction()" value="Settings" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"/>                    

                        <!-- Button for logging out-->
                        <input type="submit" name="logout" class="btn btn-primary" style="background-color:#F53664!important; border-color: #F53664;" value="Log Out" />                    
                    </form>
                </div>
            </div>
        </nav>

        
        
        <!-- Settings Menu -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasExampleLabel">Settings</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body">

                <!-- Consent Section -->
                <div style="padding: 3%">
                    <p>Here you can manage your consent, delete your data, or delete your account. Note that any delete actions you undertake are irreversible. Once you delete something, IT IS GONE!</p>
                </div>

                <div style="padding: 3%">
                    <h3>Manage Consent</h3>
                    <p>The switch below displays your consent to sending your data to you for more in-depth statistics and analysis.</p>
                    <p>If you'd like to rescind your consent just turn off the switch.</p>
                    
                    <form method="post">
                        <div class="form-check form-switch" style="padding-top: 3%">
                            <input class="form-check-input" type="checkbox" role="switch" id="consentSwitch" style="background-color: #F53664; width: 45px !important; height: 21px !important;" onChange="this.form.submit()">
                            <label class="form-check-label" for="consentSwitch" style="padding-left: 3%">I consent</label>
                        </div>
                    </form>

                    <!-- Consent-Related Data Management Section -->
                    <form method="post">
                        <h5>Delete All The Data We've Collected (with your consent)</h5>
                        <input type="submit" name="eraseConsentedData" class="btn btn-warning" value="Delete All Collected Data" />
                    </form>
                </div>

              <br>

                <!-- Data management Section -->
                <form method="post">
                    <div style="padding: 3%">
                        <h3>Delete All Your Data</h3>
                        <input type="submit" name="eraseData" class="btn btn-warning" value="Delete All Data" />
                    </div>

                    <div style="padding: 3%">
                        <h3>Delete Your Account</h3>
                        <input type="submit" name="eraseAccount" class="btn btn-warning" value="Delete Your Account" />
                    </div>
                    
                </form>

            </div>
        </div>


        <!-- Hero Section (In this case, the Calendar) -->
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content w-100">
                            <div class="calendar-container" style="box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px; border-radius: 15px;">
                                <div class="calendar"> 
                                
                                <!-- Year Selection -->
                                <div class="year-header"> 
                                    <span class="left-button fa fa-chevron-left" id="prev"><</span> 
                                    <span class="year" id="label"></span> 
                                    <span class="right-button fa fa-chevron-right" id="next">></span>
                                </div> 

                                <!-- Month Selection -->
                                <table class="months-table w-100"> 
                                    <tbody>
                                    <tr class="months-row">
                                        <td class="month">Jan</td> 
                                        <td class="month">Feb</td> 
                                        <td class="month">Mar</td> 
                                        <td class="month">Apr</td> 
                                        <td class="month">May</td> 
                                        <td class="month">Jun</td> 
                                        <td class="month">Jul</td>
                                        <td class="month">Aug</td> 
                                        <td class="month">Sep</td> 
                                        <td class="month">Oct</td>          
                                        <td class="month">Nov</td>
                                        <td class="month">Dec</td>
                                    </tr>
                                    </tbody>
                                </table> 
                                
                                <!-- Day Selection -->
                                <table class="days-table w-100"> 
                                    <td class="day">Sun</td> 
                                    <td class="day">Mon</td> 
                                    <td class="day">Tue</td> 
                                    <td class="day">Wed</td> 
                                    <td class="day">Thu</td> 
                                    <td class="day">Fri</td> 
                                    <td class="day">Sat</td>
                                </table> 

                                <!-- Dates Section. All dates get loaded into this frame by the javascript.  -->
                                <div class="frame"> 
                                    <table class="dates-table w-100"> 
                                    <tbody class="tbody">             
                                    </tbody> 
                                    </table>
                                </div> 

                                <!-- Entry Management Buttons -->
                                <button class="btn btn-warning" id="delete-button" style="visibility:hidden" >Delete Entry</button>
                                <button class="btn btn-primary" id="edit-button" style="visibility:hidden">Edit Entry</button>
                                <button class="btn btn-primary" id="add-button" style="background-color:#F53664!important; border-color: #F53664;">Add Entry</button>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="events-container container col-xxl-8 px-4 py-5">
                </div>


                <!-- Entry Creation Form -->
                <div class="dialog" id="dialog">
                    <form id="mood-form"  method="post" action="">
                        <div class="event-card row flex-lg g-5 py-5" style="display:flex; padding: 20px!important; margin:0px!important;">
                            <div class="col-12 col-sm-12 col-lg-6" style="margin-top:0px!important; padding:0px!important; padding-bottom: 20px!important;">
                                <div class="vstack gap-5">

                                    <!-- Mood Selection -->
                                    <div class="vstack gap-2">
                                        <h4>Mood</h4>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <div class="vstack align-items-center">
                                                    <div><img src="./images/moods/Happy.png" class="img-fluid" alt="Test" style="width: 60px;"></div>
                                                    <div><p>Happy</p></div>
                                                    <div>
                                                        <input class="form-check-input" type="radio" name="mood" id="Happy" value="happy" aria-label="Happy Mood Button">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <div class="vstack align-items-center">
                                                    <div><img src="./images/moods/Sad.png" class="img-fluid" alt="Test" style="width: 60px;"></div>
                                                    <div><p>Sad</p></div>
                                                    <div>
                                                        <input class="form-check-input" type="radio" name="mood" id="Sad" value="sad" aria-label="Sad Mood Button">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <div class="vstack align-items-center">
                                                    <div><img src="./images/moods/Angry.png" class="img-fluid" alt="Test" style="width: 60px;"></div>
                                                    <div><p>Angry</p></div>
                                                    <div>
                                                        <input class="form-check-input" type="radio" name="mood" id="Angry" value="angry" aria-label="Angry Mood Button">
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <div class="vstack align-items-center">
                                                    <div><img src="./images/moods/Anxious.png" class="img-fluid" alt="Test" style="width: 60px;"></div>
                                                    <div><p>Anxious</p></div>
                                                    <div>
                                                        <input class="form-check-input" type="radio" name="mood" id="Anxious" value="anxious" aria-label="Anxious Mood Button">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>


                                    <!-- Symptoms Selection -->
                                    <div class="vstack gap-2">
                                        <h4>Symptoms</h4>
                                        <div class="vstack gap-3">
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Spotting.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Spotting</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Spotting" value="spotting" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Hunger.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Hunger</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Hunger" value="hunger" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Ovulation-pain.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Ovu Pain</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Ovulation-pain" value="ovulation-pain" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Diarrhea.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Diarrhea</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Diarrhea" value="diarrhea" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Acne.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Acne</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Acne" value="acne" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Irritability.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Irritability</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Irritability" value="irritability" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Bloated.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Bloated</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Bloated" value="bloated" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <div class="vstack align-items-center">
                                                        <div><img src="./images/symptoms/Gas.png" class="img-fluid" alt="Test" style="height: 60px;"></div>
                                                        <div><p>Gas</p></div>
                                                        <div>
                                                            <input class="form-check-input" type="checkbox" name="symptoms" id="Gas" value="gas" aria-label="...">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>


                            <!-- Note Entry -->
                            <div class="col-lg-6" style="margin-top:0px!important; padding:0px!important;">
                                <h4> Notes</h4>
                                <textarea class="form-control" name="note" style="background-color: #FFF6FE; height: 300px;"" placeholder="Write down your thoughts and feelings..." id="note"></textarea>
                                
                                <!-- Form Buttons -->
                                <div style="padding-top:30px;">
                                    <input type="button" value="Cancel" class="btn btn-danger" id="cancel-button" style="color: white;">
                                    <input type="button" value="OK" class="btn btn-success" id="ok-button">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Scripts Import -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
