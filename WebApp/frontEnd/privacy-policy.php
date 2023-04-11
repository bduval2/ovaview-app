<?php
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
        <title>Privacy Policy</title>
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
                            <a class="nav-link" href="./index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Privacy Policy</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./registration-page.php">Sign Up</a>
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

        
        <!-- Privacy Policy -->
        <section style="margin-top: 100px; margin-bottom: 50px">

            <!-- Hero Section -->
            <div class="container" style=" background-color: white; box-shadow: rgba(0,0,0,.04) 0 1px 0,rgba(0,0,0,.05) 0 2px 7px,rgba(0,0,0,.06) 0 12px 22px; border-radius: 15px; padding: 3%">
                <div class="row flex-lg-row-reverse align-items-center">
                    <div class="col-12 col-md-6">
                        <img src="./images/privacy-policy.png" class="img-fluid" alt="Test">
                    </div>
                    <div class="col-12 col-md-6">
                        <h1 class="display-5 fw-bold lh-1 mb-3">Privacy Policy</h1>
                        <p class="lead">OvaView was founded to offer a convenient menstrual tracker app while achieving uncompromising security and data protection. Our objective is to store minimal information on the user for as short of a time as possible while maintaining high app quality and user convenience. We ensure absolute security by both means of state-of-the-art technology and privacy-minded measures and principles.</p>
                    </div>
                </div>

                <!-- Privacy Policy Breakdown -->
                <div class="row flex-lg align-items-center">
                    <div class="col">
                        <!-- Policy Overview -->
                        <div>
                            <h2 id="1-policy-overview">1. Policy Overview</h2>
                            <p>The OvaView app aims to keep as little identifying data as possible on the central server. We value user freedom and self-governance on their data, and hold a strong dogma regarding <strong>choice</strong>; users are defaulted to the barebones of data submission and encourage customization to fit each individual&#39;s unique preferences and needs.</p>
                        </div>
                        <br>

                        <!-- Anonymous Accounts -->
                        <div>
                            <h2 id="2-anonymous-accounts">2. Anonymous Accounts</h2>
                            <p>A modern day problem is the need for every service, regardless of its function, to require consumers to hand over their PII (<strong>Personal Identifiable Information</strong>). If you think about it, why does your budgeting app that only keeps track of what you spent your money on require you to enter so many various pieces of information to use it? Name, email, date of birth, gender, location, etc. are obviously not needed to make sure your app can remind you that you have been spending far too much money on snacks this past month, so what is the deal?</p>
                            <p>Companies profit massively from gathering data and selling it off en masse to various advertising, research, and analytical companies. Many services put up a façade to users that they require users to give them their information to &quot;help enhance their experience&quot;, forgetting to disclose to users that the funds they use to &quot;better&quot; their service came from selling said data.</p>
                            <p>Because of this, there is a barrier to entry for potential consumers. They find a simple service that they wish to use for convenience or entertainment, but need to trade their PII to use said service.</p>
                            <h4 id="our-fully-anonymous-position">Our Fully Anonymous Position</h4>
                            <p>We recognize that the function of our service is fairly simple. The user inputs what they want to keep track of, and optionally asks for a prediction based on this data. <strong>In no step of our product process is there a need for the data given to us to be linked to a name, face, or alias.</strong></p>
                            <p>Because of this, we developed an account system that requires no user information to create and use. Each profile is identified by a unique 16-digit token that is generated by our system on registration, with no requirements. Users do not need to give us any information to create a token and get started using our product.</p>
                            <p>We limit user intervention on account identification for various security reasons. Although having your account number generated for you instead of allowing you to choose it yourself may feel limiting and unfamiliar, this method offers several benefits:</p>
                            <ul>
                            <li>It keeps the accounts more anonymous. If a user selects their own username, it could potentially help identify them. For example, a user might choose the same username that is used on other services or the language and style of the username may reveal their country of origin or cultural background.</li>
                            <li>It prevents a user from selecting a weak password. Many people use weak passwords and/or use the same password across multiple services. With a lengthy and random account number, we can ensure that it is long enough to be secure and greatly reduce the risk of it being used for another service, since the user would have to copy the hard-to-remember number they received from us and use it elsewhere.</li>
                            </ul>
                            <p>Your account number serves as both the username and password, meaning it is both the account&#39;s unique token (username) and the secret that authenticates the account towards our service (password). Therefore, you should keep it as safe and secret as a password.</p>
                            <h4 id="what-if-someone-brute-forces-my-account-">What if Someone Brute-forces My Account?</h4>
                            <p>When an account is created, it is assigned a 16-digit decimal number within the range of &quot;1000 0000 0000 0000&quot; to &quot;9999 9999 9999 9999&quot;. This range provides a total of 9 &times; 10 <sup>15</sup> possible account numbers, making it highly unlikely for someone to guess a valid account number. Assuming that there are 100,000 active accounts, an average of 45 &times; 10<sup>9</sup> attempts would be required to find a working account, which is practically impossible.</p>
                        </div>
                        <br>

                        <!-- Purpose of Data Processing -->
                        <div>
                            <h2 id="3-purpose-of-data-processing">3. Purpose of Data Processing</h2>
                            <p>OvaView processes data with the sole intent of providing users the ability to keep a record book of their menstrual cycle and personal activities, feelings, and/or symptoms related to their menstrual cycles.</p>
                            <p>Optionally, upon explicit user consent, we process <strong>user inputted</strong> data to provide additional features such as cross-platform syncing and/or personal menstrual cycle prediction.</p>
                            <p>Our menstrual cycle prediction algorithm is lightweight and optimized; on mobile apps we process our consumers&#39; information locally, however web users have their data submitted to our servers to be analyzed. No step in our algorithm requires us to disclose user data to third parties, and said data is only processed by our servers once to produce our prediction: after calculations, we do not process any more data until the next cycle is needed to be predicted.</p>
                        </div>
                        <br>

                        <!-- Boundaries & Duration -->
                        <div>
                            <h2 id="4-boundaries-and-duration-of-data-processing">4. Boundaries and Duration of Data Processing</h2>
                            <h4 id="a-server-inventory">A. Server Inventory</h4>
                            <p>The following inventory data is stored in our central server <strong>by default</strong>:</p>
                            <ul>
                            <li>Unique user ID</li>
                            </ul>
                            <p>No other data is stored if a user creates an account and does not touch any settings. <strong>We never store data that is not unnecessary to the app function without explicit, clear, and consistent user consent.</strong> This choice is tied to our belief that everyone has a right to privacy and all consumers deserver full autonomy over their data.</p>
                            <p>For cross-device purposes, users can opt-in to storing information to be synced up in other devices:</p>
                            <ul>
                            <li>Information linked to day dates on the calendar<ul>
                            <li>Perceived period start</li>
                            <li>Perceived period end</li>
                            <li>Mood</li>
                            <li>Period symptoms felt</li>
                            <li>Excerpt from user about their feelings on the day</li>
                            </ul>
                            </li>
                            </ul>
                            <p>None of the information will be passed on to third parties. All data remains in the server until deleted by the user. Once user requests and confirms erasure, there is no way to retrieve or recover deleted information.</p>
                            <h4 id="b-information-lifetime-and-trace">B. Information Lifetime and Trace</h4>
                            <p>All data stored in our central server remains until the user, upon verifying ownership of data, requests erasure. It is important to understand this erasure process is <strong>irreversible</strong> and we cannot restore any erased data.</p>
                            <p>This also ensures that once users request to have their data deleted, there is no trace of that information remaining in any of our systems.</p>
                            <h4 id="c-data-processed-by-third-parties">C. Data Processed by Third Parties</h4>
                            <h5 id="web-service">Web Service</h5>
                            <p>No data is ever sent to third parties for processing.</p>
                            <h5 id="mobile-application">Mobile Application</h5>
                            <p>In order to maintain quality and improve stability of our service, we produce <strong>anonymous crash reports</strong> to be evaluated by IOS.</p>
                        
                        </div>
                        <br>

                        <!-- Right to View -->
                        <div>
                            <h2 id="5-right-to-view-rectify-and-erase-information">5. Right to View, Rectify, and Erase Information</h2>
                            <p>Our company culture prioritizes user autonomy over anything else. This is why we aim to maximize transparency to all users.</p>
                            <p>All data, <strong>except the default necessary points</strong>, are subject for viewing, rectification, and erasure while maintaining functionality of user account. By this, we state that the following necessary data point(s) stored by default:</p>
                            <ul>
                            <li>Unique user ID</li>
                            </ul>
                            <p>are exempt from rectification and erasure without compromising the user&#39;s account. Erasure of unique user ID <strong>implies</strong> the deletion of all linked data to that ID.</p>
                            <p>The following data are <strong>all subject to viewing, rectification, and erasure:</strong></p>
                            <ul>
                            <li>User inputted data<ul>
                            <li>Perceived period start</li>
                            <li>Perceived period end</li>
                            <li>Mood</li>
                            <li>Period symptoms felt</li>
                            <li>Excerpt from user about their feelings on the day</li>
                            </ul>
                            </li>
                            </ul>
                            <p>It is imperative to inform users that our system does not track the history of data. This means any rectification or erasure requested by the user is <strong>irreversible</strong>.</p>
                            <p>The stored data can be viewed at any time within OvaView in the user profile screen and can be corrected or deleted by the user with immediate effect.</p>
                        </div>
                        <br>

                        <!-- Consent -->
                        <div>
                            <h2 id="6-user-consent-withdrawal-and-re-approval">6. User Consent Withdrawal and Re-Approval</h2>
                            <p>Users are granted full flexibility on the consent they give to us. Any consent given in the past is fully retractable via the user settings page. Withdrawal of additional consent only ceases data collection, which in turn may cease additional functionalities that the opt-in allowed for (for example, cross-device syncing).</p>
                            <p>Withdrawal of consent does not imply that users are disallowed from future functionalities or opportunities. Any consent retracted can be re-approved by the user.</p>
                            <p>Withdrawal of consent is <strong>not retroactive</strong> and users are prompted to decide whether or not they wish previous collected data should be deleted or not.</p>
                        </div>
                        <br>

                        <!-- Consent -->
                        <div>
                            <h2 id="7-cookies">7. Cookies</h2>
                            <p>OvaView does not use <strong> any cookies. </strong> </p>
                            <h4 id="3-the-cookies-we-use">The Cookies We Use</h4>
                            <ul>
                            <li><strong>NONE!</strong></li>
                            </ul>
                        </div>
                        <br>

                        </div>
                    
                </div>
            </div>

        </section>

        <!-- Scripts Import -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    </body>
</html>

