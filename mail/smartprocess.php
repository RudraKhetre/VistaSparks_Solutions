<?php 

	if (!isset($_SESSION)) session_start(); 
	if(!$_POST) exit;
	
	include dirname(__FILE__).'/settings/settings.php';
	include dirname(__FILE__).'/functions/emailValidation.php';
	
	
	/* Current Date Year
	------------------------------- */		
	$currYear = date("Y");		
	
/*	---------------------------------------------------------------------------
	: Register all form field variables here
	--------------------------------------------------------------------------- */
	$form = strip_tags(trim($_POST["contact-form"]));
	$sendername = strip_tags(trim($_POST["contact-name"]));	
	$emailaddress = strip_tags(trim($_POST["contact-email"]));
	$city = strip_tags(trim($_POST["contact-city"]));
	$telephone = strip_tags(trim($_POST["contact-phone"]));
	$coursecode = strip_tags(trim($_POST["contact-code"]));
	$coursename = strip_tags(trim($_POST["contact-course"]));
	$occupation = strip_tags(trim($_POST["contact-occupation"]));
	$sendermessage = strip_tags(trim($_POST["contact-message"]));
	$fname = strip_tags(trim($_POST["contact-fname"]));
	$fcontact = strip_tags(trim($_POST["contact-fcontact"]));

	
/*	----------------------------------------------------------------------
	: Prepare form field variables for CSV export
	----------------------------------------------------------------------- */	
	if($generateCSV == true){
		$csvFile = $csvFileName;	
		$csvData = array(
			"$sendername",
			"$emailaddress",
			"$telephone",
		);
	}

