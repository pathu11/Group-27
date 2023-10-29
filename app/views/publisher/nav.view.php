<?php
session_start();

// Access the publisher's name from the session
$publisherName = $_SESSION["publisher_name"] ?? '';
$publisheremail = $_SESSION["publisher_email"] ?? '';
$publishercontact_no = $_SESSION["publisher_contact_no"] ?? '';
$publisherStreet = $_SESSION["publisher_street_name"] ?? '';
$publishertown = $_SESSION["publisher_town"] ?? '';
$publisherdistrict = $_SESSION["publisher_district"] ?? '';
$publisherPostalcode = $_SESSION["publisher_postal_code"] ?? '';
$publisheraccount_name = $_SESSION["publisher_account_name"] ?? '';
$publisheraccount_no = $_SESSION["publisher_account_no"] ?? '';
$publisherbank_name = $_SESSION["publisher_bank_name"] ?? '';
$publisherbranch_name = $_SESSION["publisher_branch_name"] ?? '';
// books

$bookId = $_SESSION["book_book_id"] ?? '';
$bookQuantity = $_SESSION["book_quantity"] ?? '';
$bookDescript = $_SESSION["book_descript"] ?? '';
$bookPrice = $_SESSION["book_price"] ?? '';


// Other code for your HTML page
?>


<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        nav {
            background-color: #01322F;
            color: white;
            padding: 25px;
            width: 100%;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav img {
            height: 50px;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 0 20px;
            position: relative;
            transition: border-bottom 0.2s ease; /* Smooth transition for the hover line */
        }

        nav a:hover {
            color: #00FFF0;
        }

        nav a:hover::after {
            content: '';
            display: block;
            position: absolute;
            bottom: -3px; /* Adjust the position as needed */
            left: 0;
            width: 100%;
            height: 1px;
            background-color: white;
        }

        nav a:last-child {
            margin-left: 20px; /* Adjust as needed to move right corner links to the left */
            margin-right: 30px; /* Increase the right margin for the last link */
        }

        nav a:last-child:hover {
            border-bottom: none; /* Remove the hover line from the last link */
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <img src="http://localhost/Group-27/public/assets/images/publisher/ReadSpot.png" alt="Logo" />
            <div>
                <a href="home.view.php">Home</a>
                <a href="addBooks.view.php">Book Shelf</a>
                <a href="processingorders.view.php">Orders</a>
                <a href="customerSupport.view.php">Customer Support</a>
                <a href="setting.view.php">Settings <i class="fas fa-cogs" style="color: #ffffff;"></i></a>
                <a href="setting.view.php"><i class="fas fa-user" style="color: #ffffff;"></i> Hi <?php echo $publisherName; ?></a>


                <!-- echo "<h1>Welcome, $publisherName!</h1>"; -->
            </div>
        </div>
    </nav>
</body>
