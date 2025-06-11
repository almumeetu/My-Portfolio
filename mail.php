<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = $_POST['full-name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $phone   = $_POST['phone-number'] ?? '';
    $budget  = $_POST['budget'] ?? '';
    $message = $_POST['message'] ?? '';

    if (!$name || !$email || !$subject || !$message) {
        echo "❌ Error: Please fill in all required fields.";
        exit;
    }

    $to = "almumeetu@gmail.com"; 
    $email_subject = "Portfolio Contact Form: $subject";
    $email_body = "Name: $name\nEmail: $email\nPhone: $phone\nBudget: $budget\n\nMessage:\n$message";
    $headers = "From: $email\r\nReply-To: $email\r\n";

    // File attachment handling
    if (!empty($_FILES['file']['tmp_name'])) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_type = $_FILES['file']['type'];
        $handle = fopen($file_tmp, "r");
        $content = fread($handle, $file_size);
        fclose($handle);
        $encoded_content = chunk_split(base64_encode($content));

        $boundary = md5("random");
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary = $boundary\r\n\r\n";

        $body = "--$boundary\r\n";
        $body .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= chunk_split(base64_encode($email_body));

        $body .= "--$boundary\r\n";
        $body .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
        $body .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
        $body .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $body .= $encoded_content . "\r\n";
        $body .= "--$boundary--";

        $email_body = $body;
    }

    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "✅ Success: Your message was sent successfully.";
    } else {
        echo "❌ Error: Failed to send the message.";
    }
} else {
    echo "❌ Invalid request.";
}
?>
