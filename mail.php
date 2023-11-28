<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  require_once 'PHPMailer-master/PHPMailer-master/src/Exception.php';
  require_once 'PHPMailer-master/PHPMailer-master/src/PHPMailer.php';
  require_once 'PHPMailer-master/PHPMailer-master/src/SMTP.php';
  require_once 'connection/conn.php';

function send_mail($recipient,$subject,$message)
{

  $mail = new PHPMailer();
  $mail->IsSMTP();

  $mail->SMTPDebug  = 0;  
  $mail->SMTPAuth   = TRUE;
  $mail->SMTPSecure = "tls";
  $mail->Port       = 587;
  $mail->Host       = "smtp.gmail.com";
  //$mail->Host     = "smtp.mail.yahoo.com";
  $mail->Username   = "achmadtirtosudirosudiro@gmail.com";
  $mail->Password   = "oxvmjxgmcppgvaas";

  $mail->IsHTML(true);
  $mail->AddAddress($recipient, "Pengguna yang terhormat");
  $mail->SetFrom("achmadtirtosudirosudiro@gmail.com", "Fountaine Project Hotel");
  //$mail->AddReplyTo("reply-to-email", "reply-to-name");
  //$mail->AddCC("cc-recipient-email", "cc-recipient-name");
  $mail->Subject = $subject;
  $content = $message;

  $mail->MsgHTML($content); 
  if(!$mail->Send()) {
    // echo "Error: " . $mail->ErrorInfo;
    // echo "<pre>";
    // var_dump($mail);
    return false;
  } else {
    // echo "Email sent successfully";
    return true;
  }

}

?>