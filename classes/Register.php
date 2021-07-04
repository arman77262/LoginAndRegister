<?php 

    include_once 'lib/Database.php';
    include_once 'helpers/Fromat.php';

    require 'PHPMailer/PHPMailer.php';
    require 'PHPMailer/Exception.php';
    require 'PHPMailer/SMTP.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    

    
    class Register {
        
        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Fromat();
        }

        public function insertData($data){
            
            function sendemail_verify($name, $email, $verify_token)
            {
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
                $mail->Subject = 'Email Varification From Web Master';

                $email_template = "
                    <h2>You have register with web master</h2>
                    <h5>Verify your email address to login please click the link below</h5>
                    <a href='http://localhost/login/verify-email.php?token=$verify_token'>Click Here</a>
                ";

                $mail->Body = $email_template;
                $mail->send();
                //echo "Email has benn sent";

            }


            $name = $this->fr->validation($data['name']);
            $phone = $this->fr->validation($data['phone']);
            $email = $this->fr->validation($data['email']);
            $password = $this->fr->validation(md5($data['password']));
            $verify_token = md5(rand());

            $check_email_query = "SELECT * FROM tbl_user WHERE email='$email' LIMIT 1";
            $check_email = $this->db->select($check_email_query);

            if (isset($check_email) > 0) {
                $error = "This email Id Already Exisit";
                return $error;
                header('Location:register.php');
            }else {
                $insert_query = "INSERT INTO tbl_user(name, email, phone, password, verify_tokern) VALUES('$name', '$email', '$phone', '$password', '$verify_token')";
                $insert_row = $this->db->insert($insert_query);

                if ($insert_row) {
                    sendemail_verify($name, $email, $verify_token);
                    $success = "Registration successfully. Please check your email address for verify email";
                    return $success;
                    header('Location:register.php');
                }else {
                    $error = "Registration Failed";
                    return $error;
                }
            }
        }

    }
    
?>