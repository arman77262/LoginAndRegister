<?php
    //$filepath = realpath(dirname(__FILE__));
    
    if (!session_id()) {
    require_once ('lib/Session.php');
    Session::loginCheck();
    }
    
    
    include_once 'lib/Database.php';
    include_once 'helpers/Fromat.php';

    class AdminLogin{
        public $db;
        public $fr;

        public function __construct()
        {
            $this->db = new Database();
            $this->fr = new Fromat();
        }

        public function adminLogin($email, $password){
            $email = $this->fr->validation($email);
            $password = $this->fr->validation($password);

            if (empty($email) || empty($password)) {
                $loginMsg = "Email And Password Fild Must Not Be Empty !";;
                return $loginMsg;
            }else {
                $select_query = "SELECT * FROM tbl_user WHERE email='$email' AND password = '$password' LIMIT 1";
                $select_result = $this->db->select($select_query);

                if (mysqli_num_rows($select_result) > 0) {
                    $row = mysqli_fetch_assoc($select_result);
                    
                    if ($row['v_status'] == 1) {
                         Session::set('login', true);
                         Session::set('username', $row['name']);
                         Session::set('phone', $row['phone']);
                         Session::set('email', $row['email']);
                         header('Location:dashboard.php');
                    }else {
                        $loginMsg = "Please First Verify Your Email To Login";
                        return $loginMsg;
                    }

                }else {
                    $loginMsg = "Invalid Email Or Password";
                    return $loginMsg;
                }
            }
        }
    }

?>