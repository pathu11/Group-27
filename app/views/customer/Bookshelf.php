<?php
    $title = "Book Shelf";
    include_once 'header.php';
?>

    <div class="container">
        <div class="sidebar">
        <!-- Sidebar content goes here -->
        <div class="profile-section">
            <img src="http://localhost/Group-27/public/assets/images/customer/profile.png" alt="Profile Image" class="profile-image">
            <?php 
            if (isset($_SESSION["customer_name"])){
                echo '<h2 class="profile-name1">'.$_SESSION["customer_name"].'</h2>';
            } else {
                echo '<h2 class="profile-name1">NO USER</h2>';
            }
            ?>
        </div>
        <br>
        <hr>

        <!-- Menu section -->
        <div class="menu-section">
            <ul class="menu-list">
                <li data-page="Dashboard"><a href="./Dashboard.php">Dashboard</a></li>
                <li data-page="Profile"><a href="./Profile.php">Profile</a></li>
                <li data-page="Notification"><a href="./Notification.php">Notification</a></li>
                <li data-page="Bookshelf"><a href="./Bookshelf.php">Bookshelf</a></li>
                <li data-page="Content"><a href="./Content.php">Content</a></li>
                <li data-page="Cart"><a href="./Cart.php">Cart</a></li>
            </ul>
        </div>
        </div>

        <div class="book-shelf">
            <div class="used-books">
                <h2>Used Books</h2>
                <div class="books">
                    <div class="B1">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book1" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B2">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book2" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B3">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book3" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B4">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book4" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B5">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book5" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                </div>
            </div>
            <div class="vw">
                <a href="./UsedBooks.php"><button class="vw-btn">View All >></button></a>
            </div>
            <br>
            <br>
            <br>
            <hr>
            <div class="exchange-books">
                <h2>Exchange Books</h2>
                <div class="books">
                    <div class="B1">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book1" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B2">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book2" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B3">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book3" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B4">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book4" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                    <div class="B5">
                        <img src="http://localhost/Group-27/public/assets/images/customer/book.jpg" alt="Book5" class="Book"><br>
                        <!-- <button class="dts-btn">View Details</button> -->
                    </div>
                </div>
            </div>
            <div class="vw">
                <a href="./ExchangeBooks.php"><button class="vw-btn">View All >></button></a>
            </div>
        </div>
    </div>

<?php
    include_once 'footer.php';
?>