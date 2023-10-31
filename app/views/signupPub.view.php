<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="http://localhost/Group-27/public/assets/css/signupCss.css" />
</head>

<body>
    <div class="container">
        <!-- Combined Form for both First Page and Second Page -->
        <form class="login" action="http://localhost/Group-27/app/models/UserPub.php" method="post">
            <!-- First Page Content -->
            <div id="formPart1">
                <h1>Sign up</h1>
                <input type="text" name="name" placeholder="First & Last Name" required>
                <input type="text" name="company_name" placeholder="Company Name" required>
                <input type="text" name="reg_no" placeholder="Registration Number of the company" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="text" name="contact_no" placeholder="Contact Number" required>
                
                <input type="password" name="pass" placeholder="Password" required>
                <button type="submit" class="btn" name="submit">Submit</button>
            </div>

            
        </form>

        <div class="register">
            <img src="http://localhost/Group-27/public/assets/images/customer/logo.png">
            <h3>WELCOME TO</h3>
            <h2>Read Spot</h2>
            <p>Here we introduce a web-based platform for buying, selling, exchanging, and donating both new & used books.</p>
            <a href="http://localhost/Group-27/app/views/login.view.php"><button>login</button></a>
        </div>
    </div>
    

    
</body>

</html>