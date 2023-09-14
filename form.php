<?php
//start session to match with captcha session variable
session_start();
//Get form data
$captcha = $_POST['captcha'];
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];
//validation for email
$email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
if (!preg_match($email_exp, $email)) {
?>
<div class="alert alert-success alert-dismissible fade show">
The Email address you entered is not valid.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
exit;
}
//Match with captcha session data
if($captcha == $_SESSION['captcha']){
$to = "iftikharbq@gmail.com";  //recipient email address
$subject = "Contact Form";  //Subject of the email
//Message content to send in an email
$message = "Name: ".$name."<br>Email: ".$email."<br> Message: ".$message;
// Set content type as HTML
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
//Email headers
$headers .= "From:".$email."\r\n";
//$headers .= "CC: someone@example.com";
$headers .= "Reply-To:".$email."\r\n";
//Send email 
$sendmail = mail($to, $subject, $message, $headers);
if($sendmail == true){ 
?>
<div class="alert alert-success alert-dismissible fade show">
The message has been sent successfully.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}else {
?>
<div class="alert alert-danger alert-dismissible fade show">
The message could not be sent.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
}else{
?>
<div class="alert alert-danger alert-dismissible fade show">
Captcha is not matching. Please enter the correct captcha code.
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php
}
?>