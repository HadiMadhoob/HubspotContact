<!DOCTYPE html>
<html lang="en">
<head>
    <title>Contact Us</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php if (isset($_POST) && !empty($_POST)) {
     $error = 1;
     $message = '';
     $sucmsg = '';
     if ($_POST['name'] = '') {
         $error = 0;
     }
     $mail = $_POST['email'];
     if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
     }
     $phone = $_POST['phone'];
     if (!filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT)) {
     }
     if ($_POST['message'] == ' ') {
         $error = 0;
     }
     if ($error == 1) {
         $name = $_POST['name'];
         $headers = "From:$name <$mail>" . "\r\n";
         $phn = $_POST['phone'];
         $msg = $_POST['message'];
         if (mail("hadikarim@msn.com", "$phn", $msg, $headers)) {
             $sucmsg = "Thank you for Contact Us !";
         }
     }
    } ?>

    <!-- Contact Us Form PHP Section -->
    <section class="contact-us"> 
        <div class="success-msg">
            <?php if(isset($message) && $message!=''){?>
                <?=$message; ?>
            <?php } ?>
            <?php 
             if(isset($sucmsg) && !empty($sucmsg)){
                 echo $sucmsg;
             } ?> 
        </div>

        <h1>Contact Us</h1>                
        <form action="submit" method="post">
            <input type="text" name="name" required  class="form-control" id="name" placeholder="Name" />
            <input type="email" class="form-control" required name="email" id="email" placeholder="Email" />
            <input type="phone" class="form-control" required name="phone" id="phone" placeholder="Mobile" />
            <textarea class="form-control" name="message" id="message"  required  placeholder="Message"></textarea>
            <button type="submit">Submit</button>
        </form>
    </section>
    <!-- End Contact Us Form PHP Section -->
</body>
</html>

<?php

if( isset($_POST['submit']) )
{

	$name=$_POST['name'];
	$phone=$_POST['phone'];
	$email=$_POST['email'];
	$message=$_POST['message'];


	$contact_data = array(
		"name" => $name,
		"email" => $email,
		"phone" => $phone,
		"message" => $message,
	);
	
	$hubspot_connect = new hubspot_connect();
	$hubspot_connect->contact_create($contact_data);  

}

class hubspot_connect{
	private $hapikey = "eu1-ef40-79f6-4f99-b02e-02cd60e9e0d3";	

	function contact_create($contact_data){
     $arr = array(
        'properties' => array(
            array(
                'property' => 'message',
                'value' => $contact_data["message"]
            ),
            array(
                'property' => 'phone',
                'value' => $contact_data["phone"]
            ),
            array(
                'property' => 'email',
                'value' => $contact_data["email"]
            ),
			array(
                'property' => 'name',
                'value' => $contact_data["name"]
            )
            
        )
    );

        $post_json = json_encode($arr);
        $endpoint = 'https://api.hubapi.com/contacts/v1/contact?hapikey=' . $this->hapikey;
		$this->http($endpoint,$post_json);
	}
	
	function http($endpoint,$post_json){

        $ch = @curl_init();
        @curl_setopt($ch, CURLOPT_POST, true);
        @curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        @curl_setopt($ch, CURLOPT_URL, $endpoint);
        @curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        @curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = @curl_exec($ch);
        $status_code = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errors = curl_error($ch);
        @curl_close($ch);
        return $response . "<hr>";
       
	}
}

?> 
