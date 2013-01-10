<?php 
//http://www.hongkiat.com/blog/ajax-html5-css3-contact-form-tutorial/

error_reporting(E_ALL ^ E_NOTICE); // hide all basic notices from PHP

//If the form is submitted
if(isset($_POST['submitted'])) {
	
	//sumbission data
	$ipaddress = $_SERVER['REMOTE_ADDR'];
	$date = date('d/m/Y');
	$time = date('H:i:s');

	// require a name from user
	if(trim($_POST['contactName']) === '') {
		$nameError =  'Forgot your name!'; 
		$hasError = true;
	} else {
		$name = trim($_POST['contactName']);
	}
	
	// need valid email
	if(trim($_POST['email']) === '')  {
		$emailError = 'Forgot to enter in your e-mail address.';
		$hasError = true;
	} else if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", trim($_POST['email']))) {
		$emailError = 'You entered an invalid email address.';
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}
		
	// we need at least some content
	if(trim($_POST['comments']) === '') {
		$commentError = 'You forgot to enter a message!';
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['comments']));
		} else {
			$comments = trim($_POST['comments']);
		}
	}
		
	// upon no failure errors let's email now!
	if(!isset($hasError)) {
		
		$emailTo = 'youremail@test.com';
		$subject = 'Submitted message from '.$name;
		$sendCopy = trim($_POST['sendCopy']);
		$body = "Name: $name \n\nEmail: $email \n\nComments: $comments
		<p>This message was sent from the IP Address: {$ipaddress} on {$date} at {$time}</p>";
		$headers = 'From: ' .' <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;

		mail($emailTo, $subject, $body, $headers);
        
        // set our boolean completion value to TRUE
		$emailSent = true;
	}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootstrap, from Twitter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="assets/css/bootstrap.css" rel="stylesheet">
		<link href="assets/css/main.css" rel="stylesheet">
    
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

</head>

<body>
	<div class="container">

		<a href="#myModal" role="button"  class="btn"  id="test">Launch demo modal</a>

		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel">Get in touch</h3>
				
				

				<?php if(isset($emailSent) && $emailSent == true) { ?>
					<p class="info">Your email was sent.</p>
				<?php } else { ?>
          
				<div class="desc">
					<h2>Contact Us</h2>	
					<p class="desc">Please use the contact form below to send us any information we may need. It is required you place an e-mail, although if you do not need us to respond feel free to input noreply@yoursite.com.</p>
				</div>
			
				<div id="contact-form">
					<?php if(isset($hasError) || isset($captchaError) ) { ?>
						<p class="alert">Error submitting the form</p>
					<?php } ?>
				</div><!-- /#contact-form -->

			</div><!-- modal-header -->

			<div class="modal-body">
				<form id="contact-us" action="contact.php" method="post">
					<fieldset>

						<div class="control-group">
							<label class="control-label" for="name">Name</label>
							<div class="controls">
								<input type="text" name="contactName" id="contactName" value="<?php if(isset($_POST['contactName'])) echo $_POST['contactName'];?>" class="txt requiredField" placeholder="Name:" />
							</div>
							<?php if($nameError != '') { ?>
								<br /><span class="error"><?php echo $nameError;?></span> 
							<?php } ?>
						</div>

						<div class="control-group">
							<label class="control-label" for="email">Email</label>
							<div class="controls">
								<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']))  echo $_POST['email'];?>" class="txt requiredField email" placeholder="Email:" />
							</div>
							<?php if($emailError != '') { ?>
								<br /><span class="error"><?php echo $emailError;?></span>
							<?php } ?>
						</div>
	                      
						<div class="control-group">
							<label class="control-label" for="message">Message</label>
							<div class="controls">
								<textarea name="comments" id="commentsText" class="txtarea requiredField" placeholder="Message:"><?php if(isset($_POST['comments'])) { if(function_exists('stripslashes')) { echo stripslashes($_POST['comments']); } else { echo $_POST['comments']; } } ?></textarea>
							</div>
							<?php if($commentError != '') { ?>
								<br /><span class="error"><?php echo $commentError;?></span> 
							<?php } ?>
						</div>

						<div class="controls">
							<button type="submit" id="submit-button" class="btn btn-large btn-primary">Submit</button>
						</div> 

						<!-- <button name="submit" type="submit" class="subbutton">Send us Mail!</button> -->
						<input type="hidden" name="submitted" id="submitted" value="true" />
						<span id="loading"></span>
					</fieldset>

					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
						<!-- <button class="btn btn-primary">Save changes</button> -->
					</div>

				</form>
			</div><!-- /.modal-body -->

			<?php } ?>

		</div><!-- /#myModal -->
	</div><!-- /.container -->
	
<script type="text/javascript">
	<!--//--><![CDATA[//><!--
	$(document).ready(function() {
		
		$("#test").click(function() {
			// reset and show modal
			$('form#contact-us').slideDown(0);
			$('.tick').remove();
			$('form').find("input[type=text], textarea").val("");
		  $('#myModal').modal('show')
		});

		var loading = $('#loading');
		$('form#contact-us').submit(function() {
			$('form#contact-us .error').remove();
			var hasError = false;
			$('.requiredField').each(function() {
				if($.trim($(this).val()) == '') {
					var labelText = $(this).parent().prev('label').text();
					$(this).parent().append('<span class="error">Your forgot to enter your '+labelText+'.</span>');
					$(this).addClass('inputError');
					hasError = true;
				} else if($(this).hasClass('email')) {
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
					if(!emailReg.test($.trim($(this).val()))) {
						var labelText = $(this).prev('label').text();
						$(this).parent().append('<span class="error">Sorry! You\'ve entered an invalid '+labelText+'.</span>');
						$(this).addClass('inputError');
						hasError = true;
					}
				}
			});
			if(!hasError) {
				loading.show();
				var formInput = $(this).serialize();
				$.post($(this).attr('action'),formInput, function(data){
					loading.hide();
					$('form#contact-us').slideUp("fast", function() {				   
						$(this).before('<p class="tick"><strong>Thanks!</strong> Your email has been delivered. Huzzah!</p>');
					});
					
				});
			}
			
			return false;	
		});
	});
	//-->!]]>
</script>

</body>
</html>