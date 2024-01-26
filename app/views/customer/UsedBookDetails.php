<?php
    $title = "Used Book Details";
    require APPROOT . '/views/customer/header.php'; //path changed
?>

    <div class="used-detail">
        <div class="back-btn-div">
            <button class="back-btn" onclick="history.back()"><i class="fa fa-angle-double-left"></i> Go Back</button>
        </div>
        <div class="used-des">
            <div class="used-img">
                <div class="sub1-E">
                    <img src="<?php echo URLROOT; ?>/assets/images/customer/book4.jpeg" alt="Book3" class="sub-img-used"> <!--path changed-->
                </div>
                <div class="sub2-E">
                    <img src="<?php echo URLROOT; ?>/assets/images/customer/inside.jpeg" alt="Book3" class="sub-img-used"> <!--path changed-->
                </div>
                <div class="sub3-E">
                    <img src="<?php echo URLROOT; ?>/assets/images/customer/back.jpeg" alt="Book3" class="sub-img-used"> <!--path changed-->
                </div>
            </div>
            <div class="description-used">
            <h3>Description about the book</h3><br>
                <p>The Great Gatsby, third novel by F. Scott Fitzgerald, published in 1925 by Charles Scribner’s Sons. Set in Jazz Age New York, the novel tells the tragic story of Jay Gatsby, a self-made millionaire, and his pursuit of Daisy Buchanan, a wealthy young woman whom he loved in his youth. Unsuccessful upon publication, the book is now considered a classic of American fiction and has often been called the Great American Novel.
                </p>
            </div>
        </div>
        <div class="used-topic">
            <h3>Book Name : <span>The Great Gatsby</span></h3><br>
            <h3>Author of Book : <span>F. Scott Fitzgerald</span></h3><br>
            <h3>Book Category : <span>Novel</span></h3><br>
            <h3>Condition : <span>Used</span></h3><br>
            <h3>Published Date : <span>November 17, 2020</span></h3><br>
            <h3>Price : <span>Rs.1500.00</span></h3><br>
            <h3>Price Type : <span>Fixed</span></h3><br>
            <h3>Weight (grams) : <span>181g</span></h3><br>
            <h3>ISBN Number : <span>ISBN 9780743273565 </span></h3><br>
        </div>
        
        <div class="city-details-U">
        <h3>Town : <span>Panadura</span></h3><br>
            <h3>District : <span>Kalutara</span></h3><br>
            <h3>Postal Code : <span>12500</span></h3><br>
        </div>
        <div class="sub4-U">
            <a href="<?php echo URLROOT; ?>/customer/chat/"><button class="chat-btn-used">Chat</button></a>
        </div>
    </div>

<?php
    require APPROOT . '/views/customer/footer.php'; //path changed
?>
