<?php

$output = json_encode(array('type' => 'message', 'text' => 'Hi , Thanks for contacting us! We will be in touch with you shortly '));
die($output);


//Recepient Email Address
$to_email       = "info@oqc.ae";

//check if its an ajax request, exit if not
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) and strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
    $output = json_encode(array( //create JSON data
        'type' => 'error',
        'text' => 'Sorry Request must be Ajax POST'
    ));
    die($output); //exit script outputting json data
}

//Sanitize input data using PHP filter_var().
$first_name      = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
$companyname   = filter_var($_POST["companyname"], FILTER_SANITIZE_STRING);
$email_address   = filter_var($_POST["email_address"], FILTER_SANITIZE_EMAIL);
$phonenumber   = filter_var($_POST["phonenumber"], FILTER_SANITIZE_STRING);
$description   = filter_var($_POST["description"], FILTER_SANITIZE_STRING);

$subject         = "OQC Website Contact Enquiry";


//Textbox Validation 
if (strlen($first_name) < 3) { // If length is less than 4 it will output JSON error.
    $output = json_encode(array('type' => 'message', 'text' => 'Name is too short or empty!'));
    die($output);
}



$message = '<html><body>';
$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr style='background: #eee;'><td><strong>First Name:</strong> </td><td>" . strip_tags($_POST['name']) . "</td></tr>";
$message .= "<tr><td><strong>Email Address :</strong> </td><td>" . strip_tags($_POST['email_address']) . "</td></tr>";
$message .= "<tr><td><strong>Phone Number :</strong> </td><td>" . strip_tags($_POST['phonenumber']) . "</td></tr>";
$message .= "<tr><td><strong>Company Name :</strong> </td><td>" . strip_tags($_POST['companyname']) . "</td></tr>";
$message .= "<tr><td><strong>Message :</strong> </td><td>" . strip_tags($_POST['description']) . "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";


$file_attached = false;
if (isset($_FILES['file_attach'])) //check uploaded file
{
    //get file details we need
    $file_tmp_name    = $_FILES['file_attach']['tmp_name'];
    $file_name        = $_FILES['file_attach']['name'];
    $file_size        = $_FILES['file_attach']['size'];
    $file_type        = $_FILES['file_attach']['type'];
    $file_error       = $_FILES['file_attach']['error'];



    //exit script and output error if we encounter any
    if ($file_error > 0) {
        $mymsg = array(
            1 => "The uploaded file exceeds the upload_max_filesize directive in php.ini",
            2 => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form",
            3 => "The uploaded file was only partially uploaded",
            4 => "No file was uploaded",
            6 => "Missing a temporary folder"
        );

        $output = json_encode(array('type' => 'error', 'text' => $mymsg[$file_error]));
        die($output);
    }

    //read from the uploaded file & base64_encode content for the mail
    $handle = fopen($file_tmp_name, "r");
    $content = fread($handle, $file_size);
    fclose($handle);
    $encoded_content = chunk_split(base64_encode($content));
    //now we know we have the file for attachment, set $file_attached to true
    $file_attached = true;
}



if ($file_attached) //continue if we have the file
{

    // a random hash will be necessary to send mixed content
    $separator = md5(time());

    // carriage return type (RFC)
    $eol = "\r\n";

    // main header (multipart mandatory)
    $headers = "From:Fromname <info@fromemail.com>" . $eol;
    $headers .= "MIME-Version: 1.0" . $eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
    $headers .= "Content-Transfer-Encoding: 7bit" . $eol;
    $headers .= "This is a MIME encoded message." . $eol;

    // message
    $body .= "--" . $separator . $eol;
    $body .= "Content-type:text/html; charset=utf-8\n";
    $body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
    $body .= $message . $eol;

    // attachment
    $body .= "--" . $separator . $eol;
    $body  .= "Content-Type:" . $file_type . " ";
    $body .= "Content-Type: application/octet-stream; name=\"" . $file_name . "\"" . $eol;
    $body .= "Content-Transfer-Encoding: base64" . $eol;
    $body .= "Content-Disposition: attachment; filename=\"" . $file_name . "\"" . $eol;
    $body .= $encoded_content . $eol;
    $body .= "--" . $separator . "--";
} else {

    $eol = "\r\n";

    $headers = "From: Fromname <info@fromemail.com>" . $eol;
    $headers .= "Reply-To: " . strip_tags($email_address) . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    $body .= $message . $eol;
}

//please uncomment for working form
//   $send_mail = mail($to_email, $subject, $body, $headers);

//   if(!$send_mail)
//   {
//       //If mail couldn't be sent output error. Check your PHP email configuration (if it ever happens)
//       $output = json_encode(array('type'=>'error', 'text' => 'Could not send mail! Please check your details'));
//       die($output);
//   }else{
//       $output = json_encode(array('type'=>'message', 'text' => 'Hi '.$first_name .' Thanks for contacting us! We will be in touch with you shortly '));
//       die($output);
//   }

$output = json_encode(array('type' => 'message', 'text' => 'Hi ' . $first_name . ' Thanks for contacting us! We will be in touch with you shortly '));
die($output);
