<!DOCTYPE html>
<html>
<title>Admin landing page</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://localhost/Group-27/public/assets/css/admin/adminNav.css">
<link rel="stylesheet" href="http://localhost/Group-27/public/assets/css/admin/style.css">
<link rel="stylesheet" href="http://localhost/Group-27/public/assets/css/admin/footer.css">
<body>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const userIcon = document.querySelector(".user");
      const subMenu = document.getElementById("subMenu");
  
      userIcon.addEventListener("click", function() {
        subMenu.classList.toggle("open-menu");
      });
    });
  </script>
  <?php require 'nav.view.php'?>

  <div class="grid-container">
    <div class="grid-item"><a href="#customers">Customers</a></div>
    <div class="grid-item"><a href="#publishers">Publishers</a></div>
    <div class="grid-item"><a href="#orders">Orders</a></div>
    <div class="grid-item"><a href="#payments">Payments</a></div>
    <div class="grid-item"><a href="#complains">Complains</a></div>
    <div class="grid-item"><a href="#charity organizations">Charity Organizations</a></div>
    <div class="grid-item"><a href="#pending requests">Pending Requests</a></div>
    <div class="grid-item"><a href="categories.view.php">Categories</a></div>
    <div class="grid-item"><a href="#delivary status">Delivery Status</a></div>
  </div>


</body>
</html>