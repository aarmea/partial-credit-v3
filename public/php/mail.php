<?
function printMail($mailInfo) {
  echo '<pre>' . PHP_EOL;
  echo 'Sender: ' . $mailInfo['message_name'];
  echo ' (' . $mailInfo['message_email'] . ')' . PHP_EOL;
  echo 'Subject: ' . $mailInfo['message_subject'] . PHP_EOL;
  echo 'Message:' . PHP_EOL;
  echo $mailInfo['message_content'];
}

function sendMail($mailInfo) {
  if (
    !isset($mailInfo['message_name']) || !isset($mailInfo['message_email']) ||
    !isset($mailInfo['message_subject']) || !isset($mailInfo['message_content'])
  ) {
    echo 'Message could not be sent because of missing fields.';
    printMail($mailInfo);
    return;
  }
  $headers = 'From: ' . $mailInfo['message_email'];
  $to = 'partialcredit@union.rpi.edu';
  $subject = '[Contact Page] from ' . $mailInfo['message_name'] . ' regarding ';
  $subject .= $mailInfo['message_subject'];
  if (!mail($to, $subject, $mailInfo['message_content'], $headers)) {
    echo 'Message could not be sent.';
  }
}
?>
