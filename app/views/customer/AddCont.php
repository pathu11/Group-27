<?php
    $title = "Dashboard";
    include_once 'header.php';
?>

    <div class="container">
        <?php
            include_once 'sidebar.php';
        ?>

        <div class="add-content">
            <form action="#" class="cont-add">
                <h1>Add a Content</h1>
                <div class="topic-cont">
                    <label class="label-topic" required>Topic</label><br>
                    <input type="text" class="form-topic">
                </div>
                <div class="disc-cont">
                    <label class="label-topic">Description</label><br>
                    <textarea id="description" name="description" rows="12" class="form-topic" required></textarea>
                </div>
                <div class="upload-doc">
                    <div class="img-cont">
                        <label class="label-topic">Upload Image</label><br>
                        <input type="file" id="picture" name="picture" accept="image/*" required>
                    </div>
                    <div class="pdf-cont">
                        <label class="label-topic">Upload Document</label><br>
                        <input type="file" id="pdf" name="pdf" accept=".pdf" required>
                    </div>
                </div>
                <input type="submit" value="Submit">
            </form>
        </div>
    </div>
<?php
    include_once 'footer.php';
?>
