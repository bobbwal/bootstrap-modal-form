<?php session_start(); ?>
<!doctype html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">	
    <title>Bootstrap HTML5 Contact Form</title>
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
    <script src="js/libs/modernizr-1.7.min.js"></script>
</head>

<body>
    <div id="container">
        <div id="contact-form" class="clearfix">

            <a href="#myModal" role="button" class="btn" data-toggle="modal" id="test">Launch demo modal</a>

            <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Get in touch</h3>

                    <p>Fill out our super swanky HTML5 contact form below to get in touch with us! Please provide as much information as possible for us to help you with your enquiry :)</p>
                   
                </div><!-- modal-header -->

                <div class="modal-body">
                    
                 <?php
                    //init variables
                    $cf = array();
                    $sr = false;
                    
                    if(isset($_SESSION['cf_returndata'])){
                        $cf = $_SESSION['cf_returndata'];
                        $sr = true;
                    }
                    ?>
                    <ul id="errors" class="<?php echo ($sr && !$cf['form_ok']) ? 'visible' : ''; ?>">
                        <!-- <li id="info">There were some problems with your form submission:</li> -->
                        <?php 
                        if(isset($cf['errors']) && count($cf['errors']) > 0) :
                            foreach($cf['errors'] as $error) :
                        ?>
                        <li><?php echo $error ?></li>
                        <?php
                            endforeach;
                        endif;
                        ?>
                    </ul>
                    <p id="success" class="<?php echo ($sr && $cf['form_ok']) ? 'visible' : ''; ?>">Thanks for your message! We will get back to you ASAP!</p>
                    
                    <form method="post" action="process.php">

                        <fieldset>
                            <label for="name">Name: <span class="required">*</span></label>
                            <input class="input-xlarge" type="text" id="name" name="name" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['name'] : '' ?>" placeholder="John Doe" required autofocus />
                            
                            <label for="email">Email Address: <span class="required">*</span></label>
                            <input class="input-xlarge" type="email" id="email" name="email" value="<?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['email'] : '' ?>" placeholder="johndoe@example.com" required />
                            
    <!--                    <label for="telephone">Telephone: </label>
                            <input type="tel" id="telephone" name="telephone" value="<?php //echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['telephone'] : '' ?>" />
                            
                            <label for="enquiry">Enquiry: </label>
                            <select id="enquiry" name="enquiry">
                                <option value="General" <?php //echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['enquiry'] == 'General') ? "selected='selected'" : '' ?>>General</option>
                                <option value="Sales" <?php //echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['enquiry'] == 'Sales') ? "selected='selected'" : '' ?>>Sales</option>
                                <option value="Support" <?php //echo ($sr && !$cf['form_ok'] && $cf['posted_form_data']['enquiry'] == 'Support') ? "selected='selected'" : '' ?>>Support</option>
                            </select>
     -->                        
                            <label for="message">Message: <span class="required">*</span></label>
                            <textarea id="message" name="message" class="input-xlarge" placeholder="Your message must be greater than 20 charcters" required data-minlength="20"><?php echo ($sr && !$cf['form_ok']) ? $cf['posted_form_data']['message'] : '' ?></textarea>

                        </fieldset>

                        <span id="loading"></span>
                        <input type="submit" value="Submit" id="submit-button" class="btn btn-primary"/>
                        <p id="req-field-desc"><span class="required">*</span> indicates a required field</p>

                    </form>
                    <?php unset($_SESSION['cf_returndata']); ?>

                </div><!-- /.modal-body -->

            </div><!-- /#myModal -->

        </div><!-- /#contact-form -->
    </div><!-- /#container -->

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/libs/jquery-1.9.0.min.js"><\/script>')</script>
    <script src="assets/js/bootstrap.min.js"></script>
	<!-- // <script src="js/plugins.js"></script> -->
	<script src="js/script.js"></script>

	<!--[if lt IE 7 ]>
	<script src="js/libs/dd_belatedpng.js"></script>
	<script> DD_belatedPNG.fix('img, .png_bg');</script>
	<![endif]-->
</body>
</html>