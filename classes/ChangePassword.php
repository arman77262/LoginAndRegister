<?php 

    include_once 'lib/Database.php';
    include_once 'helpers/Fromat.php';

    class ChangePassword{
        
        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Fromat();
        }

        public function changePassword($data){

            $email = $this->fr->validation($data['email']);
            $newPassword = $this->fr->validation(md5($data['password']));
            $c_password = $this->fr->validation(md5($data ['c_password']));
            $token = $this->fr->validation($data['password_token']);

            if (!empty($token)) {
                
                if (!empty($email) || !empty($newPassword) || !empty($c_password)) {
                    
                    //check token
                    $token_query = "SELECT verify_tokern FROM tbl_user WHERE verify_tokern = '$token' LIMIT 1";
                    $token_result = $this->db->select($token_query);

                    if (mysqli_num_rows($token_result) > 0) {
                        
                        if ($newPassword == $c_password) {
                            
                            $update_password = "UPDATE tbl_user SET password='$newPassword' WHERE verify_tokern = '$token' LIMIT 1";
                            $update_password_run = $this->db->update($update_password);

                            if ($update_password_run) {
                                
                                $new_token = md5(rand());
                                $token_query = "UPDATE tbl_user SET verify_tokern='$new_token' WHERE verify_tokern = '$token' LiMIT 1";

                                $update_token = $this->db->update($token_query);

                                $success = "New Password Susscessfully Updated";
                                return $success;
                            }else {
                                $error = "Something Wrond Password is not Updated";
                                return $error;
                            }

                        }else {
                            $error = "Password And Confirm Password Does Not Match";
                            return $error;
                        }

                    }else {
                        $error = "Invalid Token";
                        return $error;
                    }

                }else {
                    $error = "All Fild are required";
                    return $error;
                }

            }else {
                $error = "Token is not Available";
                return $error;
            }
        }

    }

?>