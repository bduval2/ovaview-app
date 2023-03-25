<?php
    if (isset($_POST["submit_signup"])) {
        include_once('entry.php');
        $userID = register();

        $test = "Here is your login. MAKE SURE YOU DO NOT LOSE IT: " ;
        $test .= $userID;
        echo "<script>alert($userID); window.location.href = 'index.html'; </script> ";
        
    }

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <style>
        .bd-placeholder-img {
          font-size: 1.125rem;
          text-anchor: middle;
          -webkit-user-select: none;
          -moz-user-select: none;
          user-select: none;
        }
  
        @media (min-width: 768px) {
          .bd-placeholder-img-lg {
            font-size: 3.5rem;
          }
        }
  
        .b-example-divider {
          height: 3rem;
          background-color: rgba(0, 0, 0, .1);
          border: solid rgba(0, 0, 0, .15);
          border-width: 1px 0;
          box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }
  
        .b-example-vr {
          flex-shrink: 0;
          width: 1.5rem;
          height: 100vh;
        }
  
        .bi {
          vertical-align: -.125em;
          fill: currentColor;
        }
  
        .nav-scroller {
          position: relative;
          z-index: 2;
          height: 2.75rem;
          overflow-y: hidden;
        }
  
        .nav-scroller .nav {
          display: flex;
          flex-wrap: nowrap;
          padding-bottom: 1rem;
          margin-top: -1px;
          overflow-x: auto;
          text-align: center;
          white-space: nowrap;
          -webkit-overflow-scrolling: touch;
        }

        .bg-body-tertiary {
            background: white !important;
        }
      </style>
  
      
      <!-- Custom styles for this template -->
      <link href="heroes.css" rel="stylesheet">
    </head>
    <body>

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
                            <a class="nav-link active" href="./index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./privacy-policy.html">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="#">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./dashboard.html">Dashboard</a>
                        </li>
                    </ul>
                    <!-- Button trigger modal -->
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
                    
                    <form>
                        <div class="mb-3">
                        <label for="loginCode" class="form-label">Login Code</label>
                        <input type="text" class="form-control" id="loginCode" aria-describedby="codeHelp">
                        <div id="codelHelp" class="form-text">This should be a 16 digit code.</div>
                        </div>
                        <button type="submit" class="btn btn-primary" style="background-color:#F53664!important; border-color: #F53664;">Log In</button>
                    </form>

                    <br>

                    <button type="button" class="btn btn-link" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal">I forgot my code</button>
                </div>
                
            </div>
            </div>
        </div>


        <!-- Forgot Code Modal -->
        <div class="modal fade" id="exampleModalToggle2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Your email</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Please enter your email. We’ll email you your one time password so you can sign in.
                
                        <br>
                        
                        <form>
                            <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail">
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" style="background-color:#F53664!important; border-color: #F53664;">Send me a one time password</button>
                        </form>
    
                    </div>
                    
                </div>
                </div>
            </div>


        <!-- One Time Password Modal -->
        <div class="modal fade" id="exampleModalToggle3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Enter Your One-Time Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Please enter the password we sent by email.                
                        <br>
                        
                        <form>
                            <div class="mb-3">
                            <label for="loginPassword" class="form-label">One Time Password</label>
                            <input type="password" class="form-control" id="loginPassword">
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-target="#exampleModalToggle3" data-bs-toggle="modal" style="background-color:#F53664!important; border-color: #F53664;">Log in</button>
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
                    <h1 class="display-5 fw-bold lh-1 mb-3">Sign up to use our app!</h1>
                    <p class="lead">We don't need any of your information to sign up. Once you click Sign Up, we'll give you a 16 digit code that you can use to log in. Keep it safe!</p>
                    <p class="lead">You can also provide us with an email in case you forget your code and we'll send you a new one by email.</p>
                    <p class="lead">If you’d like more personalized statistics like approximations for when your next period will be, or analysis of your moods and symptoms, then you’ll have to share your data with us. </p>
                    <p class="lead">If you aren’t interested in that, no problem! You can still use our app to track everything, but there won’t be any smart analysis.</p>
                    <p class="lead">Read our stance on your data below.</p>
                    <form method="post" action="">
                        <button type="submit" name="submit_signup" class="btn btn-primary" data-bs-target="#post-reg-modal" data-bs-toggle="modal" style="background-color:#F53664!important; border-color: #F53664;">Sign Up</button>
                        <br>
                        <div class="mb-3" style="padding-top:3%">
                            <label for="signUpEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="signUpEmail" aria-describedby="emailHelp">
                            <div id="emailHelp" class="form-text">An email is not required for sign up, but it would allow us to send you a new code should you forget the one we gave you.</div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">I consent to send my data to you for more in-depth statistics and analysis.
                                I am aware I can rescind my consent at any time by going to the settings page.</label>
                          </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Our Stance Section -->

        <div class="container align-items-center" style="padding-top: 100px">
            <div class="row align-items-center">
                <div class="col text-center">
                    <h2 class="display-4 fw-bold lh-2 mb-3">Our Stance on Your Data</h2>
                </div>
            </div>
            <div class="row g-4 py-5">
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/your-data-is-yours.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">Your Data Is Yours</h3>
                    <p>We don’t collect anything you don’t directly allow us to.</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/your-data-is-protected.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">Your Data is Protected</h3>
                    <p>Everything is encrypted!</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/the-choice-is-yours.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">You can Opt In/Out Anytime!</h3>
                    <p>We don’t collect anything you don’t directly allow us to.</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <img src="./images/data-is-anonymous.png" class="img-fluid" alt="Test">
                    <h3 class="fs-2">All Data is Anonymized</h3>
                    <p>Even if your data is stolen, no one can know who you are.</p>
                </div>
            </div>
        </div>

        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>