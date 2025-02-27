<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/signuppub.css">
    <title>Sign Up For Charity Organization</title>
    <link rel="icon" type="image/png" href="<?php echo URLROOT; ?>/assets/images/publisher/ReadSpot.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">  
    <link rel="icon" type="image/jpg" href="<?php echo URLROOT; ?>/assets/images/customer/logo.png">
</head>
<body>
    <div class="container">
        <form class="login" action="<?php echo URLROOT; ?>/landing/signupCharity" method="post">
            <div id="formPart1">
                <h1>Signup As A Charity Organization</h1>
                <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                <input type="text" name="name" placeholder="Full Name" class="<?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" required>

                <span class="invalid-feedback"><?php echo $data['org_name_err']; ?></span>
                <input type="text" name="org_name" placeholder="Organization Name" class="<?php echo (!empty($data['org_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['org_name']; ?>" required>
               
                <span class="invalid-feedback"><?php echo $data['reg_no_err']; ?></span>
                <input type="text" name="reg_no" placeholder="Registration Number of the company" class="<?php echo (!empty($data['reg_no_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['reg_no']; ?>" required>

                <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
                <input type="email" name="email" placeholder="Email" class="<?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" required>

                <span class="invalid-feedback"><?php echo $data['contact_no_err']; ?></span>
                <input type="text" name="contact_no" placeholder="Contact Number(+94123456789)" class="<?php echo (!empty($data['contact_no_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['contact_no']; ?>" required>

                <div class="password-wrapper">
                <span class="invalid-feedback"><?php echo $data['pass_err']; ?></span>
                <input type="password" name="pass" placeholder="Password" class="<?php echo (!empty($data['pass_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['pass']; ?>" required>
                <i class="fa fa-eye-slash" id="togglePassword"></i></div> 

                <div class="password-wrapper">
                <span class="invalid-feedback"><?php echo $data['confirm_pass_err']; ?></span>
                <input type="password" name="confirm_pass" placeholder="Confirm Password" class="<?php echo (!empty($data['confirm_pass_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_pass']; ?>" required>
                <i class="fa fa-eye-slash" id="togglePassword2"></i>
                </div> 
                <!-- <button onclick="goBack()" class="btn">  Cancel </button>  -->
                <button type="submit" class="btn" name="submit">Submit</button>
            </div>
        </form>

        <div class="register">
            <div class="back-btn-div-login">
                <button class="back-btn-login" onclick="history.back()"><i class="fa fa-angle-double-left"></i> Go Back</button>
            </div>
            <img src="<?php echo URLROOT; ?>/assets/images/customer/logo.png">
            <h3>WELCOME TO</h3>
            <h2>Read Spot</h2>
            <p>Here we introduce a web-based platform for buying, selling, exchanging, and donating both new & used books.</p>
            <a href="<?php echo URLROOT; ?>/landing/login"><button class="register-button">login</button></a>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <h2>Record Added!</h2>
            <p>Your information has been submitted for approval. Please wait for admin approval!</p>
            <button onclick="closeModal()" class="confirm">OK</button>
        </div>
    </div>
</body>
<script>
        function goBack() {
            // Use the browser's built-in history object to go back
            window.history.back();
        }
        document.getElementById('togglePassword').addEventListener('click', function() {
        var passwordInput = document.querySelector('input[name="pass"]');
        var type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);

        this.classList.toggle('fa-eye-slash'); // Toggle the slash on the icon
        this.classList.toggle('fa-eye');   // Toggle the eye icon itself
        });

        document.getElementById('togglePassword2').addEventListener('click', function() {
        var confirmPasswordInput = document.querySelector('input[name="confirm_pass"]');
        var type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPasswordInput.setAttribute('type', type);

        this.classList.toggle('fa-eye-slash'); // Toggle the slash on the icon
        this.classList.toggle('fa-eye');   // Toggle the eye icon itself
    });
 
            function showModal() {
                var modal = document.getElementById("myModal");
                modal.style.display = "block";
            }

            function closeModal() {
                var modal = document.getElementById("myModal");
                modal.style.display = "none";
                window.location.href = "<?php echo URLROOT; ?>/landing/index"; // Redirect to the event page
            }

            <?php
            // Check if the showModal flag is set, then call showModal()
            if (isset($_SESSION['showModal']) && $_SESSION['showModal']) {
                echo "window.onload = showModal;";
                // Unset the session variable after use
                unset($_SESSION['showModal']);
            }
            ?>

        
    </script>
   

<script>
    var contactNoInput = document.getElementById('contactNoInput');
    var contactNoError = document.getElementById('contactNoError');

    // Function to validate phone number format
    function validatePhoneNumber(phoneNumber) {
        // Regular expression pattern for phone numbers in international format
        var phonePattern = /^\+\d{11}$/;
        return phonePattern.test(phoneNumber);
    }

    // Function to display error message
    function displayErrorMessage(message) {
        contactNoError.textContent = message;
        contactNoError.style.display = 'block';
    }

    // Function to hide error message
    function hideErrorMessage() {
        contactNoError.textContent = '';
        contactNoError.style.display = 'none';
    }

    // Event listener to validate phone number format as the user types
    contactNoInput.addEventListener('input', function() {
        var phoneNumber = contactNoInput.value;
        if (!validatePhoneNumber(phoneNumber)) {
            displayErrorMessage('Invalid phone number format. Please enter in the format: +94123456789');
        } else {
            hideErrorMessage();
        }
    });
</script>

</html>
