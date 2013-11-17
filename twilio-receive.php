<?php
  
  // db vars
  $dbHost = "us-cdbr-azure-west-b.cleardb.com";
  $dbUser = "bcd4a2c313611e";
  $dbPass = "886d7131";
  $dbName = "hackdukedatabase";

  // msg vars
  $from = $_REQUEST['From'];
  $body = $_REQUEST['Body'];
  
  // get student from db
  $mysqlCon = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
  if (mysqli_connect_errno($mysqlCon)) {
    $responseMessage = "Sorry, an error occurred in storing your response :(";
    exit("Error connecting to db");
  }
  $fromNormalized = substr($from, 2);
  $result = mysqli_query($mysqlCon, "SELECT StudentId FROM student WHERE PhoneNumber=$fromNormalized");
  if ($result == NULL) {
    exit("Received message from non-registered number");
  }
  $studentId = mysqli_fetch_array($result);
  $responseExists = mysqli_query($mysqlCon, "SELECT Response FROM response WHERE StudentId=$studentId") != NULL;
  if ($responseExists) {
    $success = mysqli_query($mysqlCon, "UPDATE response SET Response=$body WHERE StudentId=$studentId");
    if ($success) {
      $messageResponse = "Successfully updated your response in db! Response was: $body";
    } else {
      $messageResponse = "Failed to update your response in db :(";
    }
  } else {
    $success = mysqli_query($mysqlCon, "INSERT INTO response (StudentId, Response) VALUES ('$studentId', \"$body\")");
    if ($success) {
      $messageResponse = "Successfully created your response in db! Response was: $body";
    } else {
      $messageResponse = "Failed to create your response in db :(";
    }
  }
?>

<Response>
  <Message>
    <?php echo $messageResponse ?>
  </Message>
</Response>
