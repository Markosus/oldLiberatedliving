<?php

/*
Template Name: Cotactpage
*/

  //response generation function

  $response = "";

  //function to generate response
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='success'>{$message}</div>";
    else $response = "<div class='error'>{$message}</div>";

  }





  //response messages
  $not_human       = "Human verification incorrect.";
  $missing_content = "Please supply all information.";
  $email_invalid   = "Email Address Invalid.";
  $message_unsent  = "Message was not sent. Try Again.";
  $message_sent    = "Thanks! Your message has been sent.";

  //user posted variables



// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}





$EmailFrom = ".com";
$EmailTo = "mark2002david@hotmail.com";
  $name = $_POST['message_name'];
  $email = $_POST['message_email'];
  $message = $_POST['message_text'];
  $human = $_POST['message_human'];

  // prepare email body text
$Body = "";
$Body .= "From: www.LiberatedLiving.ca Contact Page. ";

$Body .= "\n";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "Subject: ";
$Body .= $subject;
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

  //php mailer variables
  $to = get_option('admin_email');
  $subject = "You have received a message from ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 7) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name) || empty($message)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          $sent = mail($EmailTo, $subject, $Body, "From: <$Email>");
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);


 


get_header(); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		<div class="container">


		





				<style type="text/css">
                .error{
                  padding: 5px 9px;
                  border: 1px solid red;
                  color: red;
                  border-radius: 3px;
                }

                .success{
                  padding: 5px 9px;
                  border: 1px solid green;
                  color: green;
                  border-radius: 3px;
                }

                form span{
                  color: red;
                }
              </style>



<div class="contactcontainer" style="margin-top:-70px;">

            
<div class="row">
        <div class="col-md-6">
            <!-- <div class="well well-sm"> -->

              
                <?php echo $response; ?>
                <form action="<?php the_permalink(); ?>" method="post">

                <div class="row">
                    <div class="col-md-12">

                       <div class="form-group">
                            <label for="name">
                                Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter name" required="required" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
                        </div>

                          <div class="form-group">
                            <label for="email">
                                Email Address</label>
                            <div class="input-group">
                                <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span>
                                </span>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" required="required" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>"></div>
                        </div>

                        <div class="form-group">
                            <label for="name">
                                Message</label>
                            <textarea id="message" class="form-control" rows="9" cols="25" required="required"
                                placeholder="Message" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                        </div>

                        <label for="message_human">3 plus 2 plus 2 =  (Simple Spam Checker)</label>
				        <div class="input-group">
				          <input type="text" class="form-control" id="message_human" name="message_human">
				          
                  		  <input type="hidden" name="submitted" value="1">
				          <span class="input-group-addon"><i class="glyphicon glyphicon-ok form-control-feedback"></i></span></div>
		
				          	</br>
				       <div class="col-md-12">
                        <button type="submit" class="btn btn-primary pull-right" id="btnContactUs" style="margin-right:-15px">
                            Send Message</button>
                    </div>
                </form>
				      
				   
</div></div> </div> 
                  
                  
                  
                  
              <!-- </div> -->
















		</div> <!-- end container -->

		</br></br></br>










		

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

