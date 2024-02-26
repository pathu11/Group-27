<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="<?php echo URLROOT;?>/assets/css/customer/question.css" rel="stylesheet">

  <title>Quiz</title>
</head>
<body>
  <div class="question">
    <p style="color:#0B5E70"><strong>Question 01</strong></p>
    <p><?php echo $data['question'];?>?</p>
  </div>
  <div class="img-options">
    <div class="image">
      <img src="<?php echo URLROOT;?>/assets/images/customer/q1.jpg">
    </div>
    <div class="options">
      <form id="quizForm" action="<?php echo URLROOT; ?>/customer/quizQuestion/<?php echo $data['quiz_id'];?>/1" method="post">
        <div class="container">
          <input type="radio" name="option" value="opt1">
          <label><?php echo $data['option1'];?></label">
        </div>
        <div class="container">
          <input type="radio" name="option" value="opt2">
          <label><?php echo $data['option2'];?></label">
        </div>
        <div class="container">
          <input type="radio" name="option" value="opt3">
          <label><?php echo $data['option3'];?></label">
        </div>
        <div class="next">
          <button type="submit"><strong>Question 02</strong><i class="fa fa-solid fa-forward fa-lg"></i></button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>