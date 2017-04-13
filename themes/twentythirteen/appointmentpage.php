<?php

/*
Template Name: Appointment page
*/

  //response generation function


$getsubject = $_GET['entry_0'];
if(isset($_POST['appointmentsubject'])){
  $getsubject =$_POST['appointmentsubject'];
      }



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
  $message_sent    = "Your Message is being sent...";

  //user posted variables



// validation
$validationOK=true;
if (!$validationOK) {
  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
  exit;
}





$EmailFrom = "susan@liberatedliving.ca";
$EmailTo = "susan@liberatedliving.ca";

$name = $_POST['message_name'];
$email = $_POST['message_email'];
$phonenumber = $_POST['message_phone'];
$appointmentsubject = $_POST['appointmentsubject'];
$contactmethod = $_POST['contactmethod'];
$bestcontacttime = "\n".$_POST['bestcontacttime1']."\n".$_POST['bestcontacttime2']."\n".$_POST['bestcontacttime3']."\n".$_POST['bestcontacttime4'];



  $message = $_POST['message_text'];
  $human = $_POST['message_human'];

  // prepare email body text
$Body = "";
$Body .= "From: www.LiberatedLiving.ca ".$appointmentsubject." Appointment Page.";
$Body .= "\n";
$Body .= "\n";
$Body .= "Form Type: ";
$Body .= $appointmentsubject;
$Body .= "\n";
$Body .= "\n";
$Body .= "Name: ";
$Body .= $name;
$Body .= "\n";
$Body .= "\n";
$Body .= "Email: ";
$Body .= $email;
$Body .= "\n";
$Body .= "\n";
$Body .= "Phone Number: ";
$Body .= $phonenumber;
$Body .= "\n";
$Body .= "\n";
$Body .= "Preferred Contact Method: ";
$Body .= $contactmethod;
$Body .= "\n";
$Body .= "\n";
$Body .= "Preferred Time: ";
$Body .= $bestcontacttime;
$Body .= "\n";
$Body .= "\n";
$Body .= "Message: ";
$Body .= $message;
$Body .= "\n";

  //php mailer variables
  $to = get_option('admin_email');
  $subject = get_bloginfo('name')." ".$getsubject.' Appointment Form application.' ;
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 3) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          // $sent = mail($EmailTo, $subject, $Body, "From: <$email>");
          $sent = wp_mail($EmailTo, $subject, $Body, $headers = '', $attachments = array());
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);


 // redirect to success page 
if ($sent){
  print "<meta http-equiv=\"refresh\" content=\"0;URL=thank-you\">";

}


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
                  margin-top:50px;
                }

                .success{
                  padding: 5px 9px;
                  border: 1px solid green;
                  color: green;
                  border-radius: 3px;
                  margin-top:50px;
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

                    <h2><?php echo $getsubject; ?> Appointment Form</h2>
                    <hr />

                       <div class="form-group">
                            <label for="name">
                                First and Last Name</label>
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
                            <label for="phone">
                                Phone Number (Not required)</label>
                            <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="message_phone" value="<?php echo esc_attr($_POST['message_phone']); ?>">
                        </div>


                        <div class="form-group">
                            <input type="hidden" class="form-control" id="appointmentsubject" placeholder="Subject" required="required" name="appointmentsubject" value="<?php echo $getsubject ?>" >
                        </div>

                        <div class="form-group">
                            <label for="contactmethod">
                                Best Way to Contact You</label>  
                                <hr / style="margin-bottom:-10px;">                                                    
                            <input type = "radio"
                                   name = "contactmethod"
                                   id = "contactmethodphone"
                                   value = "Phone"
                                   checked = "checked" />
                            <label for = "phone">Phone</label>
                            <br />
                            
                            <input type = "radio"
                                   name = "contactmethod"
                                   id = "contactmethodemail"
                                   value = "Email" />
                            <label for = "email">Email</label>
                            <br />
                            <input type = "radio"
                                   name = "contactmethod"
                                   id = "contactmethodskype"
                                   value = "Skype" />
                            <label for = "skype">Skype</label>
                        </div>




                        <div class="form-group">
                            <label for="phone">
                                Preferred Time to Contact You</label>  
                                <hr / style="margin-bottom:-10px;">                                                    
                            <input type = "checkbox"
                                   name = "bestcontacttime1"
                                   id = "bestcontacttime"
                                   value = "Weekday morning 8:00am-12pm"
                                   checked = "checked" />
                            <label for = "phone">Weekday morning 8:00am-12pm</label>
                            <br />
                            
                            <input type = "checkbox"
                                   name = "bestcontacttime2"
                                   id = "bestcontacttime"
                                   value = "Weekday Afternoon 12-5pm" />
                            <label for = "email">Weekday Afternoon 12-5pm</label>
                            <br />
                            <input type = "checkbox"
                                   name = "bestcontacttime3"
                                   id = "bestcontacttime"
                                   value = "Weekday After Work 5:00pm +" />
                            <label for = "skype">Weekday After Work 5:00pm +</label>
                            <br />  
                            <label for = "email">Other time</label> 
                            <input type="text" class="form-control" id="bestcontacttime" placeholder="Preferred  Contact Time"  name="bestcontacttime4" value="<?php echo esc_attr($_POST['bestcontacttime']); ?>">                    

                            
                            

                        </div>





                        <div class="form-group">
                            <label for="name">
                                Additional Information (Not required)</label>
                            <textarea id="message" class="form-control" rows="9" cols="25" 
                                placeholder="Message" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                        </div>


                        <label for="message_human">3 plus 2 minus 2 =  (Simple Spam Checker)</label>
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

		</br></br></br></br></br>










		

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

