<!DOCTYPE html>
<html lang="en">

<head>
<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/style.css" />
<link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/nav.css" />
<link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


</head>

<body>
 
<?php require APPROOT . '/views/admin/nav.php';?>
  <div class="nav-container1">
    <a href="<?php echo URLROOT; ?>/admin/pendingRequestsPub">Pending Registration Requests > </a>
    <a href="<?php echo URLROOT; ?>/admin/pendingRequestsBooks" class="active1">Pending Books</a> 
  </div>

  <div class="table-container" >

        <table>
            <tr>
                <th>Book Name</th>
                <th>Author</th>
                <th>Price</th>
                <th>Price Type</th>
                <th>Condition</th>
                <th>Seller name</th>
                <th>Seller Email</th>
                <th>Front Page</th>
                <th>Back Page</th>
                <th>Inside Page</th>
                <th>Actions</th>
            </tr>
           
    <?php foreach($data['pendingBookDetails'] as $book): ?>
    <tr>
        <td><?php echo $book->book_name; ?></td>
        <td><?php echo $book->author; ?></td>
        <td><?php echo $book->price; ?></td>
        <td><?php echo $book->price_type; ?></td>
        <td><?php echo $book->condition; ?></td>
        <td><?php echo $book->name; ?></td>
        <td><?php echo $book->email; ?></td>
        <td><img src="<?php echo URLROOT;?>/assests/images/customer/AddUsedBook/<?php echo $book->img1;?>"></td>
        <td><img src="<?php echo URLROOT;?>/assests/images/customer/AddUsedBook/<?php echo $book->img2;?>"></td>
        <td><img src="<?php echo URLROOT;?>/assests/images/customer/AddUsedBook/<?php echo $book->img3;?>"></td>
        
        <td><a href='<?php echo URLROOT; ?>/admin/approveBook/<?php echo $book->seller_id; ?>'><button>Approve</button></a>
        <div class="popup"">
                    <button onclick="myFunction()">Reject</button>
                    <div class="popuptext" id="myPopup">
                    <p>Are you sure you want to  reject and delete this Customer?</p><br>
                    <a  class="button" href='#' ><button>Yes</button></a>
                    <a class="button" href='#'><button>No</button></a>
                    </div>
                    </div></td>
    </tr>
<?php endforeach; ?>               
        </table>
        
    </div>
   
</body>

</html>