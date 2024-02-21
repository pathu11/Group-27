<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/admin/nav.css" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/assets/css/moderator/createChallenge.css" />
  <title>Create Challenge</title>
</head>
<body>
  <?php require APPROOT . '/views/moderator/nav.php';?>
  <div class="form-container">
    <span>Enter Quiz Details</span>
    <form action="<?php echo URLROOT;?>/moderator/createChallenge" method="post">
      <input type="text" name="title" id="title" placeholder="Enter Quiz Title">
      <input type="number" name="number_of_questions" id="number_of_questions" placeholder="Enter total number of questions">
      <input type="number" name="marks_right_answer" id="marks_right_answer" placeholder="Enter marks on right answer">
      <input type="number" name="marks_wrong_answer" id="marks_wrong_answer" placeholder="Enter marks on wrong answer">
      <input type="number" name="time_limit" id="time_limit" placeholder="Enter Time Limit in minutes">
      <input type="textarea" name="description" id="description" placeholder="Enter Quiz Description">
    </form>
    <button type="submit">Submit</button>
  </div>

</body>
</html>