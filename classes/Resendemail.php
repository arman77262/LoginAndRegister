<?php 

    include_once 'lib/Database.php';
    include_once 'helpers/Fromat.php';

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    class Resendemail{

        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Fromat();
        }

        public function resendEmail($email){

            function resend_email_verify($name, $email, $verify_tokern){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth = true;

                $mail->Host  = 'smtp.gmail.com';                                  
                $mail->Username = 'robartjack79@gmail.com';                     
                $mail->Password  = '7726264621';
                
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;
                
                $mail->setFrom('robartjack79@gmail.com', $name);
                $mail->addAddress($email);

                $mail->isHTML(true);                                
                $mail->Subject = 'Resend - Email Varification From Web Master';

                $email_template = "
                    <h2>You have register with web master</h2>
                    <h5>Verify your email address to login please click the link below</h5>
                    <a href='http://localhost/login/verify-email.php?token=$verify_tokern'>Click Here</a>
                ";

                $mail->Body = $email_template;
                $mail->send();
                //echo "Email has benn sent";
            }

            $email = $this->fr->validation($email);
            $email = mysqli_real_escape_string($this->db->link, $email);

            if (empty($email)) {
               $rerror = "Email Fild Must Not Be Empty";
               return $rerror;
            }else {
                $checkEmail = "SELECT * FROM tbl_user WHERE email='$email' LIMIT 1";
                $emailResult = $this->db->select($checkEmail);

                if (mysqli_num_rows($emailResult) > 0) {
                    
                    $row = mysqli_fetch_assoc($emailResult);
                    if ($row['v_status'] == 0) {
                        
                        $name = $row['name'];
                        $email = $row['email'];
                        $verify_tokern = $row['verify_tokern'];

                        resend_email_verify($name, $email, $verify_tokern);
                        $rerror = "Verification email link has been sent in your email";
                        return $rerror;
                        header('Location:login.php');

                    }else{
                        $rerror = "Email Already Erified Please Login";
                        return $rerror;
                        header('Location:resend-email.php');
                    }

                }else {
                    $rerror = "Email Is not resister please resister first";
                    return $rerror;
                }

            }
        }

    }

?>