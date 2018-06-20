<?php
/* Volunteer Page Template */

get_header();

?>
    <div class="container">
        <div class="volunteer_wrapper">
            <div class="volunteer_text_box">
                <h1>Volunteer for Us!</h1>
                    <h2>Strapped for Cash But Have Time to Give? We Want to Hear from You!</h2>
                        <p>We are always looking for volunteers, so let us know about your skills, interests and availability. If you register as a Friend of HELP (below), we'll also keep you in touch about events and activities we're organising - and how you can get
                        involved - or you can even organise your own. We invite you to be part of HELP. Part of changing the future. Because it’s too important not to be.</p>
                    <h2>The New Way to Support Us​​</h2>
                        <p>On the 18th of May, 2017, we launched our 'Become A Friend of HELP' campaign at a gathering of friends and supporters. Picture Becoming A Friend of HELP is the new way for you to volunteer for us. It's one of the ways you can HELP us achieve
                        our vision of A Wellington Free from Sexual Violence. As a volunteer, you may have exactly the skills we are looking for! As a small robust charity, we have skill needs right across the board. Right, enough from us, it's time to hear from
                        you!</p>
                    <h2>Become A Friend of HELP & Register to Volunteer</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-8 col-sm-offset-2">
                     <div class="volunteer_form_box">
                    
                        <form action="" method="POST">
                            <input placeholder="Full Name" class='form_fields' type="text" name="fullName"> <br> 
                            <input placeholder="Email" class='form_fields' type="text" name="email"> <br>
                            <input placeholder="Phone number" class='form_fields' type="text" name="phone"> <br>
                            <input placeholder="Address" class='form_fields' type="text" name="address"> <br> 
                            <textarea placeholder="What Skills/Experience Do You Think You Can Offer Us?" name="message"></textarea><br>
                            <button class='contact_button' type="submit" name="submit_two">Submit</button>
                        </form>

                            <?php
                                global $wpdb;
                                if (isset($_POST['submit_two'])) {
                                    $fullName = esc_attr($_POST['fullName']);
                                    $email = sanitize_email($_POST['email']);
                                    $phone = esc_attr($_POST['phone']);
                                    $address = esc_attr($_POST['address']);
                                    $message = esc_attr($_POST['message']);
                                    // echo $username, $email, $password, $confpass;
                                    $error=array();
                                    
                                    if (empty($fullName)) {
                                            $error['username_empty']="Username required";
                                            echo "Username required"; ?><br><?php
                                    }
                                    if (empty($email)) {
                                        $error['email_empty']="Email required";
                                        echo "Email required";?><br><?php
                                    }
                                    if (!is_email($email)){
                                        $error['email_valid']="Email has missing @";
                                        echo "Email has missing @";?><br><?php
                                    }
                                    if (empty($phone)) {
                                        $error['phone_empty']="Phone number required";
                                        echo "Phone number required";?><br><?php
                                    }
                                    if (empty($message)) {
                                        $error['message_empty']="Message required";
                                        echo "Message required";?><br><?php                             
                                    } else {

                                    }
                                }
                            ?>

                            <?php
                                if (isset($_POST['submit_two'])) {
                                        
                                    global $wbdb;
                                    
                                    $data_array_two = array (
                                                
                                                'fullName'=>$_POST['fullName'],
                                                'email'=>$_POST['email'],
                                                'phone'=>$_POST['phone'],
                                                'address'=>$_POST['address'],
                                                'message' =>$_POST['message']

                                                    );

                                    $table_name_two='volunteer';

                                    $Result_two=$wpdb->insert($table_name_two, $data_array_two,$format=NULL);

                                    if($Result_two==1){
                                        ?>

                                        <div class="show_success"> <?php echo "Thank you for volunteering, we will be in touch shortly!"; ?></div>
                                        <?php 
                                        
                                    }else {
                                        echo "Error in from submission";
                                        }		
                                }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>