<?php

    // PHP code for sign up functionality 
    if (isset($_POST["submit_signup"])) {
        include_once('../backEnd/entry.php');
        if (isset($_POST["consent"])){

            // Setting the user's consent, if they consented.
            $consent = $_POST["consent"];

            // Setting the user's ID
            $userID = register("true");
        }
        else {
            // Setting the user's ID
            $userID = register();
        }

        echo "<script>alert('Here is your login ID, keep it safe: '+ $userID); window.location.href = 'index.php'; </script> ";
    }



    session_start();



    // PHP code for login functionality 
    if (isset($_POST["submit_login"])) {
        include_once('../backEnd/entry.php');
        $userID = $_POST["loginCode"];
        $success = auth($userID );
        $stringid = strval($userID);
        if ($success)
        {
            $_SESSION["userid"] = $stringid;
            $session = $_SESSION['userid'];
            echo "<script> window.location.href = 'dashboard.php'; </script>";
        }
        else {
            echo "<script>alert('Wrong login code, try again!');</script>";
        }
    }

?>




<!DOCTYPE html>
<html lang="en">
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign Up</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link href="./css/style.css" rel="stylesheet">
    </head>
    <body>

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
                            <a class="nav-link" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./privacy-policy.php">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Sign Up</a>
                        </li>
                    </ul>

                    <!-- Login Button to trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="background-color:#F53664!important; border-color: #F53664;">
                        Log In
                    </button>
                </div>
            </div>
        </nav>

        
        
        <!-- Log in Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Your Login Code</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Please enter the code we gave you when you signed up to our service.
            
                    <br>
                    
                    <!-- Form where user enters login code -->
                    <form method="post" action="">
                        <div class="mb-3">
                        <label for="loginCode" class="form-label">Login Code</label>
                        <input type="text" class="form-control" id="loginCode" name="loginCode" aria-describedby="codeHelp">
                        <div id="codelHelp" class="form-text">This should be a 16 digit code.</div>
                        </div>
                        <button type="submit" name="submit_login" class="btn btn-primary" style="background-color:#F53664!important; border-color: #F53664;">Log In</button>
                    </form>

                </div>
                
            </div>
            </div>
        </div>

        <!-- Hero Section -->
        <div class="container" style="padding-top: 100px">
            <div class="row flex-lg-row-reverse align-items-center">
                <div class="col-12 col-md-7">
                    <img src="./images/registration-hero-image.png" class="img-fluid" alt="Test">
                </div>
                <div class="col-12 col-md-5">

                    <!-- Sales Pitch Part -->
                    <h1 class="display-5 fw-bold lh-1 mb-3">Sign up to use our app!</h1>
                    <p class="lead">We don't need any of your information to sign up. Once you click Sign Up, we'll give you a 16 digit code that you can use to log in. Keep it safe!</p>
                    <p class="lead">If you’d like more personalized statistics like approximations for when your next period will be, or analysis of your moods and symptoms, then you’ll have to share your data with us. </p>
                    <p class="lead">If you aren’t interested in that, no problem! You can still use our app to track everything, but there won’t be any smart analysis.</p>
                    <p class="lead">Read our stance on your data below.</p>

                    <!-- Sign Up Form -->
                    <form method="post" action="">
                        <button type="submit" name="submit_signup" class="btn btn-primary" data-bs-target="#post-reg-modal" data-bs-toggle="modal" style="background-color:#F53664!important; border-color: #F53664;">Sign Up</button>
                        <br>
                        <br>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="consent" name="consent">
                            <label class="form-check-label" for="consent">I consent to send my data to you for more in-depth statistics and analysis.
                                I am aware I can rescind my consent at any time by going to the settings page.</label>
                          </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Our Stance Section -->
        <div class="container align-items-center" style="padding-top: 100px">

            <!-- Title -->
            <div class="row align-items-center">
                <div class="col text-center">
                    <h2 class="display-4 fw-bold lh-2 mb-3">Our Stance on Your Data</h2>
                </div>
            </div>

            <div class="row g-4 py-5">

                <!-- Your Data Is Yours -->
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/your-data-is-yours.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">Your Data Is Yours</h3>
                    <p>We don’t collect anything you don’t directly allow us to.</p>
                </div>

                <!-- Your Data is Protected -->
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/your-data-is-protected.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">Your Data is Protected</h3>
                    <p>Everything is encrypted!</p>
                </div>

                <!-- You can Opt In/Out Anytime -->
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/the-choice-is-yours.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">You can Opt In/Out Anytime!</h3>
                    <p>We don’t collect anything you don’t directly allow us to.</p>
                </div>

                <!-- All Data is Anonymized -->
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/data-is-anonymous.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">All Data is Anonymized</h3>
                    <p>Even if your data is stolen, no one can know who you are.</p>
                </div>
            </div>
        </div>

        <!-- Scripts Import -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>