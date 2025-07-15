<?php
// Set the recipient email address
$to = "froukje.temme@live.nl";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Collect and sanitize input values
  $name = strip_tags(trim($_POST["name"]));
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $subject = strip_tags(trim($_POST["subject"]));
  $message = trim($_POST["message"]);
  $phone = isset($_POST["phone"]) ? strip_tags(trim($_POST["phone"])) : '';

  // Basic validation
  if (empty($name) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
    http_response_code(400);
    echo "Please fill in all required fields correctly.";
    exit;
  }

  // Build the email content
  $email_content = "Name: $name\n";
  $email_content .= "Email: $email\n";
  if ($phone) {
    $email_content .= "Phone: $phone\n";
  }
  $email_content .= "Message:\n$message\n";

  // Email headers
  $headers = "From: $name <$email>";

  // Send the email
  if (mail($to, $subject, $email_content, $headers)) {
    http_response_code(200);
    echo "Your message has been sent successfully!";
  } else {
    http_response_code(500);
    echo "Oops! Something went wrong and we couldn't send your message.";
  }

} else {
  http_response_code(403);
  echo "There was a problem with your submission. Please try again.";
}
?>
