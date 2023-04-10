<?php
    session_start();

    $user_id = $_SESSION['userid'];

    include_once('../backEnd/consent.php');


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



    // PHP code for logging out
    if(isset($_POST['logout'])) {
        
        // Removing the user id from the session and re-directing
        unset($_SESSION['userid']);
        echo "<script> window.location.href = 'index.php'; </script>";
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
        <title>OvaView</title>
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
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./privacy-policy-logged-in.php">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"  href="./dashboard.php">Dashboard</a>
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



        <!-- Hero Section -->
        <div class="container">
            <div class="row flex-lg-row-reverse align-items-center">
                <div class="col-12 col-md-7">
                    <img src="./images/homepage-hero-image.png" class="img-fluid" alt="Test">
                </div>
                <div class="col-12 col-md-5">
                    <h1 class="display-5 fw-bold lh-1 mb-3">OvaView</h1>
                    <h2>Privacy-Focused Period Tracker</h2>
                    <p class="lead">Menstrual health is an under-discussed secret many are embarrassed by, and often overlook because of the stigma - we want to change that. We understand the sensitivity and how personal this subject can be - that is why we want to offer a platform that makes organizing and tracking your menstrual health as convenient as possible, and as secret as possible. Understand how your body treats you, and how you should treat your body using our app - without the worry anyone else snooping around and peeping in on your life.</p>
                </div>
            </div>
        </div>



        <!-- App Features Section -->
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg align-items-center g-5 py-5">
            <div class="col-12 col-sm-12 col-lg-6">
                <img src="./images/app-features.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Period Tracking made Easy!</h1>
                <p class="lead">We want to make understanding your body less of a chore and more of breeze. Our app lets you organize your menstrual activities, easily linking various symptoms, moods, and feelings to specific calendar days. You can also ask us to help you plan ahead - if you opt in, you can ask us to use our community driven learning algorithm to predict your next month's menstrual activity so you won't be left in the dark about next month! </p>
            </div>
            </div>
        </div>


        <!-- Privacy Features Section -->
        <div class="container col-xxl-8 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-12 col-sm-12 col-lg-6">
                <img src="./images/privacy-features.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3">Privacy Done Right to Keep Your Mind at Ease</h1>
                <p class="lead">We understand that your menstrual activity is personal - that's why we have adopted principles and architectures to help keep your data safe and anonymous. Thanks to consistent end-to-end encryption between your device and our servers, no outsiders can intercept and read what you're typing in, not even us as a service operator! With no personal information needed to start using our app, we make sure that none of the data we collect is identifiable in any way, so you can rest easy knowing that everything you track cannot be linked to your name, address, email, or anything else other apps ask you to submit to them!</p>
            </div>
            </div>
        </div>



        <!-- Us vs Them Section -->
        <section>
            <!-- Intro Part -->
            <div class="px-4 text-center">
                <h1 class="display-5 fw-bold">What We Do Differently</h1>
                <div class="container px-5">
                    <img src="./images/what-we-do.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="500" height="500" loading="lazy">
                </div>
                <div class="col-lg-8 mx-auto">
                    <p class="lead mb-4">Unlike all the other apps out there, we let you join our community with no strings attached! We offer an open door policy with no barrier to entry in terms of what you need to hand over to us; no fuss and concerns like asking for your name, birthday, phone number, and like some apps out there ask, your address!</p>
                    <p class="lead mb-4">We recognize the goal of our app: build a comfortable and convenient platform for you to better your menstrual health! No need to ask our users for personally identifiable information, or even worse, force them to hand such over to even have the basic functionalities of our app.</p>
                    <p class="lead mb-4">We respect the intimacy and confidentiality that comes with your body; we make it our top priority to make sure what you keep track of is safe, secure, and can never be linked to your identity. Using both the best technological infrastructure to keep your data safe, as well as practicing a no-nonsense approach to our interactions with you as a user, we ensure the best privacy at no cost of your experience on our platform.</p>
                    <p class="lead mb-4">Our end-to-end encryption technology ensures that only you are able to see what you do on our app; no interceptions or wrong recipients of your intimate data can be read or deciphered! Moreover, other apps have a habit of keeping what you knowingly give them safe, but forget to tell you about how they're actually watching everything you do on their app. Over time, they study you enough to accrue valuable information about you to profile you; scary! However, we cut out all of that, making sure nothing is monitoring and watching you while you use our app; after all, why would we need that information?</p>
                </div>
            </div>

            <!-- Difference Breakdown -->
            <div class="container col-xxl-8 px-4 py-5">
                <div class="row flex-lg align-items-top g-4 py-4">
                
                <!-- Us -->
                <div class="col-12 col-sm-12 col-lg-6">
                    <div style=" background-color: #ECFFE9; box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px; border-radius: 15px; padding: 3%; height: 100%;">
                        <h1 class="display-5 fw-bold lh-1 mb-3">What We Do:</h1>
                        <div class="col-12">
                            <img src="./images/us.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                        </div>
                        <ul>
                            <li>Allow users to join with no strings attached; we don't want your information, just your willingness to join!</li>
                            <li>Default to the bare minimum of data submission; we offer cool features and such, but only with your consent and knowledge you are fully aware of the terms!</li>
                            <li>End-to-end encryption; traditional server-side encryption leaves room for errors, while our method covers all bases!</li>
                            <li>Never monitor users using our app; we're a period journal app, not a surveillance app!</li>
                            <li>Have no data attached to a user's identity; you're anonymous to us! In fact, with our account system you're just a 16-digit string!</li>
                            <li>Educate our engineers on internet privacy; we recognize technology can only do so much to correct human error such as exposure to social engineering or client side attacks. That's why we aim to maintain the most responsible and well-minded individuals in our team to protect your data.</li>
                        </ul>
                    </div>
                </div>

                <!-- Them -->
                <div class="col-lg-6">
                    <div style=" background-color: #FFF6FE; box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px; border-radius: 15px; padding: 3%; height: 100%;">
                        <h1 class="display-5 fw-bold lh-1 mb-3">What Other Apps Do:</h1>
                        <div class="col-12">
                            <img src="./images/them.png" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
                        </div>    
                        <ul>
                            <li>Force users to hand over personally identifiable information like name, birth, place of residence, phone number, and much more.</li>
                            <li>Trick users into consenting to unfair data conditions by distracting users or shoving long legal jargon in their faces.</li>
                            <li>Constantly monitor and track users using their app to profile them.</li>
                            <li>Sell all acquired data of users to third parties for profit.</li>
                            <li>Often have their databases breached due to employee negligence and allowing social engineering or other various forms of preventable attacks.</li>
                        </ul>               
                     </div>
                </div>
            </div>

        </section>
        

        <!-- Scripts Import -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
        <script src="js/jquery.min.js"></script>
        <script src="js/main.js"></script>

    </body>
</html>
