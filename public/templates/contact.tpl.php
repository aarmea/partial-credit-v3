<script src="js/email.js"></script>
<div class="row">
  <div class="medium-4 medium-push-8 columns">
    <h2>Thank You</h2>
    <p>
      To contact us about potential performances, questions, or just to give
      us feedback, fill out this form or email our officer list at
      <script>
        mail("partialcredit", "union.rpi", 5, "?subject=PC Contact")
      </script>.
    </p>
  </div>
  <div class="medium-8 medium-pull-4 columns">
    <h1>Contact Us</h1>
    <form action="post.php" method="post">
      <label for="message-name">Name</label>
      <input type="text" required id="message-name" name="message_name">
      <label for="message-email">Email</label>
      <input type="email" required id="message-email" name="message_email">
      <label for="message-subject">Subject</label>
      <input type="text" required id="message-subject" name="message_subject">
      <label for="message-content">Message</label>
      <textarea id="message-content" required name="message_content" rows="8"></textarea>
      <button type="submit" name="action" value="send_mail">Send</button>
    </form>
  </div>
</div>
