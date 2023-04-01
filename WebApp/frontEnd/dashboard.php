<?php

    session_start();
        
    $user_id = $_SESSION['userid'];

    include_once('../backEnd/dashboard.php');

    $dashboardEntries = '{"events": ' . getDashboard($user_id) . '}';

    echo "<script>var event_data = $dashboardEntries;</script>";

    if(!empty($_POST) && $_SERVER['REQUEST_METHOD'] == 'POST'){


        $data = $_POST["myData"];

        $obj = json_decode($_POST["myData"]);

        $mood = $obj->mood;
        $symptoms = $obj->symptoms;
        $note = $obj->note;
        $year = $obj->year;
        $month = $obj->month;
        $date = $obj->day;

            
        addLog($user_id, $mood, $symptoms, $note, $year, $month, $date);


        unset($data);
    }


    // PHP code for deleting all logs
    if(isset($_POST['eraseData'])) {
        include_once('../backEnd/erasure.php');
  
        eraseAllLogs($user_id);

        echo "<script> window.location.href = 'dashboard.php'; </script>";
    }

    // PHP code for deleting user account
    if(isset($_POST['eraseAccount'])) {
        include_once('../backEnd/erasure.php');

        eraseAccount($user_id);

        echo "<script> window.location.href = 'index.php'; </script>";
    }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        .bg-primary {
        background: #fc7fb2 !important; }

        .ftco-section {
        padding-top: 50px; 
        padding-bottom: 100px;}

        .ftco-no-pt {
        padding-top: 0; }

        .ftco-no-pb {
        padding-bottom: 0; }

        .heading-section {
        font-size: 28px;
        color: #000; }

        .img {
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center; }

        .content {
        overflow: none;
        width: 100%;
        max-width: 500px;
        padding: 0px 0;
        height: 500px;
        position: relative;
        margin: 20px auto;}

        /*  Events display */
        .events-container {
        height: 100%;
        width: 100%;
        float: left;
        margin: 0px auto;
        display: inline-block;
        padding: 0px;
        border-bottom-right-radius: 3px;
        border-top-right-radius: 3px;
        padding: 0; }
        @media (max-width: 767.98px) {
            .events-container {
            width: 100%;
            height: auto; } }

        .events-container:after {
        clear: both; }

        .event-card {
        padding: 20px 0;
        max-width: 100%;
        display: block;
        background: white;
        border: none !important;
        margin: 20px;
        color: black;
        margin-left: 12px;
        border-radius: 15px;
        box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px;
        }

        .event-count, .event-name, .event-cancelled {
        /* display: inline; */
        padding: 0 10px;
        font-size: 1rem; }

        .event-count {
        color: #fc7fb2;
        text-align: right; }

        .event-name {
        padding-right: 0;
        text-align: left; }

        .event-cancelled {
        color: #fc7fb2;
        text-align: right; }

        /*  Calendar wrapper */
        .calendar-container {
        position: relative;
        margin: 0 auto;
        height: 100%;
        width: 100%;
        background: #fff;
        font: 13px Helvetica, Arial, san-serif;
        display: inline-block;
        padding: 20px;
        float: right; }

        @media (max-width: 991.98px) {
            .calendar-container {
            padding: 0; } }
        @media (max-width: 767.98px) {
            .calendar-container {
            padding: 0;
            width: 100%; } }

        .calendar-container:after {
        clear: both; }

        .calendar {
        width: 100%;
        padding: 0; }

        /* Calendar Header */
        .year-header {
        background: #fff;
        height: 40px;
        text-align: center;
        position: relative;
        color: #fff;
        border-top-left-radius: 3px;
        margin-top: 20px; }

        .year-header span {
        display: inline-block;
        font-size: 20px;
        line-height: 40px;
        color: #000; }

        .left-button, .right-button {
        cursor: pointer;
        width: 28px;
        text-align: center;
        position: absolute;
        color: #cccccc !important;
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
        font-size: 14px !important; }
        @media (prefers-reduced-motion: reduce) {
            .left-button, .right-button {
            -webkit-transition: none;
            -o-transition: none;
            transition: none; } }
        .left-button:hover, .right-button:hover {
            color: #fc7fb2 !important; }

        .left-button {
        left: 0; }

        .right-button {
        right: 0;
        top: 0; }

        /* Buttons */
        .button {
        cursor: pointer;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: none;
        font-size: 1rem;
        border-radius: 25px;
        padding: 0.65rem 1.9rem;
        -webkit-transition: .2s ease all;
        -o-transition: .2s ease all;
        transition: .2s ease all;
        color: white;
        border: none;
        background: #fc7fb2; }
        .button.button-white {
            background: #fff;
            color: #000; }
        .button:focus {
            -webkit-box-shadow: none;
            box-shadow: none;
            outline: none; }

        #cancel-button {
        background: #000; }

        #add-button {
        display: block;
        position: absolute;
        right: 20px;
        bottom: 20px; }

        #add-button:hover, #ok-button:hover, #cancel-button:hover {
        -webkit-transform: scale(1.03);
        -ms-transform: scale(1.03);
        transform: scale(1.03); }

        #add-button:active, #ok-button:active, #cancel-button:active {
        -webkit-transform: translateY(3px) scale(0.97);
        -ms-transform: translateY(3px) scale(0.97);
        transform: translateY(3px) scale(0.97); }

        /* Days/months tables */
        .days-table, .dates-table, .months-table {
        border-collapse: separate;
        text-align: center; }

        .day {
        height: 26px;
        width: 26px;
        padding: 0 10px;
        line-height: 26px;
        border: 2px solid transparent;
        text-transform: uppercase;
        font-size: 10px;
        color: #000; }

        .month {
        cursor: default;
        height: 26px;
        width: 26px;
        padding: 0 2px;
        padding-top: 10px;
        line-height: 26px;
        text-transform: uppercase;
        font-size: 11px;
        color: #cccccc;
        -webkit-transition: all 250ms;
        -o-transition: all 250ms;
        transition: all 250ms; }
        @media (max-width: 991.98px) {
            .month {
            font-size: 8px; } }
        @media (max-width: 767.98px) {
            .month {
            font-size: 10.5px; } }

        .active-month {
        font-weight: 700;
        color: #fc7fb2; }

        .month:hover {
        color: #fc7fb2; }

        /*  Dates table */
        .table-date {
        cursor: default;
        color: #2b2b2b;
        height: 26px;
        width: 26px;
        font-size: 15px;
        padding: 10px;
        line-height: 26px;
        text-align: center;
        border-radius: 50%;
        border: 1px solid transparent;
        -webkit-transition: all 250ms;
        -o-transition: all 250ms;
        transition: all 250ms;
        position: relative;
        z-index: 0; }
        .table-date:before {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            bottom: 0;
            -webkit-transform: translateY(-50%);
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            content: '';
            margin: 0 auto;
            border-radius: 50%;
            z-index: -1; }

        .event-date {
        border-color: #fc7fb2;
        background: #fc7fb2;
        color: #fff; }
        .event-date:after {
            position: absolute;
            top: 0;
            left: 0;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            content: '';
            background: #ffc107;
            border: 1px solid white; }

        .active-date {
        color: #fff; }
        .active-date:before {
            background: #fc7fb2; }

        .event-date.active-date {
        background: transparent;
        border: none; }

        /* input dialog */
        .dialog {
        z-index: 5;
        width: 100%;
        height: 100%;
        bottom: 0;
        left: 0;
        border-radius: 15px;
        display: none; }
        @media (max-width: 767.98px) {
            .dialog {
            width: 100%; } }

        .dialog-header {
        margin: 20px;
        margin-top: 30px;
        color: black;
        text-align: center;
        font-size: 28px; }

        .form-container {
        margin-top: 20%; }

        .form-label {
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.9); }

        .input {
        border: none;
        background: none;
        border: 1px rgba(255, 255, 255, 0.2) solid;
        display: block;
        margin-bottom: 30px;
        width: 300px;
        height: 40px;
        text-align: center;
        -webkit-transition: border-color 250ms;
        -o-transition: border-color 250ms;
        transition: border-color 250ms;
        border-radius: 40px;
        color: #fff; }

        .input:focus {
        outline: none;
        border-color: #fff; }

        .error-input {
        border-color: #fc7fb2; }

        .bg-body-tertiary {
            background: white !important;
        }
      </style>
    
    </head>
    <body style="background: #f8f9fd;">

    

        <!-- Nav Bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="./images/branding-icon.png" alt="Blood Droplet Icon" width="30" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="./index-logged-in.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./privacy-policy-logged-in.php">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Dashboard</a>
                        </li>
                    </ul>
                    <!-- Button trigger offcanvas menu -->
                    <a class="btn btn-dark" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        Settings
                    </a>
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
              <div style="padding: 3%">
               Here you can manage your consent, delete your data, or delete your account. Note that any delete actions you undertake are irreversible. Once you delete somehting
              </div>

              <div style="padding: 3%">
                <h3>Manage Consent</h3>
                The switch below displays your consent to sending your data to you for more in-depth statistics and analysis.
                If you'd like to rescind your consent just turn off the switch.
                <div class="form-check form-switch" style="padding-top: 3%">
                  <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" style="background-color: #F53664; width: 45px !important; height: 21px !important;">
                  <label class="form-check-label" for="flexSwitchCheckDefault" style="padding-left: 3%">I consent</label>
                </div>

                <form>
                    <div class="mb-3" style="padding-top:3%">
                        <label for="signUpEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="signUpEmail" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">This allows us to send you a new code should you forget the one we gave you.</div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="background-color:#F53664!important; border-color: #F53664;">Add Email</button>
                </form>
              </div>

              <br>

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


        <!-- Hero Section -->
        <section class="ftco-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="content w-100">
                            <div class="calendar-container" style="box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px; border-radius: 15px;">
                                <div class="calendar"> 
                                <div class="year-header"> 
                                    <span class="left-button fa fa-chevron-left" id="prev"> </span> 
                                    <span class="year" id="label"></span> 
                                    <span class="right-button fa fa-chevron-right" id="next"> </span>
                                </div> 
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
                                
                                <table class="days-table w-100"> 
                                    <td class="day">Sun</td> 
                                    <td class="day">Mon</td> 
                                    <td class="day">Tue</td> 
                                    <td class="day">Wed</td> 
                                    <td class="day">Thu</td> 
                                    <td class="day">Fri</td> 
                                    <td class="day">Sat</td>
                                </table> 
                                <div class="frame"> 
                                    <table class="dates-table w-100"> 
                                    <tbody class="tbody">             
                                    </tbody> 
                                    </table>
                                </div> 
                                <button class="btn btn-primary" id="add-button" style="background-color:#F53664!important; border-color: #F53664;">Add Entry</button>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="events-container container col-xxl-8 px-4 py-5">
                </div>
                <div class="dialog" id="dialog">
                    <!-- <form id="mood-form"  method="post" action="" onsubmit="myFunction()"> -->
                    <form id="mood-form"  method="post" action="">

                        <div class="event-card row flex-lg g-5 py-5" style="display:flex; padding: 20px!important; margin:0px!important;">
                            <div class="col-12 col-sm-12 col-lg-6" style="margin-top:0px!important; padding:0px!important; padding-bottom: 20px!important;">
                                <div class="vstack gap-5">
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
                            <div class="col-lg-6" style="margin-top:0px!important; padding:0px!important;">
                                <h4> Notes</h4>
                                <textarea class="form-control" name="note" style="background-color: #FFF6FE; height: 300px;"" placeholder="Write down your thoughts and feelings..." id="note"></textarea>
                                <div style="padding-top:30px;">
                                    <input type="button" value="Cancel" class="button" id="cancel-button">
                                    <!-- <input type="submit" name="submit_entry" value="OK" class="button button-white" id="ok-button"> -->
                                    <input type="button" value="OK" class="button button-white" id="ok-button">
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
