<?php
    $title = "My Exchange Books";
    require APPROOT . '/views/customer/header.php'; //path changed
?>
    <?php
        require APPROOT . '/views/customer/sidebar.php'; //path changed
    ?>
    <div class="container">
        <div class="book-shelf">
            <div class="back-btn-div">
                <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-double-left"></i> Go Back</button>
            </div>
            <div class="exchange-books">
                <h2>Exchange Books</h2>
                <form action="#.php" class="mybook-search">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><img src="<?php echo URLROOT; ?>/assets/images/customer/search.png"></button> <!--path changed-->
                </form>
                <br>
                <br>
                <div class="books">
                    <?php if (empty($data['bookDetails'])): ?>
                        <div class="B-div-noBook">
                            <p>No books added yet.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($data['bookDetails'] as $bookDetails): ?>
                            <div class="B-div">
                                <?php echo '<img src="' . URLROOT . '/assets/images/customer/AddExchangeBook/' .  $bookDetails->img1 . '" class="Book"><br>'; ?>
                                <a href="<?php echo URLROOT; ?>/customer/ViewBookExchange/<?php echo $bookDetails->book_id; ?>"><button class="ub-dts-btn">View Details</button></a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="eb-vw">
                    <a href="<?php echo URLROOT; ?>/customer/AddExchangeBook"><button class="eb-vw-btn">Add a Book</button></a> <!--path changed-->
                </div>
                <br>
                <br>
            </div>
        </div>
        <?php
            require APPROOT . '/views/customer/footer.php'; //path changed
        ?>
    </div>