/*	-------------------------------------------------------------------------
	: Prepare serverside validation 
	------------------------------------------------------------------------- */ 
	$errors = array();
	//validate name
	if(isset($_POST["contact-form"])){
		
		if (!$form) {
			$errors[] = "You must enter a Form Name.";
		} elseif(strlen($form) < 2)  {
			$errors[] = "Form Name must be at least 2 characters.";
		}

	}

	 //validate name
	if (!$sendername) {
		$errors[] = "You must enter a name.";
	} elseif(strlen($sendername) < 2)  {
		$errors[] = "Name must be at least 2 characters.";
	}
	
	//validate email address
	if($form !="refer"){
		if (!$emailaddress) {
			$errors[] = "You must enter an email.";
		} else if (!validEmail($emailaddress)) {
			$errors[] = "Your must enter a valid email.";
		}
	}

	//validate contact
	if (!$telephone) {
		$errors[] = "You must enter a contact number.";
	} elseif(strlen($telephone) < 5 || is_numeric($telephone) !=1)  {
		$errors[] = "Your must enter a valid contact number.";
	}

	//validate course code
	if($form == "enroll"){
	 
		if (!$coursecode) {
			$errors[] = "You must enter a course code.";
		} elseif(strlen($coursecode) < 2)  {
			$errors[] = "Your must enter a valid course code.";
		}
 	}

	 if($form == "campaign"){
		if (!$city) {
			$errors[] = "You must enter a City.";
		} elseif(strlen($city) < 2)  {
			$errors[] = "Your must enter a valid city.";
		}
	 }

	//validate course name
	 if($form == "demo" || $form=="enquire" || $form =="instructor"){
	 
		if (!$coursename) {
			$errors[] = "You must enter a course name.";
		} elseif(strlen($coursename) < 2)  {
			$errors[] = "Your must enter a valid course name.";
		}
		if($form == 'instructor'){
			$receiver_email = 'contact@novatec.co.in';
			$receiver_name = 'Novatec';
		}
 	}

	 //validate course name
	 if(($form == "demo" || $demo == "contact")){
	 
		if (!$occupation) {
			$errors[] = "You must enter a occupation.";
		} elseif(strlen($occupation) < 2)  {
			$errors[] = "Your must enter a valid occupation.";
		}
 	}
	 if($form == "refer"){
	 
		if (!$fname) {
			$errors[] = "You must enter a Friend's Name.";
		} elseif(strlen($fname) < 2)  {
			$errors[] = "Your must enter a valid Friend's Name.";
		}

		if (!$fcontact) {
			$errors[] = "You must enter a Friend's contact number.";
		} elseif(strlen($fcontact) < 5 || is_numeric($fcontact) !=1)  {
			$errors[] = "Your must enter a valid Friend's contact number.";
		}
 	}
	 
	
	
	
	
	

	if ($errors) {
		//Output errors in a list
		$errortext = "";
		foreach ($errors as $error) {
			$errortext .= '<li>'. $error . "</li>";
		}
	
		echo json_encode(array('info' => 'error', 'msg' =>'The following errors occured:<br><ul>'. $errortext .'</ul>'));

	} else{
	
		include dirname(__FILE__).'/phpmailer/PHPMailerAutoload.php';
		include dirname(__FILE__).'/templates/smartmessage.php';
			
		$mail = new PHPMailer();
		$mail->isSendmail();
		$mail->IsHTML(true);
		$mail->From = $emailaddress;
		$mail->CharSet = "UTF-8";
		$mail->FromName = $sendername;
		$mail->Encoding = "base64";
		$mail->Timeout = 200;
		$mail->ContentType = "text/html";
		$mail->addAddress($receiver_email, $receiver_name);
		$mail->Subject = $receiver_subject;
		$mail->Body = $message;
		$mail->AltBody = "Use an HTML compatible email client";
				
		// For multiple email recepients from the form 
		// Simply change recepients from false to true
		// Then enter the recipients email addresses
		// echo $message;
		$recipients = false;
		if($recipients == true){
			$recipients = array(
				"contact@novatec.co.in" => "Novatec",
			);
			
			foreach($recipients as $email => $name){
				$mail->AddBCC($email, $name);
			}	
		}
		
		if($mail->Send()) {
			/*	-----------------------------------------------------------------
				: Generate the CSV file and post values if its true
				----------------------------------------------------------------- */		
				if($generateCSV == true){	
					if (file_exists($csvFile)) {
						$csvFileData = fopen($csvFile, 'a');
						fputcsv($csvFileData, $csvData );
					} else {
						$csvFileData = fopen($csvFile, 'a'); 
						$headerRowFields = array(
							"Guest Name",
							"Email Address",
							"Subject"									
						);
						fputcsv($csvFileData,$headerRowFields);
						fputcsv($csvFileData, $csvData );
					}
					fclose($csvFileData);
				}	
				
			/*	---------------------------------------------------------------------
				: Send the auto responder message if its true
				--------------------------------------------------------------------- */
				if($autoResponder == true){
				
					include dirname(__FILE__).'/templates/autoresponder.php';
					
					$automail = new PHPMailer();
					$automail->isSendmail();
					$automail->From = $receiver_email;
					$automail->FromName = $receiver_name;
					$automail->isHTML(true);                                 
					$automail->CharSet = "UTF-8";
					$automail->Encoding = "base64";
					$automail->Timeout = 200;
					$automail->ContentType = "text/html";
					$automail->AddAddress($emailaddress, $sendername);
					$automail->Subject = "Thank you for contacting us";
					$automail->Body = $automessage;
					$automail->AltBody = "Use an HTML compatible email client";
					$automail->Send();	 
				}
				
				if($redirectForm == true){
					echo '<script>setTimeout(function () { window.location.replace("'.$redirectForm_url.'") }, 500); </script>';
				}
							
			  	echo json_encode(array('info'=>'success', 'msg'=>'Message has been sent successfully!'));
				} 
				else {
					echo json_encode(array('info'=>'error', 'msg'=>'Message not sent - server error occured!<br>Mailer Error: '. $mail->ErrorInfo));
				}
	}
?>