<?php
    $title = "Add Moderator";
    
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Add Books</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/publisher/addbooks.css" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/nav.css" />

</head>

<body>
    <div>
    <?php   require APPROOT . '/views/superadmin/nav.php';?><div>
        <div class="form-container">
             
            <div class="form1">
                <h2>Enter the Details of the Book</h2>
                <form action="<?php echo URLROOT; ?>/superadmin/addModerator" method="POST">                    
                    <br>
                    <br>
                                   
                    <input type="text" name="name" class="<?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" placeholder="Full Name" required><br>
                    <span class="error"><?php echo $data['name_err']; ?></span>
                               
                                   
                    <input type="text" name="email" class="<?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>" placeholder="Email" required>
                                              
                    <input type="text" name="pass"  class="<?php echo (!empty($data['pass_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['pass']; ?>"placeholder="Password" required><br>
                    <span class="error"><?php echo $data['pass_err']; ?></span>

                    <input type="text" name="confirm_pass"  class="<?php echo (!empty($data['confirm_pass_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_pass']; ?>"placeholder="Confirm Password" required><br>
                    <span class="error"><?php echo $data['confirm_pass_err']; ?></span>
                    
                    </div> 
                    <br>       
                    <input  type="submit" placeholder="Submit" name="submit" class="submit">

                </form>
            </div>
        </div>

</div> 
    </div>
   

</body>

</html>