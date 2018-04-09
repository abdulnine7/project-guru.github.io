<?php
// Check for empty fields
if(empty($_POST['name'])  		||
   empty($_POST['email']) 		||
   empty($_POST['phone'])     ||
   empty($_POST['college'])   ||
   empty($_POST['branch'])    ||
   empty($_POST['year'])      ||
   empty($_POST['type'])      ||
   empty($_POST['category'])  ||
   empty($_POST['message'])	||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
	echo "No arguments Provided!";
	return false;
   }
	
$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$college = strip_tags(htmlspecialchars($_POST['college']));
$branch = strip_tags(htmlspecialchars($_POST['branch']));
$year = strip_tags(htmlspecialchars($_POST['year']));
$type = strip_tags(htmlspecialchars($_POST['type']));
$category = strip_tags(htmlspecialchars($_POST['category']));
$message = strip_tags(htmlspecialchars($_POST['message']));
	
// Create the email and send the message
$to = 'bitwiseabdul@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "Project Guru - Contact Form:  $name";
$email_body = "You have received a new message from your website contact form.\n\n"."Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nCollege: $college\n\nBranch: $branch\n\nYear: $year\n\nType: $type\n\nCategory: $category\n\nMessage:\n$message";
$headers = "From: noreply@project-guru.ml\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";


//Writing received messages to file on server
$text = $email_body;
$text_to_write = "\n--------------------------".date("d/m/Y h:i:s a")."--------------------------\n".$text."\n";

//creating a file with mac address name
$myfile = fopen("mails.txt", "a+") or die("Can't Open file! mails.txt");
fwrite($myfile,$text_to_write);
fclose($myfile);

//Sending mail
mail($to,$email_subject,$email_body,$headers);

//Sending SMS
$curl = curl_init();

$message = "Hey there ". $name .",\nYour request has been received. We will reach you shortly. Stay updated with your mails.\n\n~Project Guru";

$message=urlencode($message);

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://api.msg91.com/api/sendhttp.php?sender=PRJGRU&route=4&mobiles=" . $phone . "&authkey=196448A7QYpXEK5acb0425&country=0&message=" . $message,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

return true;			
?>
