<?php
// Your Email
    $recipient = "iftikharbq@gmail.com"; 


    // Check $recipient
    if($recipient === '') {
        returnAndExitAjaxResponse(
            constructAjaxResponseArray(
                FALSE,
                'RECIPIENT_IS_NOT_SET',
                array('error_message'=> 'RECIPIENT email address is not set. Please configure the script.')
            )
        );
    }

if ($_POST['captcha_challenge'] == $_SESSION['captcha_text']) {


    // Check for empty required field
    if(!isset($_POST["email"]) || !isset($_POST["fname"]) || !isset($_POST["message"])) {
        returnAndExitAjaxResponse(
            constructAjaxResponseArray(
                FALSE,
                'MISSING_REQUIRED_FIELDS',
                array('error_message'=> 'MISSING_REQUIRED_FIELDS should not be occurred.')
            )
        );
    }

    // Sanitize input
    $fname  = filter_var($_POST["fname"], FILTER_SANITIZE_STRING);
    $lname  = filter_var($_POST["lname"], FILTER_SANITIZE_EMAIL);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);


    // Headers
    $headers = 'From: '.$fname.' <'.$email.'>' . "\r\n";
    $headers .= 'Reply-To: '.$email.'' . "\r\n";
    $headers .= 'X-Mailer: PHP/' . phpversion();

    // Subject
    $subject = "Neue E-Mail von Kontakt Formular";

    // Build Message
    $email_content = "Firma: $fname\n";
    $email_content .= "Ihr Name: $lname\n";
    $email_content .= "Telefon nummer: $telefonnummer\n"; 
    $email_content .= "Email: $email\n\n";
    $email_content .= "Nachricht:\n$message\n\n\n";
    $email_content .= "CLIENT IP:\n".get_client_ip()."\n";
    $email_content .= "HOST IP:\n".$_SERVER['SERVER_ADDR']."\n";

else {
    } echo '<p>Captcha verification is wrong. Take other action.</p>';

}


// Check if sent
try {
    $sendmailResult = mail($recipient, $subject, $email_content, $headers);
    if( $sendmailResult === TRUE ) {
        returnAndExitAjaxResponse(
            constructAjaxResponseArray(
                TRUE
            )
        );
    } else {
        returnAndExitAjaxResponse(
            constructAjaxResponseArray(
                FALSE,
                'ERROR_AT_PHPMAIL',
                array('error_information'=> error_get_last() )
            )
        );
    }
} catch (Exception $_e) {
    returnAndExitAjaxResponse(
        constructAjaxResponseArray(
            TRUE,
            'ERROR_AT_PHPMAIL',
            array('error_message'=> $_e->getMessage())
        )
    );
}


function constructAjaxResponseArray ($_response, $_message = '', $_json = null) {
    $_responseArray = array();
    $_response = ( $_response === TRUE ) ? TRUE : FALSE;
    $_responseArray['response'] = $_response;
    if(isset($_message)) $_responseArray['message'] = $_message;
    if(isset($_json)) $_responseArray['json'] = $_json;

    return $_responseArray;
}

function returnAndExitAjaxResponse ($_ajaxResponse) {
    if(!$_ajaxResponse){
        $_ajaxResponse = array('response'=>false,'message'=>'Unknown error occurred.');
    }
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode($_ajaxResponse);
    die();
}


// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if(isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if(isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if(isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}