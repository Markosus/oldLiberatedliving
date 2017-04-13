<?php

/*
Template Name: test
*/

  //response generation function

  




$forename = $_GET['entry_0'];
$surname = $_GET['entry_1'];





 


get_header(); ?>

  <div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">

    <div class="container">


    
<input id='forename' type='text' value='<?php echo $forename; ?>' readonly >
<input id='surname' type='text' value='<?php echo $surname; ?>'  readonly>




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



<div class="contactcontainer">

            
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

                        <label for="message_human">3 + 2 + 2 =  (Simple Spam Checker)</label>
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

<?php get_footer(); ?>

