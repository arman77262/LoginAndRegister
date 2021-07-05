<?php  

    include_once 'lib/Database.php';
    include_once 'helpers/Fromat.php';

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    

    class PasswordReset{

        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Fromat();
        }

        public function passwordReset($email){

            /* Email Send Code Start */

            function send_password_reset($name, $get_email, $token){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;

                $mail->Host  = 'smtp.gmail.com';                                  
                $mail->Username = 'robartjack79@gmail.com';                     
                $mail->Password  = '7726264621';
                
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                
                $mail->setFrom('robartjack79@gmail.com', $name);
                $mail->addAddress($get_email);

                $mail->isHTML(true);                                
                $mail->Subject = 'Reset Password Notification From Web Master';

                $email_template = "
                    <h2>You have register with web master</h2>
                    <h5>You are receivin an email for password reset</h5>
                    <a href='http://localhost/login/password-change.php?token=$token&email=$get_email'>Click Here</a>
                ";

                $mail->Body = $email_template;
                $mail->send();
            }

            /* Email Send Code End */

            $email = $this->fr->validation($email);
            $email = mysqli_real_escape_string($this->db->link, $email);
            $token = md5(rand());

            if (empty($email)) {
                $error = "Email fild must not be empty";
                return $error;
            }else {
                $check_email = "SELECT * FROM tbl_user WHERE email='$email'";
                $email_result = $this->db->select($check_email);

                if (mysqli_num_rows($email_result) > 0) {
                    
                    $row = mysqli_fetch_assoc($email_result);
                    $name = $row['name'];
                    $get_email = $row['email'];
                    $update_token = "UPDATE tbl_user SET verify_tokern = '$token' WHERE email='$get_email' LIMIT 1";
                    $update_result = $this->db->update($update_token);

                    if ($update_result) {
                        
                        send_password_reset($name, $get_email, $token);
                        $success = "Password Reset Email Send In Your Email";
                        return $success;

                    }else {
                        $error = "Something wrong token is not updated";
                    }


                }else {
                    $error = "Email Not Found";
                    return $error;
                }
            }

        }
    }

?>