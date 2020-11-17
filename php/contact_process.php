<?php

$has_error= FALSE;

if (isset($_POST['submit'])) {
           
    if(empty($_POST['name'])){
        $error_name = "Please enter full name!";
        $has_error= TRUE;
    } 
    else {
        $name= filterUserInput($_POST['name']);
    }

    if(empty($_POST['email'])){
        $error_email = "Please enter email";
        $has_error= TRUE;
    } elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $error_email = "Please enter valid email!";
        $has_error= TRUE;
    } 
    else {
        $email= filterUserInput($_POST['email']);
    }

    if(empty($_POST['reason'])){
        $error_reason = "Please select a reason!";
        $has_error= TRUE;
    } 
    else {
        $reason = filterUserInput($_POST['reason']);
        
    }

    if(empty($_POST['message'])){
        $error_message = "Please write your message!";
        $has_error= TRUE;
    } 
    else {
        $message = filterUserInput($_POST['message'], "message");        
    }
    
    if(!$has_error) {
    
        //* admin email address
        $to = 'admin@opeldo.com';
        $subject = "Message from opeldo user - $reason ";

        //* add div with inline style.
        $email_message = "<div style='width: 80%"
                       . "margin:100px auto;"
                       . "padding:100px;"
                       . "background-color:lightblue;"
                       . "padding: 20px;"
                       . "font-weight:bold;"
                       . "border: 10px solid maroon;"
                       . "border-radius: 5px;"
                       . "-webkit-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);"
                       . "-moz-box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);"
                       . "box-shadow: 10px 10px 5px 0px rgba(0,0,0,0.75);'>";

        //* create email headers
        //* separated headers components with a CRLF (\r\n) 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        //? other headers
        // $headers .= "From: ". $email . "\r\n" ;
        // $headers .= "Cc: admin@opeldo.com" . "\r\n";
        // $headers .= "Reply-To: admin@opeldo.com". " \r\n" ;

        if (isset($_POST['send_copy'])) {
            $headers .= "From: admin@opeldo.com" . "\r\n" 
                      . "CC: $email";
        } 
        else{
            $headers .= "From: admin@opeldo.com" . "\r\n" ;
        }

        //* add a logo ... must be hosted in a live domain (not in localhost)
        $email_message .= "<center><img src='https://www.opeldo.com/public/images/tech_logo2.png'"
                        . "alt='logo' style='border-radius: 5px; width:150px;height:80px;'/>"
                        . "</center><br>";

        //* add form data and close $email_message div
        $email_message .= "Name : $name <br> <br>"
                        . "Email : $email <br> <br>"
                        . "Subject : $subject <br><br>"
                        . "Message : ".stripslashes($message)."<br> " 
                        . "Regards $name"."\r\n </div>";
    
        //* send email
        if (  mail($to, $subject, $email_message, $headers ) ) {            
            //* if mail() succeeds, insert into db            
            $sql = "INSERT INTO contact (name, email, reason, message) 
                    VALUES(?, ?, ?, ?)";

            if ($stmt_obj = mysqli_prepare($conn,$sql)) {
                //* bind values to the prepared statement object
                mysqli_stmt_bind_param($stmt_obj,'ssss',$name, $email, $reason, $message);
                $result_obj = mysqli_stmt_execute($stmt_obj);

                if (mysqli_affected_rows($conn)<1) {
                    $confirm_msg = "<div class='alert alert-danger text-center' role='alert'>"
                                 . "Problem inserting data to database!"
                                 . "</div>";
                } 
                else {
                    $confirm_msg = "<div class='alert alert-success text-center' role='alert'>"
                                 . "Hi ".ucfirst($name).", we have received your message, we will reply to you shortly!"
                                 . "</div>";
                }                  
            }                             
        } 
        else {
            $confirm_msg = "<div class='alert alert-danger text-center' role='alert'>"
                         . "Problem sending email"
                         . "</div>";
        }
    }            
}
    
?>