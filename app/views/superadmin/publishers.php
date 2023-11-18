

<?php
    $title = "Publishers";
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/superadmin/productgallery.css" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/nav.css" />

</head>

<body>
 
    <?php require APPROOT . '/views/superadmin/nav.php';?>
    <?php require APPROOT . '/views/superadmin/subnav.php';?>
    <div class="div_table" >

        <table>
            <tr>

               
                <th style="width:45%;background-color: #C7C7C7;">Name</th>
                <th style="width:45%;background-color: #C7C7C7;">Email</th>
                <th style="width:5%;background-color: #C7C7C7;">Update</th>
                <th style="width:5%;background-color: #C7C7C7;">Delete</th>

            </tr>
           
    <?php foreach($data['addpublishersDetails'] as $publishers): ?>
    <tr>
        <td style="width:7%"><?php echo $publishers->name; ?></td>
        <td style="width:20%"><?php echo $publishers->email; ?></td>
        <td><a href='<?php echo URLROOT; ?>/superadmin/updateAdmins/<?php echo $admin->admin_id; ?>'><i class='fa fa-edit' style='color:#09514C;'></i></a></td>
        <td><a href='#'><i class='fa fa-trash' style='color:#09514C;'></i></a></td>
    </tr>
<?php endforeach; ?>

            
            
           
                
        </table>
        <a href="<?php echo URLROOT; ?>/superadmin/addAdmin" class="btn">Add</a>
    </div>
    
   
</body>

</html>
