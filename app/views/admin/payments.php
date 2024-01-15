

<?php
    $title = "Approve Payment Reciepts";
    
?>

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
   <br><br><br>
    
    <div class="table-container" >

        <table>
            <tr>
                <th>Order Id</th>
                <th>Tracking Number</th>
                <th>Total Price</th>
                <th>Payment Recipt</th>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Actions</th>
            </tr>
           
    <?php foreach($data['orderDetails'] as $order): ?>
    <tr>
        <td><?php echo $order->order_id; ?></td>
        <td><?php echo $order->tracking_no; ?></td>
        <td><?php echo $order->total_price; ?></td>
        <td><a href="<?php echo URLROOT; ?>/assets/images/customer/orderRecipt/<?php echo $order->recipt; ?>">payment Recipt</a></td>
        <td><?php echo $order->customer_name; ?></td>
        <td><?php echo $order->contact_no; ?></td>
        
       
        <td><a href='<?php echo URLROOT; ?>/admin/approveOrder/<?php echo $order->order_id; ?>'><button>Approve</button></a>
        <div class="popup"">
                    <button onclick="myFunction()">Reject</button>
                    <div class="popuptext" id="myPopup">
                    <p>Are you sure you want to  reject and delete this Order?</p><br>
                    <a  class="button" href='#' ><button>Yes</button></a>
                    <a class="button" href='#'><button>No</button></a>
                    </div>
                    </div></td>
    </tr>
<?php endforeach; ?>               
        </table>
        
    </div>
    
   
</body>
<script>
// When the user clicks on div, open the popup
function myFunction() {
  var popup = document.getElementById("myPopup");
  popup.classList.toggle("show");
}
</script>

</html>