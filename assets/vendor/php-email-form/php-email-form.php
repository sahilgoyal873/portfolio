<?php
/**
 * Simple replacement for BootstrapMade's PHP Email Form library.
 * Handles validation and sending via PHP's mail() function or SMTP if configured.
 */

class PHP_Email_Form {
  public $to;
  public $from_name;
  public $from_email;
  public $subject;
  public $ajax = false;
  public $messages = array();
  public $smtp = false; // set to array() with host, username, password, port if using SMTP

  public function add_message($content, $label, $minlength = 0) {
    if (!empty($content) && strlen($content) >= $minlength) {
      $this->messages[] = "$label: $content\n";
    }
  }

  public function send() {
    if (empty($this->to)) {
      return "No recipient email set!";
    }

    $email_text = "You have a new message from your website contact form:\n\n";
    $email_text .= implode("\n", $this->messages);

    $headers = "From: {$this->from_name} <{$this->from_email}>\r\n";
    $headers .= "Reply-To: {$this->from_email}\r\n";

    // Use SMTP if configured
    if ($this->smtp && is_array($this->smtp)) {
      return $this->send_smtp($email_text, $headers);
    } else {
      if (mail($this->to, $this->subject, $email_text, $headers)) {
        return "OK";
      } else {
        return "Email sending failed. Check server mail configuration.";
      }
    }
  }

  private function send_smtp($message, $headers) {
    // For SMTP you should ideally use PHPMailer, but here's a placeholder
    return "SMTP not implemented in this simple version. Please use PHPMailer or similar.";
  }
}
