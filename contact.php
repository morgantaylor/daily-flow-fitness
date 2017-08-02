<?php
    if(isset($_POST['submit']))
    {
    	//The form has been submitted, prep a nice thank you message
    	$output = '<h1>Thanks for your email!</h1>';
    	//Set the form flag to no display (cheap way!)
    	$flags = 'style="display:none;"';
    	//Deal with the email
        $to = 'dailyflowfitness@gmail.com';
        $subject = 'Client Inquiry';
		$name = "Name: " . strip_tags($_POST['name']) . "\n";
		$email = "Email: " . strip_tags($_POST['email']) . "\n";
		$note = "Message: " . strip_tags($_POST['note']) . "\n";
		
		
		$message = $name . $email . $note;
    	
    	$attachment = chunk_split(base64_encode(file_get_contents($_FILES['uploaded_file']['tmp_name'])));
    	$filename = $_FILES['uploaded_file']['name'];
    	$boundary =md5(date('r', time())); 
    	$headers = "From: clientinquiry@reply.com\r\nReply-To: clientinquiry@reply.com";
    	$headers .= "\r\nMIME-Version: 1.0\r\nContent-Type: multipart/mixed; boundary=\"_1_$boundary\"";
    	$message="This is a multi-part message in MIME format.
--_1_$boundary
Content-Type: multipart/alternative; boundary=\"_2_$boundary\"
--_2_$boundary
Content-Type: text/plain; charset=\"iso-8859-1\"
Content-Transfer-Encoding: 7bit
$message
--_2_$boundary--
--_1_$boundary
Content-Type: application/octet-stream; name=\"$filename\" 
Content-Transfer-Encoding: base64 
Content-Disposition: attachment 
$attachment
--_1_$boundary--";
    	mail($to, $subject, $message, $headers);
		$flags = 'style="display:none;"';
    }
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Contact Me</title>
<style>
form {
	position: relative;
    display: flex;
    flex-direction: column;
    max-width: 600px;
    width: 100%;
    padding: 20px;
    border: none;
    background-color: #ffffff;
    border-radius: 5px;
    margin: 0px 0px 0px -8px;
    font-family: arial, sans-serif;
}
fieldset {
    position: relative;
    width: auto;
    display: flex;
    flex-direction: column;
	margin:0px 0px 15px 0px;
	border:none;
}
label {
	display: block;
    max-width: 100%;
    margin: 0 0 5px 0;
    font-weight: bold;
}
input {
	margin: 0 0 5px 0;
    padding: 6px 0 6px 12px;
    display: block;
    font-family: 'PT Sans', sans-serif;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    width: 97%;
    height: 40px;
    color: #e7e8e8;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #e7e8e8;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.075);
    -wekit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}

textarea {
	border: 1px solid #e7e8e8;
	border-radius: 4px;
	margin: 0 0 5px 0;
    width: 97%;
    height: 100px;
    padding: 6px 0 6px 12px;
}

button {
	margin: 0 5px;
    padding: 15px 25px;
    text-transform: none;
    border-radius: 3px;
    display: inline-block;
    position: relative;
    cursor: pointer;
    min-height: 36px;
    min-width: 88px;
    text-align: center;
    font-size: 16px;
    font-style: inherit;
    font-variant: inherit;
    font-family: inherit;
    text-decoration: none;
    overflow: hidden;
    transition: box-shadow .4s cubic-bezier(.25,.8,.25,1),
                background-color .4s cubic-bezier(.25,.8,.25,1);
    white-space: nowrap;
    vertical-align: middle;
}

.btn-green {
	background-color: #5dcc20;
    color: #ffffff;
    border: 1px solid #5dcc20;
}

.btn-green:hover {
    color: #ffffff;
    background-color: #49a019;
    border-color: #459718;
}
</style>
</head>

<body>
<?php echo $output ?>
<form enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" <?php echo $flags;?>>
<fieldset>
<label>Name:</label>
<input type="text" required name="name" placeholder="Full Name">
</fieldset>
<fieldset>
<label>Email:</label>
<input type="text" required name="email" placeholder="Email Address">
</fieldset>
<fieldset>
<label>Message:</label>
<textarea name="note" placeholder="Type your message here." required></textarea>
</fieldset>
<button type="submit" class="btn-green">Submit</button>
</form>
</body>
</html>


