<?php
// Check for empty fields	
$message = $_POST['message'];
	
// Create the email and send the message
$to = 'vadi84@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Alert! New Activity At your Door Step!";

$headers = "From: noreply@vadiedu.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";	
mail($to,$email_subject,$message,$headers);
return true;			
?>
