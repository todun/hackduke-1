<?php
include 'sendgrid-php/lib/SendGrid.php';
$sendgrid = new SendGrid('azure_0c3c5610525389e9875c7eda6e42678a@azure.com', '7rjwkvyt');
$mail = new SendGrid\Mail();
echo "new sendgrid mail created";
$mail->
  addTo('jcw46@duke.edu')->
  setFrom('xurui203@gmail.com')->
  setSubject('Payment')->
  setText('Here is your $20!')->
  setHtml('<strong>Here is your $20!</strong>');
$sendgrid->
smtp->
  send($mail);
?>
