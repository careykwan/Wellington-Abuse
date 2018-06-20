<?php
/* Contact Page Template */

get_header();

?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <div class="contact_container">
                    <h2>Our Wellington Office</h2>
                        <p>Monday to Friday 9am - 5pm<br><br> ​Education House Level 7<br> 178-182 Willis Street<br> Wellington
                            <br><br> Office: 04 801 6655<br><br> PO Box 11160<br> Manners St <br> Wellington 6142</p>

                    <h2>Our Porirua Office</h2>
                        <p>Monday to Thursday 9am - 4.30pm<br><br> ​46 Mungavin Avenue<br> Porirua East<br> Porirua​
                            <br><br> Office: 04 237 8822</p>
                                <?php get_sidebar('main-sidebar'); ?>
                </div>
            </div>
        
            <div class="col-md-6 col-12">
                <div class="form_container">
                    <div class='contact_form'>
                        <h2>Our 24/7 Crisis Support Line</h2>
                            <p>If you find yourself needing to talk to someone, we are here to listen and help 24 hours a day, 7 days a week. Our crisis support line is for you. When calling you can expect to be believed, supported, and listened to. Just call: 04 801
                            6655 and push '0' at the menu.
                            </p>

                        <h2>Need Our HELP? Get In Touch</h2>

                            <form action="" method="POST">
                                <input placeholder="Full Name" id="fullName" class='form_fields' type="text" name="fullName"> <br> 
                                <input placeholder="Email" id="email" class='form_fields' type="text" name="email"> <br>
                                <input placeholder="Phone number" id="contact" class='form_fields' type="text" name="contact">
                                <br>
                                <textarea placeholder="How can we help you?" id="message" name="message"></textarea><br>
                                <button class='contact_button' type="submit" name="submit">Submit</button>
                            </form>

                                <?php
                                    global $wpdb;
                                        if (isset($_POST['submit'])) {
                                            $fullName = esc_attr($_POST['fullName']);
                                            $email = sanitize_email($_POST['email']);
                                            $contact = esc_attr($_POST['contact']);
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
                                            if (empty($contact)) {
                                                $error['contact_empty']="Phone number required";
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
                                    if (isset($_POST['submit'])) {
                                            
                                        global $wbdb;
                                        
                                        $data_array = array (
                                                    
                                                    'fullName'=>$_POST['fullName'],
                                                    'email'=>$_POST['email'],
                                                    'contact'=>$_POST['contact'],
                                                    'message' =>$_POST['message']

                                                        );

                                        $table_name='contact_form';

                                        $Result=$wpdb->insert($table_name, $data_array,$format=NULL);

                                        if($Result==1){
                                            ?>

                                            <div class="show_success"> <?php echo "Thank you for contacting us, we will be in touch shortly!"; ?></div>
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